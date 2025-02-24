<a href="{{ route('favorites.toggle', ['modelType' => $modelType, 'modelId' => $modelId]) }}" 
   class="favorite-link text-decoration-none">
    <i class="fas fa-heart {{ $isFavorite ? 'text-danger' : 'text-secondary' }}"></i>
</a>
