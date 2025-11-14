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
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Set a New Password</h2>
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="block">
                    <x-label for="email" value="{{ __('Email Address') }}" />
                    <x-input id="email" class="block mt-1 w-full bg-gray-100" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" readonly />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('New Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm New Password') }}" />
                    <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Reset Password') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>