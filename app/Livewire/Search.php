<?php

namespace App\Livewire;


use App\Models\Kisah;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;

    public string $search = '';
    public array $selectedGenres = [];
    public string $searchType = 'kisah'; // 'kisah' atau 'user'

    // Enum genre
    public array $genres = [
        'Romance',
        'Fantasy',
        'Horror',
        'Misteri',
        'Laga',
        'Sejarah',
        'Fiksi Ilmiah',
        'Petualangan'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $results = [];

        if ($this->searchType === 'kisah') {
            $query = Kisah::query()
                ->when($this->search, function ($query) {
                    $query->where('judul', 'like', '%' . $this->search . '%')
                        ->orWhere('sinopsis', 'like', '%' . $this->search . '%');
                });

            // Filter untuk SEMUA genre yang dipilih
            foreach ($this->selectedGenres as $genre) {
                $query->whereHas('genres', function ($q) use ($genre) {
                    $q->where('genre', $genre);
                });
            }

            $results = $query->with('user', 'genres')
                ->latest()
                ->paginate(10);
        } else {
            $results = User::query()
                ->when($this->search, function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->latest()
                ->paginate(10);
        }

        return view('livewire.search', [
            'results' => $results,
        ]);
    }

    public function toggleGenre(string $genre)
    {
        if (in_array($genre, $this->selectedGenres)) {
            $this->selectedGenres = array_diff($this->selectedGenres, [$genre]);
        } else {
            $this->selectedGenres[] = $genre;
        }

        $this->resetPage();
    }
}
