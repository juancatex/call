<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Data;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }
    public function dashboard(Request $request): Response
    {
        $allw=Data::all()->count();
        $sin=Data::where('status', '=',0)->count();
        $pro=Data::where('status', '=',1)->count();
        $finexito=Data::where('status', '=',2)->count();
        $finerror=Data::where('status', '=',3)->count();
        return Inertia::render('Dashboard', [
            'all' => $allw, 
            'sin' => $sin, 
            'pro' => $pro, 
            'finexito' => $finexito, 
            'finerror' => $finerror, 
        ]);
    }
    public function data(Request $request): Response
    {
        return Inertia::render('Data');
    }
    public function usuario(Request $request): Response
    {
        $users= User::where('users.activo',1) 
        ->where('users.email', '<>', 'admin@hotmail.com')
        ->orderBy('users.name')
        ->paginate(10); 
        return Inertia::render('Usuario', [ 
            'users' => $users 
        ]);
    }
    public function eliminaruser(Request $request): RedirectResponse
    {
        // $user = User::findOrFail($request->id);  
        // $user->destroy(); 
        // return redirect('/usuario');
        $user = User::findOrFail($request->id); 
        $user->email = date('Ymd_Gis').'@delete.com'; 
        $user->activo = 0; 
        $user->save(); 
        return redirect('/usuario');
    }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit');
    // }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
