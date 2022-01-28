<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\User;

class MobileAuthController extends Controller
{

    /**
     * Log in to the app
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
            'device-name' => 'required',
        ]);

        $user_name = $request->post('user_name');
        $password = $request->post('password');
        $deviceName = $request->post('device-name');

        // find the collector user with the user_name
        $user = User::where('user_name', $user_name)->where('roll_id', '4')->first();

        // check the password
        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'user_name' => ['The provided credentials are incorrect.'],
            ]);
        }

        // create the token
        $token = $user->createToken($deviceName)->plainTextToken;
        // return the token in the response
        return response()->json([
            "data" => [
                'token' => $token
            ]
        ]);
    }

    /**
     * Log out of the app
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoke the user's current token...
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json(['status' => 200, 'data' => 'Logged out successfully.']);
    }

    public function user(Request $request)
    {
        $user = $request->user();
        return response()->json(['data' => $user]);
    }
}
