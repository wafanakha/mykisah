<button
    wire:click="toggleFollow"
    class="follow-btn px-4 py-2 rounded-full text-sm font-medium {{ $isFollowing ? 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white' : 'bg-blue-500 text-white' }}"
    wire:loading.attr="disabled"
    wire:loading.class="opacity-75"
>
    <span wire:loading.remove>
        {{ $isFollowing ? 'Following' : 'Follow' }}
    </span>
    <span wire:loading>
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Processing...
    </span>
</button>