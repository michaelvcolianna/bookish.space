<x-guest-layout>
    <div class="
        relative flex items-top justify-center min-h-screen bg-gray-100
        sm:items-center py-4 sm:pt-0
    ">
        @if(Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <x-shared.page-link route="dashboard" label="Dashboard" />
                @else
                    <x-shared.page-link route="login" label="Log in" />

                    @if(Route::has('register'))
                        <x-shared.page-link
                            route="register"
                            label="Register"
                            class="ml-4"
                        />
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="
                    font-medium uppercase text-5xl flex gap-4 items-center
                ">
                    <x-svg.stack-of-books class="h-10 w-10" />
                    <span>bookish.space</span>
                </h1>
            </div>

            <div class="
                flex justify-center mt-4 sm:items-center sm:justify-between
            ">
                <div class="
                    ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0
                ">
                    Later, this will contain a description of the site, maybe
                    some testimonials, etc.
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
