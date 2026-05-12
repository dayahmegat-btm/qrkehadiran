<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'no_kp' => 'required|string|size:12|unique:users,no_kp',
            'nama' => 'required|string|max:255',
            'emel' => 'required|string|lowercase|email|max:255|unique:users,emel',
            'kata_laluan' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'no_kp' => $request->no_kp,
            'nama' => $request->nama,
            'emel' => $request->emel,
            'kata_laluan_hash' => Hash::make($request->kata_laluan),
            'status_aktif' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
