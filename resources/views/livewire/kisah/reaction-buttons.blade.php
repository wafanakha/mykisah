<div class="flex gap-4 text-sm">
    <button wire:click="like" class="{{ $userReaction === 1 ? 'text-blue-500' : '' }}">
        👍 {{ $likeCount }}
    </button>

    <button wire:click="dislike" class="{{ $userReaction === -1 ? 'text-red-500' : '' }}">
        👎 {{ $dislikeCount }}
    </button>
</div>