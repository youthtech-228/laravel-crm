<x-auth-layout>
    <x-slot name="title">
        @lang('Login')
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

                    <div class="">
                        <div class="text-2xl font-semibold mb-1">
                            <h1>Sign in to Kayo Express</h1>
                        </div>
                        <div class="text-sm mb-1">
                            <p>Please enter your credentials to proceed.</p>
                        </div>
                    </div>
                    <div class="w-full sm:max-w-md mt-6 py-4 bg-white overflow-hidden">
            
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                
                        <!-- Social Login -->
                        {{-- <x-auth-social-login /> --}}
                
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                
                            <!-- Email Address -->
                            <div>
                                <x-label for="email" :value="__('Email')" />
                
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                            </div>
                
                            <!-- Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('Password')" />
                
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            </div>
                
                            <!-- Remember Me -->
                            <div class="flex mt-4 justify-between">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                                @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                                @endif
                            </div>
                
                            <div class="flex items-center justify-start mt-4">
                                <x-button class="ml-3">
                                    {{ __('Log in') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
            
                    <div>
                        @if (Route::has('register'))
                        <p class="text-center text-gray-600 mt-4">
                            Do not have an account? <a href="{{ route('register') }}" class="underline hover:text-gray-900">Register</a>.
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-layout>