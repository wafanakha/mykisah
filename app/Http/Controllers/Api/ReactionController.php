<?php

namespace App\Http\Controllers\Api;

use App\Models\Kisah;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReactionController extends Controller
{
    // Store or update reaction
    public function store(Request $request, Kisah $kisah)
    {
        $request->validate([
            'value' => 'required|integer|in:-1,1' // -1 for dislike, 1 for like
        ]);

        $user = Auth::user();

        // Using syncWithoutDetach to update or create
        $kisah->reactions()->syncWithoutDetaching([
            $user->id => ['value' => $request->value]
        ]);

        // Get updated counts
        $counts = $this->getReactionCounts($kisah);

        return response()->json([
            'message' => 'Reaction saved successfully',
            'reaction' => $kisah->reactions()->where('user_id', $user->id)->first()->pivot,
            'like_count' => $counts['likes'],
            'dislike_count' => $counts['dislikes']
        ]);
    }

    // Get user's reaction to a kisah
    public function show(Kisah $kisah)
    {
        $user = Auth::user();
        $reaction = $kisah->reactions()
            ->where('user_id', $user->id)
            ->first();

        $counts = $this->getReactionCounts($kisah);

        return response()->json([
            'reaction' => $reaction ? $reaction->pivot : null,
            'like_count' => $counts['likes'],
            'dislike_count' => $counts['dislikes']
        ]);
    }

    // Remove reaction
    public function destroy(Kisah $kisah)
    {
        $user = Auth::user();
        $kisah->reactions()->detach($user->id);

        $counts = $this->getReactionCounts($kisah);

        return response()->json([
            'message' => 'Reaction removed successfully',
            'like_count' => $counts['likes'],
            'dislike_count' => $counts['dislikes']
        ]);
    }

    // Get all reactions for a user
    public function userReactions(User $user)
    {
        $reactions = $user->reactedKisah()
            ->withPivot('value')
            ->withTimestamps()
            ->paginate(10);

        return response()->json($reactions);
    }

    // Helper method to get reaction counts
    private function getReactionCounts(Kisah $kisah)
    {
        $counts = DB::table('kisah_user_reactions')
            ->where('kisah_id', $kisah->id)
            ->selectRaw('SUM(CASE WHEN value = 1 THEN 1 ELSE 0 END) as likes')
            ->selectRaw('SUM(CASE WHEN value = -1 THEN 1 ELSE 0 END) as dislikes')
            ->first();

        return [
            'likes' => $counts->likes ?? 0,
            'dislikes' => $counts->dislikes ?? 0
        ];
    }
}
