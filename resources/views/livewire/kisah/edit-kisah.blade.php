<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Kisah</h1>

    @if(session('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Judul -->
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul</label>
            <input 
                type="text" 
                id="judul" 
                wire:model="judul" 
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white">
            @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Sinopsis -->
        <div>
            <label for="sinopsis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sinopsis</label>
            <textarea 
                id="sinopsis" 
                wire:model="sinopsis" 
                rows="3" 
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white"></textarea>
            @error('sinopsis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Cover -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cover</label>
            <div class="mt-1 flex items-center">
                @if($tempCover || $kisah->cover_url)
                    <img src="{{ $tempCover ?? $kisah->cover_url }}" alt="Preview Cover" class="h-32 w-32 object-cover rounded-md">
                @endif
                <div class="ml-4">
                    <input 
                        type="file" 
                        wire:model="cover" 
                        accept="image/*"
                        class="text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900 dark:file:text-blue-100
                            hover:file:bg-blue-100 dark:hover:file:bg-blue-800">
                    @error('cover') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Genre -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Genre</label>
            <div class="flex flex-wrap gap-2">
                @foreach($allGenres as $genre)
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            wire:model="selectedGenres" 
                            value="{{ $genre }}" 
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700">
                        <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $genre }}</span>
                    </label>
                @endforeach
            </div>
            @error('selectedGenres') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Isi -->
        <div>
            <label for="isi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Isi Kisah</label>
            <textarea 
                id="isi" 
                wire:model="isi" 
                rows="15" 
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:text-white"></textarea>
            @error('isi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Actions -->
        <div class="flex justify-end space-x-4">
            <a 
                href="{{ route('kisah.show', $kisah) }}" 
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            <button 
                type="submit" 
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>