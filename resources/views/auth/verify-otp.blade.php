<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Please enter the 6-digit OTP code sent to your email address.
    </div>

    <form method="POST" action="{{ route('otp.submit') }}">
        @csrf
        <div>
            <x-input-label for="otp" value="OTP Code" />
            <x-text-input id="otp" class="block mt-1 w-full" type="text" name="otp" required autofocus />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Verify and Log In
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>