<div class="max-w-4xl mx-auto py-8 px-4">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Kisah</h1>

    @if(session('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


    <form wire:submit.prevent="save" class="space-y-6">
        <!-- Judul -->
        <div>
            <label for="judul" class="block text-gray-700 dark:text-gray-300">Judul</label>
            <input 
                type="text" 
                id="judul" 
                wire:model="judul" 
                class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white" required>
            @error('judul') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Sinopsis -->
        <div>
            <label for="sinopsis" class="block text-gray-700 dark:text-gray-300">Sinopsis</label>
            <textarea 
                id="sinopsis" 
                wire:model="sinopsis" 
                rows="3" 
               class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white" required></textarea>
            @error('sinopsis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
            <label for="isi" class="block text-gray-700 dark:text-gray-300">Isi Kisah</label>
            <textarea 
                id="isi" 
                wire:model="isi" 
                rows="15" 
                class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white" required></textarea>
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