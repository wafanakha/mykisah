<x-layouts.app :title="__('Following')">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">{{ $user->name }}'s Following</h1>
        
        <div class="space-y-4">
            @forelse($followings as $following)
                <div class="flex items-center gap-4 p-4 border rounded-lg">
                    <img src="{{ $following->avatar_url }}" alt="{{ $following->name }}" class="w-12 h-12 rounded-full">
                    <div>
                        <a href="{{ route('profile', $following) }}" class="font-semibold hover:underline">
                            {{ $following->name }}
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Not following anyone yet.</p>
            @endforelse
            
            {{ $followings->links() }}
        </div>
    </div>
</x-layouts.app>