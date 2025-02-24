@extends('base')

@section('title', __('interface.home'))

@section('content')

<!-- Main Content -->
<div class="container text-center mt-5 pb-5">
    <div class="row justify-content-center">
        @php
            $buttons = [
                ['route' => 'program_sessions.index', 'icon' => 'fas fa-calendar-alt', 'text' => __('interface.event_program'), 'class' => 'btn-outline-primary'],
                ['route' => 'speakers.index', 'icon' => 'fas fa-microphone-alt', 'text' => __('interface.speakers'), 'class' => 'btn-outline-secondary'],
                ['route' => 'sponsors.index', 'icon' => 'fas fa-users', 'text' => __('interface.exhibitors'), 'class' => 'btn-outline-success'],
                ['route' => 'rooms.index', 'icon' => 'fas fa-building', 'text' => __('interface.rooms'), 'class' => 'btn-outline-danger'],
                ['route' => 'questions.index', 'icon' => 'fas fa-question-circle', 'text' => __('interface.questions'), 'class' => 'btn-warning'],
                ['route' => 'https://www.youtube.com/@siphaltv', 'icon' => 'fas fa-tv', 'text' => __('interface.siphal_tv'), 'class' => 'btn-dark', 'external' => true]
            ];
        @endphp

        @foreach ($buttons as $btn)
            <div class="col-6 col-md-4 mb-3">
                <a href="{{ isset($btn['external']) ? $btn['route'] : route($btn['route']) }}"
                   class="btn {{ $btn['class'] }} w-100 d-flex align-items-center justify-content-center py-3"
                   @isset($btn['external']) target="_blank" @endisset>
                    <i class="{{ $btn['icon'] }} me-2"></i> {{ $btn['text'] }}
                </a>
            </div>
        @endforeach
    </div>
</div>

<!-- Image Plan (Lightbox) -->
<div class="text-center w-full flex">
    <a class="mx-auto" href="{{ asset('images/plan.jpg') }}" data-lightbox="image-1" data-title="{{ __('interface.event_plan') }}">
        <img src="{{ asset('images/plan.jpg') }}" alt="{{ __('interface.event_plan') }}" class="img-fluid mt-3 max-w-md">
    </a>
</div>

@endsection
