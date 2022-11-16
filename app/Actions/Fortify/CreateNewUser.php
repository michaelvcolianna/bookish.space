<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $registration_key_validation = ['nullable'];
        if(env('APP_REGISTRATION_KEY'))
        {
            $registration_key_validation = [
                'required',
                function($attribute, $value, $fail) {
                    if(!Hash::check($value, env('APP_REGISTRATION_KEY'))) {
                        $fail('The registration key is incorrect.');
                    }
                },
            ];
        }

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:32', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'registration_key' => $registration_key_validation,
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'slug' => $input['slug'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
