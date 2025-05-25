<div class="mt-3   flex gap-4 text-sm text-gray-600 dark:text-gray-300">
    <button 
        wire:click="like" 
        class="{{ $userReaction === 1 ? 'text-blue-500' : '' }}"
        wire:loading.attr="disabled"
    >
        👍 {{ $likeCount }}
    </button>

    <button 
        wire:click="dislike" 
        class="{{ $userReaction === -1 ? 'text-red-500' : '' }}"
        wire:loading.attr="disabled"
    >
        👎 {{ $dislikeCount }}
    </button>

    <button 
        wire:click="toggleBookmark" 
        class="{{ $bookmarked ? 'text-yellow-500' : 'text-gray-500' }}"
        wire:loading.attr="disabled"
    >
        📌 Bookmark
    </button>
</div>