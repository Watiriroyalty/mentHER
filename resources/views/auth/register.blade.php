<x-guest-layout>
<div x-data="{ gender: '', roleOptions: ['mentor'] }" class="bg-blue-500 p-6 rounded-lg shadow-md">     <form method="POST" action="{{ route('register') }}">
<h1 style="font-weight: bold; color: black;">GOOD TO SEE YOU HERE 😊</h1>
</br>
<p id="typing-text" class="text-black mb-4"></p>

<script>
    const text = "Let's get you started by filling out the registration form. ";
    let index = 0;
    const typingText = document.getElementById("typing-text");

    function typeText() {
        typingText.textContent += text[index];
        index++;

        if (index < text.length) {
            setTimeout(typeText, 50); // Adjust the duration as needed
        }
    }

    // Start typing animation
    typeText();
</script>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" class="font-bold text-black" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email Address')" class="font-bold text-black" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
       <!-- Gender -->
       <div class="mt-4">
                <x-input-label for="gender" :value="__('Gender')" class="font-bold text-black" />
                <select x-model="gender" id="gender" name="gender" class="block appearance-none w-full bg-dark border border-gray-300 rounded-md py-2 px-3 leading-tight focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>

         <!-- Role -->
<div class="mt-4">
    <x-input-label for="role" :value="__('Role')" class="font-bold text-black" />
    <select id="role" name="role" x-bind:disabled="gender === ''" x-model="role" class="block appearance-none w-full bg-dark border border-gray-300 rounded-md py-2 px-3 leading-tight focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <option value="mentor">Mentor</option>
        <option value="mentee" x-show="gender === 'female'">Mentee</option>
    </select>
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>




            <!-- Years of Experience -->
            <div class="mt-4">
                <x-input-label for="experience" :value="__('Years of Experience')" class="font-bold text-black" />
                <select id="experience" name="experience" class="block appearance-none w-full bg-dark border border-gray-300 rounded-md py-2 px-3 leading-tight focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="0-2">0-2 years</option>
                    <option value="2-5">2-5 years</option>
                    <option value="5-10">5-10 years</option>
                    <option value="more-than-10">More than 10 years</option>
                </select>
                <x-input-error :messages="$errors->get('experience')" class="mt-2" />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="font-bold text-black" />
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-bold text-black" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-dark-400 hover:text-blue-900 dark:hover:text-dark-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4 bg-primary">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
