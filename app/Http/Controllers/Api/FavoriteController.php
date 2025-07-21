<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display user's favorite tools.
     */
    public function index(): JsonResponse
    {
        try {
            $user = Auth::user();
            $favorites = $user->favoriteTools()
                ->active()
                ->with(['category'])
                ->paginate(10);
            
            return response()->json([
                'success' => true,
                'message' => 'Favorites retrieved successfully',
                'data' => $favorites
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve favorites',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add tool to favorites.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id'
        ]);

        try {
            $user = Auth::user();
            $toolId = $request->tool_id;
            
            // Check if tool exists and is active
            $tool = Tool::active()->findOrFail($toolId);
            
            // Check if already favorited
            if ($user->hasFavorited($toolId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool already in favorites'
                ], 400);
            }

            $favorite = Favorite::create([
                'user_id' => $user->id,
                'tool_id' => $toolId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tool added to favorites successfully',
                'data' => $favorite->load('tool')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add to favorites',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove tool from favorites.
     */
    public function destroy($toolId): JsonResponse
    {
        try {
            $user = Auth::user();
            
            $favorite = Favorite::where('user_id', $user->id)
                ->where('tool_id', $toolId)
                ->first();

            if (!$favorite) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool not found in favorites'
                ], 404);
            }

            $favorite->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tool removed from favorites successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove from favorites',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if tool is favorited by user.
     */
    public function check($toolId): JsonResponse
    {
        try {
            $user = Auth::user();
            $isFavorited = $user->hasFavorited($toolId);
            
            return response()->json([
                'success' => true,
                'message' => 'Favorite status retrieved successfully',
                'data' => [
                    'is_favorited' => $isFavorited
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check favorite status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}