<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manage Noticeboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    {{ session('message') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Published Notices
                    </h3>
                    <x-button wire:click="openModal()">Create New Notice</x-button>
                </div>

                <!-- Notices Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Audience</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Published On</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($notices as $notice)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($notice->title, 40) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if(empty($notice->audience))
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">All Roles</span>
                                    @else
                                        @foreach($notice->audience as $role)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $role }}</span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $notice->published_at->format('d M, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- Add Edit/Delete buttons later -->
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 whitespace-nowrap text-sm text-center text-gray-500">
                                    No notices have been published yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $notices->links() }}
                </div>
            </div>
        </div>

        <!-- Create/Edit Notice Modal -->
        <x-dialog-modal wire:model.live="showModal">
            <x-slot name="title">
                {{ $isEditMode ? 'Edit Notice' : 'Create New Notice' }}
            </x-slot>

            <x-slot name="content">
                <div class="mb-4">
                    <x-label for="title" value="{{ __('Notice Title') }}" />
                    <x-input id="title" type="text" class="mt-1 block w-full" wire:model="title" />
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <x-label for="content" value="{{ __('Content') }}" />
                    <textarea id="content" rows="6" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" wire:model="content"></textarea>
                    @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-label value="{{ __('Visible To (optional - leave blank for all)') }}" />
                    <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach($roles as $role)
                            <label class="flex items-center space-x-2 p-2 bg-gray-50 dark:bg-gray-700 rounded-md">
                                <x-checkbox wire:model="audience" value="{{ $role }}" />
                                <span class="text-sm text-gray-700 dark:text-gray-200">{{ $role }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('showModal')">
                    Cancel
                </x-secondary-button>

                <x-button class="ml-2" wire:click="{{ $isEditMode ? 'update' : 'store' }}">
                    Publish Notice
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>