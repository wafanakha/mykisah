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
                <div class="p-4 border rounded-lg mb-4 bg-white dark:bg-neutral-900 shadow">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $kisah->judul }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $kisah->sinopsis }}</p>
                    <div class="mt-2 flex flex-wrap gap-1 text-sm">
                        @foreach($kisah->genres as $genre)
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 rounded">
                                {{ $genre->genre }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Belum ada kisah yang diunggah.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>
