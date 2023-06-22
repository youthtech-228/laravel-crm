<x-auth-layout>
    <x-slot name="title">
        @lang('Register')
    </x-slot>

    <div class="container p-0 w-full max-w-full login-container">
        <div class="flex flex-row flex-nowrap">
            <div class="image-column w-1/3 py-8 px-10">
                <div class="flex flex-col">
                    <div class="logo-container mb-12 py-3">
                        <img src="{{asset('img/KayoExpressFINAL.png')}}" style="height: 50px;">
                    </div>
                    <div class="title-container text-3xl font-bold mb-12">
                        <h1>Ship Faster, Smarter, and Cheaper with Kayo!</h1>
                    </div>
                    <div class="title-container text-3xl font-bold mb-12">
                        <img src="{{asset('img/login-graphic-ed6e2e2c.png')}}" class="w-[400px] h-auto">
                    </div>
                </div>
            </div>
            <div class="login-column w-2/3 flex-1">
                <div class="min-h-screen flex flex-col sm:justify-center items-start px-10 pt-6 sm:pt-0 bg-white">
                    <div>
                        <div class="text-2xl font-semibold mb-1">
                            <h1>Registration</h1>
                        </div>
                        <div class="text-sm mb-1">
                            <p>Create your Kayo Express account today!</p>
                        </div>
                    </div>
                    <div class="w-full sm:max-w-md mt-6 py-4 bg-white overflow-hidden">

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <!-- Social login -->
                        {{-- <x-auth-social-login /> --}}

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- First Name -->
                            <div class="mt-4">
                                <x-label for="first_name" :value="__('First Name')" />

                                <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
                            </div>

                            <!-- Last Name -->
                            <div class="mt-4">
                                <x-label for="last_name" :value="__('Last Name')" />

                                <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-label for="email" :value="__('Email')" />

                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Password')" />

                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>

                            <div class="flex items-center justify-start mt-4">
                                <!-- <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                    {{ __('Already registered?') }}
                                </a> -->

                                <x-button class="">
                                    {{ __('Register') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <p class="text-center text-gray-600 mt-4">
                            Already have an account? <a href="{{ route('login') }}" class="underline hover:text-gray-900">Login</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-auth-layout>