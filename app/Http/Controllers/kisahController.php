<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\bookmark;
use App\Models\Kisah;
use App\Models\genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class kisahController extends Controller
{
    use AuthorizesRequests;

    public function show($id)
    {
        $kisah = Kisah::with([
            'user',
            'genres',
            'comments',
            'reactions',
            'bookmarkedBy'
        ])->findOrFail($id);

        // Add reaction counts and current user's status
        $kisah->like_count = $kisah->reactions()->wherePivot('value', 1)->count();
        $kisah->dislike_count = $kisah->reactions()->wherePivot('value', -1)->count();
        $kisah->bookmark_count = $kisah->bookmarkedBy()->count();

        // Get current user's reaction and bookmark status
        $userReaction = $kisah->reactions()
            ->where('user_id', Auth::id())
            ->first();

        $kisah->current_user_reaction = $userReaction ? $userReaction->pivot->value : null;
        $kisah->is_bookmarked = $kisah->bookmarkedBy()
            ->where('user_id', Auth::id())
            ->exists();

        return $kisah;
    }

    public function showAll()
    {
        return Kisah::with([
            'user',
            'genres',
            'comments',
            'reactions',
            'bookmarkedBy'
        ])->get()
            ->map(function ($kisah) {
                $kisah->like_count = $kisah->reactions()->wherePivot('value', 1)->count();
                $kisah->dislike_count = $kisah->reactions()->wherePivot('value', -1)->count();
                $kisah->bookmark_count = $kisah->bookmarkedBy()->count();

                $userReaction = $kisah->reactions()
                    ->where('user_id', Auth::id())
                    ->first();

                $kisah->current_user_reaction = $userReaction ? $userReaction->pivot->value : null;
                $kisah->is_bookmarked = $kisah->bookmarkedBy()
                    ->where('user_id', Auth::id())
                    ->exists();

                return $kisah;
            });
    }

    public function getKisahSearch()
    {
        return Kisah::select('kisah.id', 'kisah.judul', 'kisah.user_id')
            ->with(['user', 'genres', 'reactions', 'bookmarkedBy'])
            ->get()
            ->map(function ($kisah) {
                return [
                    'id' => $kisah->id,
                    'judul' => $kisah->judul,
                    'user_name' => $kisah->user->name,
                    'genres' => $kisah->genres->pluck('genre'),
                    'like_count' => $kisah->reactions()->wherePivot('value', 1)->count(),
                    'dislike_count' => $kisah->reactions()->wherePivot('value', -1)->count(),
                    'bookmark_count' => $kisah->bookmarkedBy()->count(),
                    'current_user_reaction' => $kisah->reactions()
                        ->where('user_id', Auth::id())
                        ->first()->pivot->value ?? null,
                    'is_bookmarked' => $kisah->bookmarkedBy()
                        ->where('user_id', Auth::id())
                        ->exists()
                ];
            });
    }

    public function getUserKisah($id)
    {
        return Kisah::with([
            'user',
            'genres',
            'comments.user',
            'reactions',
            'bookmarkedBy'
        ])
            ->where('user_id', $id)
            ->get()
            ->map(function ($kisah) {
                $kisah->like_count = $kisah->reactions()->wherePivot('value', 1)->count();
                $kisah->dislike_count = $kisah->reactions()->wherePivot('value', -1)->count();
                $kisah->bookmark_count = $kisah->bookmarkedBy()->count();

                $userReaction = $kisah->reactions()
                    ->where('user_id', Auth::id())
                    ->first();

                $kisah->current_user_reaction = $userReaction ? $userReaction->pivot->value : null;
                $kisah->is_bookmarked = $kisah->bookmarkedBy()
                    ->where('user_id', Auth::id())
                    ->exists();

                return $kisah;
            });
    }

    public function getUserKisahSorted($id, $order = 'asc')
    {
        if (!in_array($order, ['asc', 'desc'])) {
            return response()->json(['error' => 'Invalid sort direction'], 400);
        }

        return Kisah::with([
            'genres',
            'comments',
            'user',
            'reactions',
            'bookmarkedBy'
        ])
            ->where('user_id', $id)
            ->orderBy('created_at', $order)
            ->get()
            ->map(function ($kisah) {
                $kisah->like_count = $kisah->reactions()->wherePivot('value', 1)->count();
                $kisah->dislike_count = $kisah->reactions()->wherePivot('value', -1)->count();
                $kisah->bookmark_count = $kisah->bookmarkedBy()->count();

                $userReaction = $kisah->reactions()
                    ->where('user_id', Auth::id())
                    ->first();

                $kisah->current_user_reaction = $userReaction ? $userReaction->pivot->value : null;
                $kisah->is_bookmarked = $kisah->bookmarkedBy()
                    ->where('user_id', Auth::id())
                    ->exists();

                return $kisah;
            });
    }

    public function store(Request $request)
    {
        // Validasi input awal
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sinopsis' => 'required|string|max:255',
            'isi' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'in:Romance,Fantasy,Horror,Misteri,Laga,Sejarah,Fiksi Ilmiah,Petualangan'
        ]);

        // Validasi konten dengan Deepseek
        $validationResult = $this->validateContentWithDeepseek($validated);
        if ($validationResult !== true) {
            return response()->json([
                'error' => 'Content validation failed',
                'messages' => $validationResult
            ], 422);
        }

        // Simpan kisah jika lolos validasi
        $kisah = Kisah::create([
            'judul' => $validated['judul'],
            'sinopsis' => $validated['sinopsis'],
            'isi' => $validated['isi'],
            'user_id' => Auth::id(),
            'like' => 0,
            'dislike' => 0,
        ]);

        foreach ($validated['genres'] as $genre) {
            Genre::create([
                'kisah_id' => $kisah->id,
                'genre' => $genre
            ]);
        }

        return response()->json([
            'message' => 'Kisah dan genre berhasil ditambahkan!',
            'kisah' => $kisah->load('genres', 'user')
        ], 201);
    }

    public function validateContentWithDeepseek($data)
    {
        $contents = [
            'judul' => $data['judul'],
            'sinopsis' => $data['sinopsis'],
            'isi' => $data['isi'],
        ];

        $invalidSections = [];

        foreach ($contents as $field => $text) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer sk-0983a0afc14c4d74b4dd0589bb3ef673',
                    'Content-Type' => 'application/json',
                ])->post('https://api.deepseek.com/v1/chat/completions', [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Anda adalah moderator untuk aplikasi mykisah. Periksa konten dan tentukan apakah konten ini valid (tidak mengandung kata vulgar, ujaran kebencian, atau konten tidak pantas) namun masih meloloskan kata atau kalimat yang tidak vulgar. Output harus dalam format JSON dengan kunci "valid" (boolean) dan "reason" (string opsional).'
                        ],
                        [
                            'role' => 'user',
                            'content' => $text
                        ]
                    ],
                    'response_format' => ['type' => 'json_object'],
                    'stream' => false,
                ]);

                Log::info("Deepseek validation for {$field}", [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);

                if (!$response->successful()) {
                    throw new \Exception("Deepseek API returned status: " . $response->status());
                }

                $result = json_decode($response->body(), true);
                $messageContent = $result['choices'][0]['message']['content'] ?? null;

                if (!$messageContent) {
                    $invalidSections[$field] = 'No content in API response';
                    continue;
                }

                $validationResult = json_decode($messageContent, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $invalidSections[$field] = 'Invalid JSON response from API';
                    continue;
                }

                if (!isset($validationResult['valid'])) {
                    $invalidSections[$field] = 'Missing valid key in response';
                    continue;
                }

                if ($validationResult['valid'] !== true) {
                    $reason = $validationResult['reason'] ?? 'Content not appropriate';
                    $invalidSections[$field] = $reason;
                }
            } catch (\Exception $e) {
                Log::error("Deepseek validation error for {$field}: " . $e->getMessage());
                $invalidSections[$field] = 'Validation service unavailable';
            }
        }

        return empty($invalidSections) ? true : $invalidSections;
    }

    public function destroy($id)
    {
        $kisah = Kisah::findOrFail($id);

        if ($kisah->user_id != Auth::id()) {
            return response()->json(['message' => 'Kisah bukan dimiliki user!'], 403);
        } else {
            $kisah->genres()->delete();
            $kisah->comments()->delete();
            $kisah->bookmarkedBy()->detach();
            $kisah->delete();
            return response()->json(['message' => 'Kisah Dihapus!']);
        }
    }

    public function update(Request $request, $id)
    {
        $kisah = Kisah::findOrFail($id);

        if ($kisah->user_id != Auth::id()) {
            return response()->json(['message' => 'Kisah bukan dimiliki user!'], 403);
        }

        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'sinopsis' => 'sometimes|required|string|max:255',
            'isi' => 'sometimes|required|string',
            'genres' => 'nullable|array',
            'genres.*' => 'in:Romance,Fantasy,Horror,Misteri,Laga,Sejarah,Fiksi Ilmiah,Petualangan'
        ]);

        $validationResult = $this->validateContentWithDeepseek($validated);
        if ($validationResult !== true) {
            return response()->json([
                'error' => 'Content validation failed',
                'messages' => $validationResult
            ], 422);
        }

        $kisah->fill($validated);
        $kisah->save();

        if (isset($validated['genres'])) {
            // Hapus genre lama
            $kisah->genres()->delete();

            // Tambah genre baru
            foreach ($validated['genres'] as $genre) {
                \App\Models\genre::create([
                    'kisah_id' => $kisah->id,
                    'genre' => $genre
                ]);
            }
        }

        return response()->json([
            'message' => 'Kisah berhasil diperbarui',
            'kisah' => $kisah->load('genres', 'user')
        ]);
    }


    public function index()
    {
        $user = User::find(Auth::id());
        $kisahs = Kisah::with('user')->get();
        $token = session()->get('accessToken');

        $kisahList = Kisah::with(['user', 'genres'])->latest()->get()->shuffle();
        $bookmarkedIds = $user->bookmarks()->pluck('kisah_id')->toArray();

        return view('dashboard', compact('kisahList', 'bookmarkedIds', 'token'));
    }

    public function web_show($id)
    {
        $kisah = Kisah::with(['user', 'genres', 'comments.user'])->findOrFail($id);

        return view('kisah.show', compact('kisah'));
    }

    public function like($id)
    {
        $kisah = Kisah::findOrFail($id);
        $kisah->increment('like');
        return response()->json(['message' => 'Liked']);
    }

    public function dislike($id)
    {
        $kisah = Kisah::findOrFail($id);
        $kisah->increment('dislike');
        return response()->json(['message' => 'Disliked']);
    }

    public function toggleBookmark($id)
    {
        $kisah = Kisah::findOrFail($id);
        $user = User::find(Auth::id());

        if ($user->bookmarks()->where('kisah_id', $id)->exists()) {
            $user->bookmarks()->detach($id);
            return response()->json(['bookmarked' => false]);
        } else {
            $user->bookmarks()->attach($id);
            return response()->json(['bookmarked' => true]);
        }
    }

    public function web_create()
    {
        $genres = Genre::all();
        return view('kisah.create', compact('genres'));
    }

    public function web_store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sinopsis' => 'required|string|max:255',
            'isi' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'in:Romance,Fantasy,Horror,Misteri,Laga,Sejarah,Fiksi Ilmiah,Petualangan'
        ]);

        $validationResult = $this->validateContentWithDeepseek($validated);
        if ($validationResult !== true) {
            return back()
                ->withErrors(['content_validation' => $validationResult])
                ->withInput();
        }

        $kisah = Kisah::create([
            'judul' => $validated['judul'],
            'sinopsis' => $validated['sinopsis'],
            'isi' => $validated['isi'],
            'user_id' => Auth::id(),
            'like' => 0,
            'dislike' => 0,
        ]);

        $this->authorize('update', $kisah);
        foreach ($validated['genres'] as $genre) {
            genre::create([
                'kisah_id' => $kisah->id,
                'genre' => $genre
            ]);
        }

        return redirect()->route('profile', Auth::id())->with('success', 'Kisah berhasil dibuat!');
    }

    public function web_destroy(Kisah $kisah)
    {
        $this->authorize('delete', $kisah);


        DB::transaction(function () use ($kisah) {
            // Delete all related records
            $kisah->genres()->delete();
            $kisah->comments()->delete();

            // Handle reactions (pivot table)
            $kisah->reactions()->detach();

            // Handle bookmarks (assuming many-to-many relationship)
            $kisah->bookmarkedBy()->detach();

            // Finally delete the kisah
            $kisah->delete();
        });

        return redirect()->route('profile', $kisah->user)
            ->with('success', 'Kisah deleted successfully');
    }
}
