<x-layouts.app :title="__('Profile')">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="flex items-center gap-4 mb-6">
            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $user->name }}</h1>
                <p class="text-gray-500 dark:text-gray-400">User ID: {{ $user->id }}</p>

                <div class="flex gap-4 mt-2">
                <a href="{{ route('profile.followers', $user) }}" class="hover:underline">
                    <span class="font-semibold">{{ $user->followers_count }}</span>
                    <span class="text-gray-500 dark:text-gray-400">Followers</span>
                </a>
                <a href="{{ route('profile.following', $user) }}" class="hover:underline">
                    <span class="font-semibold">{{ $user->followings_count }}</span>
                    <span class="text-gray-500 dark:text-gray-400">Following</span>
                </a>
            </div>
            </div>
            @auth
                @if(Auth::id() !== $user->id)
                    <div class="ml-auto">
                        <livewire:follow-button :user="$user" />
                    </div>
                @endif
            @endauth
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

                    <livewire:kisah.reaction-buttons :kisah="$kisah" />
                    @can('update', $kisah)
                        <div class="mt-2">
                            <a href="{{ route('kisah.edit', $kisah) }}"
                                class="inline-block text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                ✏️ Edit Kisah
                            </a>
                                    <form action="{{ route('kisah.destroy', $kisah) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this kisah?')"
                                            class="text-sm text-red-600 dark:text-red-400 hover:underline">
                                            🗑️ Delete Kisah
                                        </button>
                                    </form>
                        </div>
                    @endcan
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400">Belum ada kisah yang diunggah.</p>
            @endforelse
        </div>
    </div>
</x-layouts.app>


<script>
    setTimeout(() => {
        const alert = document.querySelector('[role="alert"]');
        if (alert) alert.remove();
    }, 3000);
</script>