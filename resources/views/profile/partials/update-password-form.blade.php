<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative mt-1">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="block w-full pr-10 pl-3 py-2 border rounded-md" autocomplete="current-password" />
                <button type="button" class="absolute inset-y-0 right-0 flex items-center justify-center pr-3 z-10" onclick="togglePassword('update_password_current_password', 'iconCurrentPassword')">
                    <i id="iconCurrentPassword" class="fas fa-eye text-gray-600"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative mt-1">
                <x-text-input id="update_password_password" name="password" type="password" class="block w-full pr-10 pl-3 py-2 border rounded-md" autocomplete="new-password" />
                <button type="button" class="absolute inset-y-0 right-0 flex items-center justify-center pr-3 z-10" onclick="togglePassword('update_password_password', 'iconNewPassword')">
                    <i id="iconNewPassword" class="fas fa-eye text-gray-600"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative mt-1">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="block w-full pr-10 pl-3 py-2 border rounded-md" autocomplete="new-password" />
                <button type="button" class="absolute inset-y-0 right-0 flex items-center justify-center pr-3 z-10" onclick="togglePassword('update_password_password_confirmation', 'iconConfirmPassword')">
                    <i id="iconConfirmPassword" class="fas fa-eye text-gray-600"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function togglePassword(inputId, iconId) {
        const inputField = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            inputField.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>