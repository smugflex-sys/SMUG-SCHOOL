<x-guest-layout>
    <div class="min-h-screen bg-gray-50 flex flex-col justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl">
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center space-x-2">
                    <div class="bg-green-600 text-white font-bold text-xl w-12 h-12 flex items-center justify-center rounded-lg">
                        GHS
                    </div>
                    <span class="text-2xl font-bold text-gray-800">GreenField High</span>
                </a>
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Welcome Back!</h2>
                <p class="text-gray-500">Please sign in to access your portal.</p>
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email Address') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-green-600 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="flex flex-col items-center justify-end mt-6">
                    <x-button class="w-full text-center justify-center">
                        {{ __('Log in') }}
                    </x-button>

                    {{-- <p class="mt-4 text-sm text-gray-600">
                        Don't have an account?
                        <a class="underline text-green-600 hover:text-green-800" href="{{ route('register') }}">
                            Register here
                        </a>
                    </p> --}}
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>