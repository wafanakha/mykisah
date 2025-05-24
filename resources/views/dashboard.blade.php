<x-layouts.app :title="__('Dashboard')" value="light">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="flex h-full w-full flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center p-4 border-b dark:border-neutral-700">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Home</h2>
        </div>

        {{-- Timeline --}}
        <div class="flex-1 overflow-y-auto space-y-4 px-4 pb-6">
        @foreach($kisahList as $kisah)
            <div class="kisah-card border p-4 rounded-lg mb-4 bg-white dark:bg-neutral-900 shadow" data-url="{{ route('kisah.show', $kisah->id) }}">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ $kisah->user->avatar_url }}" alt="{{ $kisah->user->name }}" class="w-8 h-8 rounded-full">
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $kisah->user->name }}</span>
                </div>
                <div onclick="window.location='{{ route('kisah.show', $kisah->id) }}'" class="cursor-pointer">
                    <div class="text-lg font-semibold text-gray-900 dark:text-white mb-0.5">
                        {{ $kisah->judul }}
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">{{ $kisah->sinopsis }}</p>
                </div>

                <div class="mt-4 flex  flex-wrap gap-1 text-sm mb-2">
                    @foreach($kisah->genres as $genre)
                        <span class="bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-0.5 border p-2  rounded-lg">
                            {{ $genre->genre }}
                        </span>
                    @endforeach
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
                    <button class="btn-bookmark border p-2 rounded-lg mt-4  {{ $kisah->bookmarkedBy->contains(auth()->id()) ? 'text-yellow-500' : '' }}" data-kisah-id="{{ $kisah->id }}">
                        📌 <span class="bookmark-label">{{ $kisah->bookmarkedBy->contains(auth()->id()) ? 'Bookmarked' : 'Bookmark' }}</span>
                    </button>
                </div>
            </div>
        @endforeach


        </div>
    </div>
</x-layouts.app>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.btn-like').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const id = this.dataset.kisahId;

            const res = await fetch(`/api/kisah/${id}/like`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            });

            const data = await res.json();
            console.log(data);
        });
    });

    document.querySelectorAll('.btn-dislike').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const id = this.dataset.kisahId;

            const res = await fetch(`/api/kisah/${id}/dislike`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            });

            const data = await res.json();
            console.log(data);
            location.reload();
        });
    });

    document.querySelectorAll('.btn-bookmark').forEach(button => {
        button.addEventListener('click', async function (e) {
            e.preventDefault();
            const id = this.dataset.kisahId;

            const res = await fetch(`/api/kisah/${id}/bookmark`, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
            });

            const data = await res.json();
            console.log(data);
            location.reload();
        });
    });
});
</script>

