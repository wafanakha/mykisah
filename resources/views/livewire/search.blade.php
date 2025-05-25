<div class="p-6">
    <input type="text" wire:model.debounce.300ms="query"
        class="w-full border p-2 rounded" placeholder="Search kisah or user..." />

    @if($query)
        <div class="mt-4">
            <h3 class="text-lg font-semibold mb-2">Kisah Results</h3>
            @forelse($kisahResults as $kisah)
                <div class="p-2 border-b">
                    <a href="{{ route('kisah.show', $kisah->id) }}">
                        <strong>{{ $kisah->judul }}</strong>
                    </a> by {{ $kisah->user->name }}
                </div>
            @empty
                <p class="text-gray-500">No kisah found.</p>
            @endforelse

            <h3 class="text-lg font-semibold mt-6 mb-2">User Results</h3>
            @forelse($userResults as $user)
                <div class="p-2 border-b">
                    <a href="{{ route('user.profile', $user->id) }}">
                        {{ $user->name }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No users found.</p>
            @endforelse
        </div>
    @endif
</div>
