<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register Functionality to create Users
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
//            'password_confirmed' => 'confirmed',
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    /**
     * Login Users
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if(Auth::attempt($request->only('email', 'password'))){
            $request->session()->regenerate();
            return response()->json(Auth::user(), 200);
        }

        throw ValidationException::withMessages([
            'email' => ['Invalid Creds'],
        ]);
    }

    /**
     * Logout method
     * @param \Illuminate\Http\Request $request
     * @link https://laravel.com/docs/8.x/authentication#logging-out
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
