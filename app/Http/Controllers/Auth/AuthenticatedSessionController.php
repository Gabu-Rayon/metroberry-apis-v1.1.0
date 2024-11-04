<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show Driver Login Form
     * 
     * @return \Illuminate\View\View
     */





    // Welcome page method
    public function WelcomePage()
    {
        return view('welcome');
    }

    // Sign-up options method
    public function signUpOptions()
    {
        return view('sign-in-options');
    }

    public function usersSignInPage()
    {
        return view('sign-in');
    }

    /**
     * Store Driver Login Form
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function loginStore(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();

            $user = $request->user();

            // Check if user account is inactive and handle accordingly
            if (
                $user->role == 'fuelling_station' && $user->fuelling_station->status == 'inactive' ||
                $user->role == 'organisation' && $user->organisation->status == 'inactive'
            ) {

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->with('error', 'Your Account is inactive. Please contact the Administrator.');
            }

            // Regenerate session
            $request->session()->regenerate();

            // Redirect users based on their roles
            switch ($user->role) {
                case 'fuelling_station':
                    return redirect()->route('fuelling-station.dashboard');
                case 'organisation':
                    return redirect()->route('organisation.dashboard');
                case 'customer':
                    return redirect()->route('customer.index.page');
                case 'driver':
                    return redirect()->route('driver.dashboard');
                default:
                    return redirect()->route('welcome.page');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }




    // Sign-in page method
    public function signInPage()
    {
        return view('customer.sign-in');
    }

    public function usersSignOut(Request $request)
    {
        // Log the logout attempt
        Log::info('Logout attempt: ', ['id' => Auth::id()]);

        // Get the authenticated user
        $user = Auth::user();

        // Check the user's role and log accordingly
        if ($user->role === 'driver' || $user->role === 'customer' || $user->role === 'refueling_station') {
            Log::info('Logging out user with role: ' . $user->role, ['id' => $user->id]);
        } elseif ($user->role === 'admin') {
            Log::info('Logging out admin user: ', ['id' => $user->id]);
        } else {
            Log::warning('Unknown user role during logout: ', ['id' => $user->id, 'role' => $user->role]);
        }

        // Log out the user
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token
        $request->session()->regenerateToken();

        // Redirect to the login page with a success message
        return redirect()->route('welcome.page')->with('success', 'You have been logged out successfully.');
    }

}