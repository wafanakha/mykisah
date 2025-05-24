<x-layouts.app :title="$kisah->judul">

    <div class="bg-white dark:bg-gray-900 text-black dark:text-white rounded-lg p-6">
        <div class="mb-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $kisah->judul }}</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Ditulis oleh <strong>{{ $kisah->user->name }}</strong> pada {{ $kisah->created_at->format('M d, Y') }}
            </p>
            <div class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                @foreach ($kisah->genres as $genre)
                    <span class="inline-block bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100 px-2 py-1 rounded text-xs mr-1">
                        {{ $genre->genre }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="prose dark:prose-invert max-w-none">
            {!! nl2br(e($kisah->isi)) !!}
        </div>

        <hr class="my-6 border-gray-300 dark:border-gray-700" />

        <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-5">Komentar</h2>
        @foreach($kisah->comments as $comment)
            <div class="flex items-start gap-3 mb-5">
                <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-full">
                <div>
                    <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</div>
                    <div class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->isi }}</div>
                </div>
            </div>
        @endforeach


        {{-- Form komentar --}}
        <form method="POST" action="{{ route('komen.store') }}">
            @csrf
            <input type="hidden" name="kisah_id" value="{{ $kisah->id }}">
            <textarea name="isi" rows="3" class="w-full p-2 rounded border dark:bg-neutral-900 dark:border-neutral-700 dark:text-white mb-2" placeholder="Tulis komentar..."></textarea>
            <flux:button variant="primary" type="submit" class="">{{ __('Save') }}</flux:button>
        </form>
    </div>

</x-layouts.app>
