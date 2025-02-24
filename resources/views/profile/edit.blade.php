@extends('base')

@section('title', __('interface.edit_profile'))

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">{{ __('interface.edit_profile') }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Avatar Upload -->
        <div class="mb-3 text-center">
            <img src="{{ $user->avatar?->original_url ?? asset('images/default-avatar.png') }}" 
                 class="rounded-circle img-thumbnail" 
                 style="width: 120px; height: 120px;">
            <input type="file" name="avatar" class="form-control mt-2">
        </div>

        <!-- Profile Information -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('interface.full_name') }}</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.nickname') }}</label>
                    <input type="text" name="nickname" class="form-control" value="{{ old('nickname', $user->nickname) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.job_title') }}</label>
                    <input type="text" name="job_title" class="form-control" value="{{ old('job_title', $user->job_title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.institution') }}</label>
                    <input type="text" name="institution" class="form-control" value="{{ old('institution', $user->institution) }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('interface.address') }}</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.country') }}</label>
                    <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.state') }}</label>
                    <input type="text" name="state" class="form-control" value="{{ old('state', $user->state) }}">
                </div>

                <!-- Password Fields -->
                <div class="mb-3">
                    <label class="form-label">{{ __('interface.new_password') }}</label>
                    <input type="password" name="password" class="form-control" placeholder="{{ __('interface.leave_blank_if_no_change') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('interface.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">{{ __('interface.update') }}</button>
    </form>
</div>
@endsection
