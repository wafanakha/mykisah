<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FollowButton extends Component
{
    public User $user;
    public bool $isFollowing;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->isFollowing = Auth::check() && User::find(Auth::id())->isFollowing($user);
    }

    public function toggleFollow()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $currentUser = User::find(Auth::id());

        if ($this->isFollowing) {
            $currentUser->unfollow($this->user);
        } else {
            $currentUser->follow($this->user);
        }

        $this->isFollowing = !$this->isFollowing;

        // Dispatch event to refresh parent component
        $this->dispatch('refreshFollowerCount');
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
