<x-layouts.app :title="__('Dashboard')" value="light">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center p-4 border-b dark:border-neutral-700">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Home</h2>
        </div>

        {{-- Timeline --}}
        <div class="flex-1 overflow-y-auto space-y-4 px-4 pb-6">
        @foreach($kisahList as $kisah)
            <a href="{{ route('kisah.show', $kisah->id) }}" class="block hover:bg-gray-50 dark:hover:bg-neutral-700 rounded-lg border p-4 transition">
                <div class="flex items-center gap-3">
                    <img src="{{ $kisah->user->avatar_url }}" alt="{{ $kisah->user->name }}" class="w-8 h-8 rounded-full">
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $kisah->user->name }}</span>
                </div>

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Posted by <span class="font-medium text-gray-800 dark:text-gray-200">{{ $kisah->user->name }}</span>
                    on {{ $kisah->created_at->format('F d, Y') }}
                </div>
                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $kisah->judul }}
                </div>
                <div class="text-gray-700 dark:text-gray-300 mt-1">
                    {{ $kisah->sinopsis }}
                </div>
                <div class="mt-2 flex flex-wrap gap-1 text-sm">
                    @foreach($kisah->genres as $genre)
                        <span class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 rounded">
                            {{ $genre->genre }}
                        </span>
                    @endforeach
                </div>
                <div class="mt-3 flex gap-4 text-sm text-gray-600 dark:text-gray-300">
                    <span>❤️ {{ $kisah->like }}</span>
                    <span>👎 {{ $kisah->dislike }}</span>
                    <span>🔖 Bookmark</span>
                </div>
            </a>
        @endforeach

        </div>
    </div>
</x-layouts.app>
