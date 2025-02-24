<!-- Bottom Navbar -->
<div class="sticky bottom-0 left-0 w-full bg-white shadow-md border-t flex justify-around py-2">
    <a href="{{ route('home') }}" class="flex flex-col items-center text-gray-600 hover:text-indigo-600 {{ request()->routeIs('home') ? 'text-indigo-600 font-semibold' : '' }}">
        <i class="fas fa-home text-lg"></i>
        <span class="text-xs">{{ __('interface.home') }}</span>
    </a>

    <a href="{{ route('program_sessions.index') }}" class="flex flex-col items-center text-gray-600 hover:text-indigo-600 {{ request()->routeIs('program_sessions.index') ? 'text-indigo-600 font-semibold' : '' }}">
        <i class="fas fa-calendar-alt text-lg"></i>
        <span class="text-xs">{{ __('interface.program') }}</span>
    </a>

    <a href="{{ route('questions.index') }}" class="flex flex-col items-center text-gray-600 hover:text-indigo-600 {{ request()->routeIs('questions.index') ? 'text-indigo-600 font-semibold' : '' }}">
        <i class="fas fa-question-circle text-lg"></i>
        <span class="text-xs">{{ __('interface.questions') }}</span>
    </a>

    <a href="{{ route('sponsors.index') }}" class="flex flex-col items-center text-gray-600 hover:text-indigo-600 {{ request()->routeIs('sponsors.index') ? 'text-indigo-600 font-semibold' : '' }}">
        <i class="fas fa-users text-lg"></i>
        <span class="text-xs">{{ __('interface.exhibitors') }}</span>
    </a>

    @auth
    @if(auth()->check() && Auth::user()->can('read Favorite'))
    <a href="{{ route('favorites.index') }}" class="flex flex-col items-center text-gray-600 hover:text-indigo-600 {{ request()->routeIs('favorites.index') ? 'text-indigo-600 font-semibold' : '' }}">
        <i class="fas fa-heart text-lg"></i>
        <span class="text-xs">{{ __('interface.favorites') }}</span>
    </a>
    @endif
    @endauth
</div>
