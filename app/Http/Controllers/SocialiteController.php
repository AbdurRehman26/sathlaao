<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Validator;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        $response = Socialite::driver($provider)->user();

        $user = User::firstWhere(['email' => $response->getEmail()]);

        if ($user) {
            $user->update([$provider . '_id' => $response->getId()]);
        } else {
            $user = User::create([
                $provider . '_id' => $response->getId(),
                'name'            => $response->getName(),
                'email'           => $response->getEmail(),
                'password'        => '',
            ]);
        }

        auth()->login($user);

        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    protected function validateProvider(string $provider): array
    {
        return \Illuminate\Support\Facades\Validator::make(
            ['provider' => $provider],
            ['provider' => 'in:google']
        )->validate();
    }
}
