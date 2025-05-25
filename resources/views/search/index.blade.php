<x-layouts.app :title="'Search Results for ' . $query">
    <form action="{{ route('search') }}" method="GET" class="space-y-4">
        <div class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="border px-2 py-1 rounded w-full">
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">Search</button>
        </div>

        <div>
            <label class="block font-semibold mb-2">Filter by Genre:</label>
            <div class="flex flex-wrap gap-2">
                    <label class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded cursor-pointer">
                        <input type="checkbox" name="genres" value="Fantasy">
                        Fantasy
                    </label>
                    <label class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded cursor-pointer">
                        <input type="checkbox" name="genres" value="Romance">
                        Romance
                    </label>
            </div>
        </div>
    </form>

    <div class="p-6 space-y-6">
        @if ($query)
            <h2 class="text-2xl font-bold">Results for "{{ $query }}"</h2>
        @endif

        <div>
            <h3 class="text-xl font-semibold mt-6 mb-2">Users</h3>
            @forelse ($userResults as $user)
                <div class="flex items-center gap-2 mb-2 cursor-pointer" onclick="window.location='{{ route('profile', $user->id) }}'">
                    <img src="{{ $user->avatar_url }}" class="w-8 h-8 rounded-full" alt="{{ $user->name }}">
                    <span class="text-gray-900 dark:text-white">{{ $user->name }}</span>
                </div>
            @empty
                <p class="text-gray-500">No users found.</p>
            @endforelse
        </div>

        <div>
            <h3 class="text-xl font-semibold mb-2">Kisah</h3>
            @forelse ($kisahResults as $kisah)
                <div class="border p-4 rounded mb-2 bg-white dark:bg-neutral-900">
                    <a href="{{ route('kisah.show', $kisah->id) }}" class="text-lg font-semibold dark:text-white">{{ $kisah->judul }}</a>
                    <p class="text-sm text-gray-500">by {{ $kisah->user->name }}</p>
                    <div class="flex gap-2 mt-1 text-sm">
                        @foreach ($kisah->genres as $genre)
                            <span class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 rounded">
                                {{ $genre->genre }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No stories found.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>


