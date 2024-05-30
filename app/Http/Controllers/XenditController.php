<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Subscription;
use App\Models\SubscriptionToken;
use App\Models\User;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class XenditController extends Controller
{
    public function createPlan(Request $request, Member $member, Subscription $subscription)
    {
        $subscriptionToken = $this->generateToken();
        SubscriptionToken::create([
            'subscription_id' => $subscription->id,
            'token' => $subscriptionToken
        ]);

        $items = [];

        $items[] =  [
            "type" => "DIGITAL_PRODUCT",
            "name" => $request->selectedTerm['product_name'] . '-' . $request->selectedTerm['name'],
            "net_unit_amount" => $subscription->plan_cost,
            "quantity" => 1,
            "category" => "Health"
        ];

        if ($request->dependents) {
            $items[] =  [
                "type" => "DIGITAL_PRODUCT",
                "name" => 'Dependent',
                "net_unit_amount" => $request->selectedTerm['dependentPrice'],
                "quantity" => count($request->dependents),
                "category" => "Health"
            ];
        }

        $payload = [
            "reference_id" => 'ksf_subscription_' . $subscription->id,
            "customer_id" => $member->xendit_customer_id,
            "recurring_action" => "PAYMENT",
            "currency" => "PHP",
            "amount" => $subscription->price,
            "schedule" => [
                "reference_id" => 'ksf_schedule_' . $subscription->id,
                "interval" => "MONTH",
                "interval_count" => $subscription->billing_cycle,
                "anchor_date" => date("Y-m-d\TH:i:s\Z"),
                "retry_interval" => "DAY",
                "retry_interval_count" => 5,
                "total_retry" => 5,
                "failed_attempt_notifications" => [2, 4]
            ],
            "immediate_action_type" => "FULL_AMOUNT",
            "notification_config" => [
                "recurring_created" => ["WHATSAPP", "EMAIL"],
                "recurring_succeeded" => ["WHATSAPP", "EMAIL"],
                "recurring_failed" => ["WHATSAPP", "EMAIL"],
                "locale" => "en"
            ],
            "failed_cycle_action" => "STOP",
            "metadata" => null,
            "description" => "Membership Subscription",
            "items" => $items,
            'success_return_url' => env('VITE_APP_BASEURL') . '/registration/success/' . $subscriptionToken,
            'failure_return_url' => env('VITE_APP_BASEURL') . '/registration/failed/' . $subscriptionToken
        ];

        $response = $this->execute($payload, 'POST', env('XENDIT_CREATE_PLAN'));

        return $response;
    }

    public function createCustomer(Request $request, User $user)
    {
        $payload = [
            "reference_id" => 'ksf_user_id_' . $user->id . '_' . date('YmdHis'),
            "type" => "INDIVIDUAL",
            "individual_detail" => [
                "given_names" => $request->input('firstName'),
                "surname" => $request->input('lastName')
            ],
            "email" => $user->email
        ];

        $result = $this->execute($payload, 'POST', env('XENDIT_CREATE_CUSTOMER'));

        return $result;
    }

    public function execute($payload, $method, $endpoint, $headers = null): mixed
    {
        $credentials = base64_encode(env('XENDIT_API_KEY') . ':');
        if (!$headers) {
            $headers = array(
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $credentials
            );
        }

        $client = new Client();

        $response = $client->request($method, $endpoint, [
            'headers' => $headers,
            'verify' => false,
            'body' => json_encode($payload),
        ]);

        $statusCode = $response->getStatusCode();

        return json_decode($response->getBody()->getContents());
    }

    public function generateToken($length = 32)
    {
        try {
            // Generate random bytes
            $randomBytes = random_bytes($length / 2);
            // Convert to hexadecimal representation
            $token = bin2hex($randomBytes);
            return $token;
        } catch (Exception $e) {
            // Handle the exception
            return null;
        }
    }
}
