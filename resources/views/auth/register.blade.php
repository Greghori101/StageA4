@extends('base')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-center text-gray-800 mb-4">{{ __('auth.title') }}</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700">{{ __('auth.full_name') }}</label>
                <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required autofocus
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('full_name') border-red-500 @enderror">
                @error('full_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nickname" class="block text-sm font-medium text-gray-700">{{ __('auth.nickname') }}</label>
                <input id="nickname" type="text" name="nickname" value="{{ old('nickname') }}"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('nickname') border-red-500 @enderror">
                @error('nickname')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="job_title" class="block text-sm font-medium text-gray-700">{{ __('auth.job_title') }}</label>
                <input id="job_title" type="text" name="job_title" value="{{ old('job_title') }}" required
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('job_title') border-red-500 @enderror">
                @error('job_title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="institution" class="block text-sm font-medium text-gray-700">{{ __('auth.institution') }}</label>
                <input id="institution" type="text" name="institution" value="{{ old('institution') }}"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('institution') border-red-500 @enderror">
                @error('institution')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">{{ __('auth.address') }}</label>
                <input id="address" type="text" name="address" value="{{ old('address') }}"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('address') border-red-500 @enderror">
                @error('address')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="country" class="block text-sm font-medium text-gray-700">{{ __('auth.country') }}</label>
                <input id="country" type="text" name="country" value="{{ old('country') }}"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('country') border-red-500 @enderror">
                @error('country')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="state" class="block text-sm font-medium text-gray-700">{{ __('auth.state') }}</label>
                <input id="state" type="text" name="state" value="{{ old('state') }}"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-200 focus:border-indigo-500 @error('state') border-red-500 @enderror">
                @error('state')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition duration-300">
                    {{ __('auth.submit') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
