<x-guest-layout>
    <x-auth-card>
        <!-- <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot> -->

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <!-- <x-label for="name" :value="__('Name')" /> -->
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="名前" required autofocus />
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <!-- <x-label for="email" :value="__('Email')" /> -->
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <!-- <x-label for="password" :value="__('Password')" /> -->
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="パスワード" required autocomplete="new-password" />
            </div>
            <!-- Confirm Password -->
            <div class="mt-4">
                <!-- <x-label for="password_confirmation" :value="__('Confirm Password')" /> -->
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="確認用パスワード" required />
            </div>
            <div class="flex items-center justify mt-4">
                <x-button class="w-full text-center">
                    {{ __('会員登録') }}
                </x-button>
            </div>
            <div class="text-center">
                <p>アカウントをお持ちの方はこちらから</p>
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('ログイン') }}
                </a>
            </div>
        </form>
    </x-auth-card>
    git remote add origin https://github.com/seki221/attendance.git
</x-guest-layout>