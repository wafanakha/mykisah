<?php

namespace App\Livewire\Kisah;

use App\Models\Kisah;
use App\Models\Genre;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EditKisah extends Component
{
    use WithFileUploads;

    public Kisah $kisah;
    public $judul;
    public $sinopsis;
    public $isi;

    public $selectedGenres = [];
    public $allGenres;

    public function mount(Kisah $kisah)
    {
        $this->kisah = $kisah;
        $this->judul = $kisah->judul;
        $this->sinopsis = $kisah->sinopsis;
        $this->isi = $kisah->isi;
        $this->selectedGenres = $kisah->genres->pluck('genre')->toArray();
        $this->allGenres = [
            'Romance',
            'Fantasy',
            'Horror',
            'Misteri',
            'Laga',
            'Sejarah',
            'Fiksi Ilmiah',
            'Petualangan'
        ];
    }

    public function rules()
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'sinopsis' => ['required', 'string', 'max:500'],
            'isi' => ['required', 'string'],
            'selectedGenres' => ['required', 'array', 'min:1'],
            'selectedGenres.*' => [Rule::in($this->allGenres)],
        ];
    }


    public function save()
    {
        $this->validate();

        // Update data kisah
        $this->kisah->update([
            'judul' => $this->judul,
            'sinopsis' => $this->sinopsis,
            'isi' => $this->isi,
        ]);


        // Sync genres
        $this->kisah->genres()->delete();
        foreach ($this->selectedGenres as $genre) {
            $this->kisah->genres()->create(['genre' => $genre]);
        }

        session()->flash('message', 'Kisah berhasil diperbarui!');
        return redirect()->route('kisah.show', $this->kisah);
    }
    public function render()
    {
        return view('livewire.kisah.edit-kisah');
    }
}
