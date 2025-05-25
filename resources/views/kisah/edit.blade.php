<x-layouts.app :title="'Edit Kisah: ' . $kisah->judul">
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Kisah</h1>

        <form method="POST" action="{{ route('kisah.update', $kisah) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $kisah->judul) }}"
                    class="w-full border px-3 py-2 rounded">
                @error('judul') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Sinopsis</label>
                <textarea name="sinopsis" rows="5"
                    class="w-full border px-3 py-2 rounded">{{ old('sinopsis', $kisah->sinopsis) }}</textarea>
                @error('sinopsis') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-2">Genre</label>
                <div class="flex flex-wrap gap-2">
                    @foreach ($genres as $genre)
                        <label class="flex items-center gap-1">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                {{ in_array($genre->id, old('genres', $selectedGenres)) ? 'checked' : '' }}>
                            {{ $genre->genre }}
                        </label>
                    @endforeach
                </div>
                @error('genres') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Perbarui Kisah</button>
                <a href="{{ route('kisah.show', $kisah) }}" class="ml-4 text-blue-500 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-layouts.app>
