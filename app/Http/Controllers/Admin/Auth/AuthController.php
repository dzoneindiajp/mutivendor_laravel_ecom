<?php

namespace App\Http\Controllers\Admin\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\AuthRequest;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            return view('admin.auth.login');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function verifyLogin(AuthRequest $request)
    {
        try {
            // dd($request->all());
            $credentials = $request->only('email', 'password');
            $user = Auth::attempt($credentials);
            if ($user) {
                return redirect()->route('admin-dashboard')->with('success', 'you are logged in as admin');
            } else {
                return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }

    public function logout()
    {
        try {
            $user = auth()->user();
            session()->flush();
            cache()->flush();
            auth()->logout();

            return redirect()->route('admin-login')->with('success', "You're logged out successfully");
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->with(['error' => 'Somethig went wrong', 'error_msg' => $e->getMessage()]);
        }
    }
}
