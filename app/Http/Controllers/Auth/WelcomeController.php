<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\WelcomeNotification\WelcomesNewUsers;

class WelcomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(WelcomesNewUsers::class);
    }

    public function showWelcomeForm(Request $request, User $user)
    {
        return view('auth.welcome')->with([
            'user'  => $user,
        ]);
    }

    public function savePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->password = Hash::make($request->password);
        $user->welcome_valid_until = null;
        $user->save();

        auth()->login($user);

        return Redirect::route('help');
    }
}
