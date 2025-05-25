<x-layouts.app :title="'Buat Kisah'">
    <div class="max-w-2xl mx-auto p-6 bg-white dark:bg-neutral-900 rounded shadow">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Buat Kisah Baru</h1>

        @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kisah.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="judul" class="block text-gray-700 dark:text-gray-300">Judul</label>
                <input type="text" id="judul" name="judul" class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white" required>
            </div>

            <div class="mb-4">
                <label for="sinopsis" class="block text-gray-700 dark:text-gray-300">Sinopsis</label>
                <textarea id="sinopsis" name="sinopsis" rows="3" class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white" required></textarea>
            </div>

            <div class="mb-4">
                <label for="isi" class="block text-gray-700 dark:text-gray-300">Isi Kisah</label>
                <textarea id="isi" name="isi" rows="8" class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white" required></textarea>
            </div>

            <div class="mb-4">
                <label for="genres" class="block text-gray-700 dark:text-gray-300">Genre</label>
                <select id="genres" name="genres[]" multiple class="w-full p-2 border rounded dark:bg-neutral-800 dark:text-white">
                        <option value='Romance'>Romance</option>
                        <option value='Fantasy'>Fantasy</option> 'Romance', 'Fantasy', 'Horror', 'Misteri', 'Laga', 'Sejarah', 'Fiksi Ilmiah', 'Petualangan'
                        <option value='Horror'>Horror</option>
                        <option value='Misteri'>Misteri</option>
                        <option value='Laga'>Laga</option>
                        <option value='Sejarah'>Sejarah</option>
                        <option value='Fiksi Ilmiah'>Fiksi Ilmiah</option>
                        <option value='Petualangan'>Petualangan</option>
                </select>
                <small class="text-gray-500">Tekan Ctrl (Windows) / Command (Mac) untuk memilih lebih dari satu</small>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan Kisah
            </button>
        </form>
    </div>
</x-layouts.app>
