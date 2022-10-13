<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        Profile Information
    </x-slot>

    <x-slot name="description">
        Update your account\'s profile information and email address.
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    Select A New Photo
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        Remove Photo
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="Name" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-shared.help.name />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Handle -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="handle" value="Handle" />
            <x-jet-input id="handle" type="text" class="mt-1 block w-full" wire:model.defer="state.handle" autocomplete="nickname" />
            <x-form.help>This is the name used in the URLs to anything you create. Keep in mind if you've established yourself with one handle and switch to another, it may take a while for search engines to reflect the change (if they do at all).</x-form.help>
            <x-jet-input-error for="handle" class="mt-2" />
        </div>

        <!-- Pronouns -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="pronouns" value="Pronouns" />
            <x-jet-input id="pronouns" type="text" class="mt-1 block w-full" wire:model.defer="state.pronouns" />
            <x-form.help>Optional, only if you feel comfortable sharing.</x-form.help>
            <x-jet-input-error for="pronouns" class="mt-2" />
        </div>

        <!-- Bio -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="bio" value="Bio" />
            <textarea id="bio" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.bio"></textarea>
            <x-form.help>An optional short bio to tell people about yourself.</x-form.help>
            <x-jet-input-error for="bio" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="Email" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-shared.help.email>If you change this, you'll have to re-verify your account.</x-shared.help.email>
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    Your email address is unverified.

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900" wire:click.prevent="sendEmailVerification">
                        Click here to re-send the verification email.
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            Saved.
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            Save
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
