<a href="{{ route('favorites.toggle', ['modelType' => $modelType, 'modelId' => $modelId]) }}"
   class="favorite-link btn {{ $isFavorite ? 'btn-danger' : 'btn-outline-primary' }}">
    {{ $isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}
</a>
