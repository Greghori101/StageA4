@extends('base')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">{{ __('auth.title') }}</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('auth.password') }}</label>
                <input id="password" type="password" name="password" required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('password') border-red-500 @enderror">
                @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center">
                <input class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" type="checkbox" name="remember" id="remember"
                    {{ old('remember') ? 'checked' : '' }}>
                <label class="ml-2 text-sm text-gray-600" for="remember">{{ __('auth.remember_me') }}</label>
            </div>

            <div class="flex flex-col space-y-2">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                    {{ __('auth.submit') }}
                </button>

                <a class="text-indigo-600 text-sm hover:underline text-center" href="{{ route('register') }}">
                    {{ __('auth.register') }}
                </a>

                @if (Route::has('password.request'))
                <a class="text-indigo-600 text-sm hover:underline text-center" href="{{ route('password.request') }}">
                    {{ __('auth.forgot_password') }}
                </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
