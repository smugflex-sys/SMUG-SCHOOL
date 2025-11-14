<x-app-layout>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Dashboard
        </h2>

        <!-- The only change is adding dark:bg-gray-800 to this div -->
        <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-medium text-gray-900 dark:text-white">
                Welcome to your dashboard, {{ Auth::user()->name }}!
            </h1>

            <p class="mt-4 text-gray-500 dark:text-gray-400">
                You are logged in as:
                @foreach (Auth::user()->getRoleNames() as $role)
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $role }}
                    </span>
                @endforeach
            </p>
        </div>
    </div>
</x-app-layout>