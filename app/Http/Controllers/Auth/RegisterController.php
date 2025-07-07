<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showPassengerForm()
    {
        return view('auth.register-passenger');
    }

    public function showDriverForm()
    {
        return view('auth.register-driver');
    }

    public function registerPassenger(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'role' => 'passenger',
            ]);

            Auth::login($user);

            return redirect()->route('passenger.dashboard')->with('success', 'Registration successful! Welcome to Xeddo!');
            
        } catch (\Exception $e) {
            \Log::error('Passenger registration failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function registerDriver(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'driver',
        ]);

        Auth::login($user);

        return redirect()->route('driver.dashboard')->with('success', 'Registration successful! Please complete your driver profile.');
    }
}
