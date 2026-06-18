<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;    
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

public function callback()
{
    $githubUser = Socialite::driver('github')->user();

    $email = $githubUser->email ?? ($githubUser->id . '@github.com');

    $user = User::updateOrCreate([
        'email' => $email,
    ], [
        'name' => $githubUser->name ?? $githubUser->nickname,
        'password' => bcrypt(\Illuminate\Support\Str::random(24)), 
    ]);

    Auth::login($user);
    
    return redirect('/dashboard');
}
}