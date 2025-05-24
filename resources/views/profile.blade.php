<x-layouts.app :title="__('Profile')">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $user->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400">User ID: {{ $user->id }}</p>
            </div>
        </div>

        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Kisah yang Diunggah</h2>

        <div class="space-y-4">
            @forelse($kisahList as $kisah)
                <div class="kisah-card border p-4 rounded-lg mb-4 bg-white dark:bg-neutral-900 shadow"
                    data-url="{{ route('kisah.show', $kisah->id) }}">

                    <div class="mt-4 flex  flex-wrap gap-1 text-sm mb-4">
                        @foreach ($kisah->genres as $genre)
                            <span
                                class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 border p-2  rounded-lg">
                                {{ $genre->genre }}
                            </span>
                        @endforeach
                    </div>

                    <div onclick="window.location='{{ route('kisah.show', $kisah->id) }}'" class="cursor-pointer">
                        <div class="text-lg font-semibold text-gray-900 dark:text-white mb-0.5">
                            {{ $kisah->judul }}
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">{{ $kisah->sinopsis }}</p>
                    </div>

                    <div class="mt-0.5 flex gap-4 text-sm text-gray-600 dark:text-gray-300">
                        <!-- Like Button -->
                        <button class="btn-like border p-2 rounded-lg mt-4" data-kisah-id="{{ $kisah->id }}">
                            👍 <span class="like-count">{{ $kisah->like }}</span>
                        </button>

                        <!-- Dislike Button -->
                        <button class="btn-dislike border p-2 rounded-lg mt-4" data-kisah-id="{{ $kisah->id }}">
                            👎 <span class="dislike-count">{{ $kisah->dislike }}</span>
                        </button>

                        <!-- Bookmark Button -->
                        <button
                            class="btn-bookmark border p-2 rounded-lg mt-4  {{ $kisah->bookmarkedBy->contains(auth()->id()) ? 'text-yellow-500' : '' }}"
                            data-kisah-id="{{ $kisah->id }}">
                            📌 <span
                                class="bookmark-label">{{ $kisah->bookmarkedBy->contains(auth()->id()) ? 'Bookmarked' : 'Bookmark' }}</span>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Belum ada kisah yang diunggah.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
