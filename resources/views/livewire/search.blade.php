    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Pencarian</h1>
            
            <!-- Search Bar -->
            <div class="relative mb-6">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input 
                    wire:model.live.debounce.300ms="search"
                    type="text" 
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-gray-800 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Cari {{ $searchType === 'kisah' ? 'kisah...' : 'user...' }}">
            </div>
            
            <!-- Toggle Search Type -->
            <div class="flex mb-6">
                <button 
                    wire:click="$set('searchType', 'kisah')" 
                    class="px-4 py-2 rounded-l-md font-medium {{ $searchType === 'kisah' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Cari Kisah
                </button>
                <button 
                    wire:click="$set('searchType', 'user')" 
                    class="px-4 py-2 rounded-r-md font-medium {{ $searchType === 'user' ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                    Cari User
                </button>
            </div>
            
            <!-- Genre Filters (only show when searching kisah) -->
            @if($searchType === 'kisah')
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Filter Genre</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($genres as $genre)
                            <button 
                                wire:click="toggleGenre('{{ $genre }}')"
                                class="px-3 py-1 rounded-full text-sm {{ in_array($genre, $selectedGenres) ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                {{ $genre }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Search Results -->
        <div class="space-y-6">
            @if($searchType === 'kisah')
                @forelse($results as $kisah)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('kisah.show', $kisah) }}" class="text-xl font-semibold text-gray-900 dark:text-white hover:underline">
                                    {{ $kisah->judul }}
                                </a>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Oleh: <a href="{{ route('profile', $kisah->user) }}" class="hover:underline">{{ $kisah->user->name }}</a>
                                </span>
                            </div>
                            
                            <p class="mt-2 text-gray-600 dark:text-gray-300">{{ Str::limit($kisah->sinopsis, 200) }}</p>
                            
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach($kisah->genres as $genre)
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100">
                                        {{ $genre->genre }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        @if($search || $selectedGenres)
                            Tidak ditemukan kisah yang sesuai dengan pencarian Anda.
                        @else
                            Gunakan kolom pencarian di atas untuk menemukan kisah.
                        @endif
                    </p>
                @endforelse
            @else
                @forelse($results as $user)
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                        <div class="p-6 flex items-center">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full mr-4">
                            <div>
                                <a href="{{ route('profile', $user) }}" class="text-lg font-semibold text-gray-900 dark:text-white hover:underline">
                                    {{ $user->name }}
                                </a>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                        @if($search)
                            Tidak ditemukan user yang sesuai dengan pencarian Anda.
                        @else
                            Gunakan kolom pencarian di atas untuk menemukan user.
                        @endif
                    </p>
                @endforelse
            @endif
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $results->links() }}
            </div>
        </div>
    </div>