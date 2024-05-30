<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Member;
use App\Constants;
use App\Models\PaymentTransaction;
use App\Models\SubscriptionToken;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {

        $xc = new XenditController();
        $user = User::find($request->userId);

        /* update or create member details */
        $mc = new MemberController();
        $member = $mc->store($request, $user);

        if (!$member->xendit_customer_id) {
            $xenditCustomer = $xc->createCustomer($request, $user);

            if (!$xenditCustomer) {
                return response()->json(['error' => 'Unable to register personal details']);
            }

            $member = $mc->updateXenditCustomerId($member, $xenditCustomer);
        }

        if (!$member) {
            return response()->json(['error' => 'Unable to register personal details', 500]);
        }

        /* update or create shipping address */
        $sac = new ShippingAddressController();
        $shippingAddress = $sac->store($request, $member);

        /* update or create shipping address */
        $sac = new MemberDependentController();
        $sac->store($request, $member);

        if (!$shippingAddress) {
            return response()->json(['error' => 'Something went wrong']);
        }

        /* update or create subscription */
        $sc = new SubscriptionController();
        $subscription = $sc->store($request, $member);

        if (!$subscription) {
            return response()->json(['error' => 'Something went wrong registering subscription']);
        }

        $xenditPlanResponse = $xc->createPlan($request, $member, $subscription);

        if (!$xenditPlanResponse) {
            return response()->json(['error' => 'Unable to register personal details', 500]);
        }

        PaymentTransaction::create([
            'transaction_id' => $xenditPlanResponse->id,
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'amount' => $xenditPlanResponse->amount,
            'payment_method' => $request->paymentMethod,
            'payment_date' => date('Y-m-d'),
            'status' => Constants::PAYMENT_STATUS_PENDING,
            'payload' => json_encode($xenditPlanResponse)
        ]);

        return response()->json([
            'message' => 'Successfully registered as member',
            'action' => $xenditPlanResponse ? $xenditPlanResponse->actions[0]->url : null,
        ], 201);
    }

    public function subscriptionByToken(Request $request, $token)
    {
        $subscription = Subscription::with(['member'])->select([
            'subscriptions.*',
            'subscription_tokens.is_used as isTokenUsed'
        ])
            ->join('subscription_tokens', 'subscription_tokens.subscription_id', 'subscriptions.id')
            ->where('token', $token)
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'Subscription not found!'
            ], 404);
        }

        if ($subscription->isTokenUsed <= 0) {
            $subscriptionToken = SubscriptionToken::where('token', $token)->first();

            if (!$subscriptionToken) {
                return response()->json([
                    'message' => 'Subscription not found!'
                ], 404);
            }

            $subscriptionToken->is_used = 1;
            $subscriptionToken->save();

            /* update payment transaction status */
            $transaction = PaymentTransaction::where('subscription_id', $subscription->id)->orderBy('id', 'desc')->first();
            $transaction->status = Constants::PAYMENT_STATUS_PAID;
            $transaction->save();

            $subscription->status = Constants::SUBSCRIPTION_STATUS_ACTIVE;
            $subscription->save();
        }

        $user = User::find($subscription->member->user_id);

        return response()->json([
            'data' => $subscription,
            'userData' => $user
        ]);
    }

    public function store(Request $request, Member $member)
    {
        $dependentCost = $request->dependents ? $request->selectedTerm['dependentPrice'] * count($request->dependents) : 0;
        $planCost = $request->selectedTerm['price'];
        $totalColst = $planCost + $dependentCost;

        return Subscription::updateOrCreate(
            [
                'member_id' => $member->id
            ],
            [
                'plan_id' => $request->selectedTerm['id'],
                'description' => $request->selectedTerm['name'],
                'member_id' => $member->id,
                'start_date' => date('Y-m-d H:i:s'),
                'status' => Constants::SUBSCRIPTION_STATUS_PENDING,
                'billing_cycle' => $request->selectedTerm['term'],
                'price' => $totalColst,
                'plan_cost' => $planCost,
                'dependent_cost' => $dependentCost,
                'auto_renewal' => 1,
            ]
        );
    }

    public function existingPendingSubscription(Member $member)
    {
        return Subscription::join('payment_transactions', 'payment_transactions.subscription_id', 'subscriptions.id')
            ->where('subscriptions.status', Constants::SUBSCRIPTION_STATUS_PENDING)
            ->where('payment_transactions.status', Constants::PAYMENT_STATUS_PENDING)
            ->where('subscriptions.member_id', $member->id)
            ->whereNotNull('payment_transactions.payload')
            ->first();
    }
}
