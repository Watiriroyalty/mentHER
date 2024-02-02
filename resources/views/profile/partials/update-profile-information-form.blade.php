<section>
    <header>
        <h2 class="text-lg font-medium text-black dark:text-black">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-dark-600 dark:text-dark-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-black font-bold" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-black font-bold" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <!-- Profile Picture Upload -->
            <div class="mt-4">
                <x-input-label for="profile_picture" :value="__('Profile Picture')" class="text-black font-bold" />
                <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />

                @if($user->profile_picture_url)
                    <div class="mt-2">
                        <img src="{{ $user->profile_picture_url }}" alt="Profile Picture" class="h-16 w-16 rounded-full object-cover">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label for="bio" class="text-black font-bold">Bio:</label>
                <textarea id="bio" name="bio" class="form-control">{{ old('bio', $user->bio) }}</textarea>
            </div>
        </div>

        <!-- New field for Skills (multi-select) -->
        <div>
            <x-input-label for="skills" :value="__('Skills:')" class="text-black font-bold" />
            @foreach($skills as $skill)
                <label>
                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" {{ in_array($skill->id, $userSkills) ? 'checked' : '' }}>
                    {{ $skill->name }}
                </label>
            @endforeach
            <x-input-error class="mt-2" :messages="$errors->get('skills')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-primary bg-primary">{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-dark-600 dark:text-dark-400"
                >{{ __('Changes updated successfully') }}</p>
            @endif
        </div>
    </form>

</section>
