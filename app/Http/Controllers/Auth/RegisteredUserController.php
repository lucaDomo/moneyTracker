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
use Illuminate\View\View;

use App\Models\Category;

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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        /* CREATE DEFAULT CATEGORIES */
        
        $category = new Category();
        
        $category->name = "Default_out";
        $category->file = "https://img.icons8.com/ios-glyphs/50/export.png";
        $category->user_id = auth()->user()->id;
        $category->movement_type_id = 1; #Uscita
        $category->save();

        $category = new Category();
        
        $category->name = "Default_in";
        $category->file = "https://img.icons8.com/ios-glyphs/50/enter-2.png";
        $category->user_id = auth()->user()->id;
        $category->movement_type_id = 2; #Uscita
        $category->save();

        return redirect(route('dashboard', absolute: false));
    }
}
