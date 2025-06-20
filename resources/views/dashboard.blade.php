<x-layouts.app :title="__('Dashboard')" value="light">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center p-4 border-b dark:border-neutral-700">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Home</h2>
        </div>

        {{-- Timeline --}}
        <div class="flex-1 overflow-y-auto space-y-4 px-4 pb-6">
            @foreach ($kisahList as $kisah)
                <div class="kisah-card border p-4 rounded-lg mb-4 bg-white dark:bg-neutral-900 shadow"
                    data-url="{{ route('kisah.show', $kisah->id) }}">
                    <div class="flex items-center gap-3 mb-4 cursor-pointer"
                        onclick="window.location='{{ route('profile', $kisah->user->id) }}'">
                        <img src="{{ $kisah->user->avatar_url }}" alt="{{ $kisah->user->name }}"
                            class="w-8 h-8 rounded-full">
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $kisah->user->name }}</span>
                    </div>

                    <div class="mt-4 flex  flex-wrap gap-1 text-sm mb-4">
                        @foreach ($kisah->genres as $genre)
                            <span
                                class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 border p-2  rounded-lg">
                                {{ $genre->genre }}
                            </span>
                        @endforeach
                    </div>

                    <div onclick="window.location='{{ route('kisah.show', $kisah->id) }}'" class="cursor-pointer">
                        <div class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $kisah->judul }}
                        </div>
                        <p class="text-gray-600 dark:text-gray-300">{{ $kisah->sinopsis }}</p>
                    </div>

                        <!-- Like Button -->
                        <livewire:kisah.reaction-buttons :kisah="$kisah" />
                        <!-- Bookmark Button -->
                </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>

