<?php

namespace App\Livewire\Kisah;

use App\Models\Kisah;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ReactionButtons extends Component
{
    public Kisah $kisah;
    public int $likeCount = 0;
    public int $dislikeCount = 0;
    public bool $bookmarked = false;
    public ?int $userReaction = null;

    public function mount(Kisah $kisah)
    {
        $this->kisah = $kisah;
        $this->refreshCounts();
        $this->bookmarked = Auth::check()
            ? $this->kisah->bookmarkedBy()->where('user_id', Auth::id())->exists()
            : false;
    }

    public function like()
    {
        $this->toggleReaction(1);
    }

    public function dislike()
    {
        $this->toggleReaction(-1);
    }

    protected function toggleReaction(int $value)
    {
        if (!Auth::check()) return;

        $currentReaction = $this->kisah->reactions()
            ->where('user_id', Auth::id())
            ->first();

        if ($currentReaction && $currentReaction->pivot->value === $value) {
            // Remove reaction if clicking the same button
            $this->kisah->reactions()->detach(Auth::id());
        } else {
            // Add/update reaction
            $this->kisah->reactions()->syncWithoutDetaching([
                Auth::id() => ['value' => $value]
            ]);
        }

        $this->refreshCounts();
    }

    public function toggleBookmark()
    {
        if (!Auth::check()) return;

        $this->bookmarked = !$this->bookmarked;

        if ($this->bookmarked) {
            $this->kisah->bookmarkedBy()->attach(Auth::id());
        } else {
            $this->kisah->bookmarkedBy()->detach(Auth::id());
        }
    }

    protected function refreshCounts()
    {
        $this->likeCount = $this->kisah->reactions()
            ->where('value', 1)
            ->count();

        $this->dislikeCount = $this->kisah->reactions()
            ->where('value', -1)
            ->count();

        $this->userReaction = Auth::check()
            ? $this->kisah->reactions()
            ->where('user_id', Auth::id())
            ->first()?->pivot->value
            : null;
    }

    public function render()
    {
        return view('livewire.kisah.reaction-buttons');
    }
}
