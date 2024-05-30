<?php

namespace App\Http\Controllers;

use App\Constants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Username or password is invalid'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        $userAbility = [
            [
                'action' => 'manage',
                'subject' => 'member',
            ]
        ];

        if ($user->role_id === Constants::USER_ADMIN) {
            $userAbility = [
                [
                    'action' => 'manage',
                    'subject' => 'admin',
                ]
            ];
        }

        return response()->json([
            'accessToken' => $token,
            'token_type' => 'Bearer',
            'userData' => $user,
            'userAbilityRules' => $userAbility
        ]);
    }

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
        ]);

        $user = new User([
            'name'  => $request->firstName . ' ' . $request->lastName,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => Constants::USER_MEMBER
        ]);

        if ($user->save()) {
            $credentials = request(['email', 'password']);
            Auth::attempt($credentials);

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            $userAbility = [
                [
                    'action' => 'manage',
                    'subject' => 'member',
                ]
            ];

            return response()->json([
                'message' => 'Successfully registered',
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'userData' => $user,
                'userAbilityRules' => $userAbility
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
