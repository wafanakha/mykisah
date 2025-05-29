<div class="mt-3   flex gap-4 text-sm text-gray-600 dark:text-gray-300">
    <button 
        wire:click="like" 
        class="{{ $userReaction === 1 ? 'bg-blue-400 text-white' : '' }} border p-1 rounded-lg"
        wire:loading.attr="disabled"
    >
        👍 {{ $likeCount }}
    </button>

    <button 
        wire:click="dislike" 
        class="{{ $userReaction === -1 ? 'bg-red-400 text-white' : '' }} border p-1 rounded-lg"
        wire:loading.attr="disabled"
    >
        👎 {{ $dislikeCount }}
    </button>

    <button 
        wire:click="toggleBookmark" 
        class="{{ $bookmarked ? 'bg-yellow-400 text-white' : 'text-gray-500' }} border p-1 rounded-lg"
        wire:loading.attr="disabled"
    >
        📌 Bookmark
    </button>
</div>