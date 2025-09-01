<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // <-- import the correct Request

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Use "username" as the login field
    public function username()
    {
        $login = request()->input('username');
        request()->merge(['username' => $login]);
        return 'username';
    }

    /**
     * Where to redirect users after login.
     * You can keep this OR use authenticated() below (not both).
     */

    /**
     * Runs right after successful authentication.
     * If you return a response here, it overrides redirectTo().
     */
    protected function authenticated(Request $request, $user)
    {
        $target = ((int) $user->user_type === 3) ? 'guard.index' : 'visitor.index';

        return redirect()->route($target); 
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
