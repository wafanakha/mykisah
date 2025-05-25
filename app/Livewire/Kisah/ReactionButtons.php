<?php

namespace App\Livewire\Kisah;

use App\Models\Kisah;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReactionButtons extends Component
{
    public Kisah $kisah;

    public int $likeCount = 0;
    public int $dislikeCount = 0;
    public ?int $userReaction = null; // 1 = like, -1 = dislike, null = no reaction

    public function mount(Kisah $kisah)
    {
        $this->kisah = $kisah;
        $this->updateReactionData();
    }

    public function like()
    {
        $this->react(1);
    }

    public function dislike()
    {
        $this->react(-1);
    }

    protected function react(int $value)
    {
        $user = User::find(Auth::id());

        if (!$user) return;

        // Hapus jika user mengklik reaksi yang sama
        if ($this->userReaction === $value) {
            $user->reactedKisah()->detach($this->kisah->id);
        } else {
            $user->reactedKisah()->syncWithoutDetaching([
                $this->kisah->id => ['value' => $value]
            ]);
        }

        $this->updateReactionData();
    }

    protected function updateReactionData()
    {
        $this->likeCount = $this->kisah->reactions()->wherePivot('value', 1)->count();
        $this->dislikeCount = $this->kisah->reactions()->wherePivot('value', -1)->count();

        $this->userReaction = Auth::check()
            ? $this->kisah->reactions()->where('user_id', Auth::id())->value('value')
            : null;
    }

    public function render()
    {
        return view('livewire.kisah.reaction-buttons');
    }
}
