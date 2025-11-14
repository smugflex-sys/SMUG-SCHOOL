<x-guest-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8 text-center">
                <div class="mb-6">
                    <span class="px-4 py-2 text-lg font-semibold rounded-full
                        @if($exeat->status == 'approved') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                        STATUS: {{ Str::upper($exeat->status) }}
                    </span>
                </div>

                <img class="h-32 w-32 rounded-full object-cover mx-auto mb-4 border-4 border-white shadow-lg" src="{{ $exeat->student->user->profile_photo_url }}" alt="">
                <h2 class="text-2xl font-bold text-gray-900">{{ $exeat->student->user->name }}</h2>
                <p class="text-gray-500">{{ $exeat->student->schoolClass->name }} {{ $exeat->student->classArm->name }}</p>

                <div class="mt-6 border-t pt-6 text-left space-y-4">
                    <p><strong>Reason:</strong> {{ $exeat->reason }}</p>
                    <p><strong>Departure:</strong> {{ $exeat->departure_time->format('D, M j, Y - g:i A') }}</p>
                    <p><strong>Expected Return:</strong> {{ $exeat->expected_return_time->format('D, M j, Y - g:i A') }}</p>
                    <p><strong>Approved By:</strong> {{ $exeat->approver->name ?? 'N/A' }}</p>
                </div>
                
                <div class="mt-6">
                    {!! QrCode::size(150)->generate(route('exeat.verify', $exeat->token)) !!}
                </div>
                 <p class="text-xs text-gray-400 mt-4">Token: {{ $exeat->token }}</p>
            </div>
        </div>
    </div>
</x-guest-layout>