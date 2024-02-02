<x-guest-layout>
<div class="font-bold text-2xl text-red-600 mb-4">Oopsie-daisy!</div>
    <div class="mb-4 text-sm text-gray-600 dark:text-dark-400">
        <p>  Forgot your password? No biggie! Just drop us your email address, and like magic, we'll shoot over a password reset link. 
            🚀✨ Once you get it, Craft a password as unbreakable as Thor's hammer. Easy peasy!</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-black"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="bg-primary">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
