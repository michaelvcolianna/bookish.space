<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-guest-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-form.help>
                    The name that will display on your projects and profile.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label for="handle" value="{{ __('Handle') }}" />
                <x-jet-input id="handle" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" autocomplete="nickname" />
                <x-form.help>
                    This displays in URLs to your content, and may only contain alphanumeric characters, dashes, or underscores. If you leave it blank, we'll make one from your name. (32 characters or fewer.)
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <x-form.help>
                    This is only used for login and important messages, never for marketing.
                </x-form.help>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-form.help>
                    Passwords must be 8 characters minimum. We recommend mixing upper/lowercase letters with numbers and special characters. Once your account is created we also recommend turning on two-factor authentication.
                </x-form.help>
            </div>

            @if(env('APP_REGISTRATION_KEY'))
                <div class="mt-4">
                    <x-jet-label for="registration_key" value="{{ __('Registration Key') }}" />
                    <x-jet-input id="registration_key" class="block mt-1 w-full" type="text" name="registration_key" required autocomplete="off" />
                    <x-form.help>
                        Public registration is currently closed. Please provide the registration key given to you by an administrator.
                    </x-form.help>
                </div>
            @endif

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-jet-label for="terms">
                        <div class="flex items-center">
                            <x-jet-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-jet-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Register') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
