<x-layouts.app :title="__('Followers')">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">{{ $user->name }}'s Followers</h1>
        
        <div class="space-y-4">
            @forelse($followers as $follower)
                <div class="flex items-center gap-4 p-4 border rounded-lg">
                    <img src="{{ $follower->avatar_url }}" alt="{{ $follower->name }}" class="w-12 h-12 rounded-full">
                    <div>
                        <a href="{{ route('profile', $follower) }}" class="font-semibold hover:underline">
                            {{ $follower->name }}
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No followers yet.</p>
            @endforelse
            
            {{ $followers->links() }}
        </div>
    </div>
</x-layouts.app>