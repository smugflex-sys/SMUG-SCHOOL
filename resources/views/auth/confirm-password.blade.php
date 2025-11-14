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
                <h2 class="mt-4 text-2xl font-bold text-gray-800">Confirm Access</h2>
            </div>

            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div>
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" autofocus placeholder="••••••••" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-button class="ms-4">
                        {{ __('Confirm') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>