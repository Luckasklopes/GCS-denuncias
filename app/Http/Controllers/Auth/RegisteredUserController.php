<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'cpf' => ['required', 'string', 'size:11', 'unique:users', 'regex:/^\d{11}$/'],
        'numero' => ['nullable', 'string', 'max:20'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'aceite_termos' => ['accepted'],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'cpf' => $request->cpf,
        'numero' => $request->numero,
        'password' => Hash::make($request->password),
        'aceite_termos' => (bool) $request->aceite_termos,
    ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
