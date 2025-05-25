<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kisah;
use App\Models\User;

class Search extends Component
{
    public string $query = '';

    public function render()
    {
        $kisahResults = Kisah::with(['user', 'genres'])
            ->where('judul', 'like', "%{$this->query}%")
            ->orWhereHas('genres', function ($q) {
                $q->where('genre', 'like', "%{$this->query}%");
            })
            ->orWhereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->query}%");
            })
            ->get();

        $userResults = User::where('name', 'like', "%{$this->query}%")->get();

        return view('livewire.search', [
            'kisahResults' => $kisahResults,
            'userResults' => $userResults,
        ]);
    }
}
