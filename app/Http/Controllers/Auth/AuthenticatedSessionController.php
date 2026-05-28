<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        $user = auth()->user();

        if($user->role->id === 4){
            if ($user->agency->archived_at){
                auth()->logout();

                return redirect()->route('login')->withErrors([
                    'email' => 'Your agency is archived'
                ]);
                
            }
            return redirect()->intended(route('hrmo.dashboard', absolute: false));
        } else if (in_array($user->role->id, [1, 2, 3])){
            return redirect()->intended(route('dashboard', absolute: false));
        } else {
            redirect('/');
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
