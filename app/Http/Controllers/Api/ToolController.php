<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use App\Models\Favorite;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ToolController extends Controller
{
    /**
     * Display a listing of tools with enhanced filtering
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search');
            $category = $request->get('category');
            $categoryId = $request->get('category_id');
            $featured = $request->get('featured');
            $sortBy = $request->get('sort_by', 'latest'); // latest, popular, name

            $query = Tool::with(['category'])->active();

            // Search functionality
            if ($search) {
                $query->search($search);
            }

            // Category filter
            if ($category) {
                $query->where('kategori', $category);
            }

            if ($categoryId) {
                $query->byCategory($categoryId);
            }

            // Featured filter
            if ($featured) {
                $query->featured();
            }

            // Sorting
            switch ($sortBy) {
                case 'popular':
                    $query->popular();
                    break;
                case 'name':
                    $query->orderBy('nama', 'asc');
                    break;
                default:
                    $query->latest();
                    break;
            }

            $tools = $query->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Tools retrieved successfully',
                'data' => ToolResource::collection($tools->items()),
                'pagination' => [
                    'current_page' => $tools->currentPage(),
                    'last_page' => $tools->lastPage(),
                    'per_page' => $tools->perPage(),
                    'total' => $tools->total(),
                    'from' => $tools->firstItem(),
                    'to' => $tools->lastItem()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tools',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified tool with view increment
     */
    public function show($id)
    {
        try {
            $tool = Tool::with(['category'])->active()->find($id);

            if (!$tool) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool not found'
                ], 404);
            }

            // Increment view count
            $tool->incrementViews();

            // Check if user has favorited this tool
            $isFavorited = false;
            if (Auth::check()) {
                $isFavorited = Auth::user()->hasFavorited($tool->id);
            }

            $toolData = new ToolResource($tool);
            $toolData->additional(['is_favorited' => $isFavorited]);

            return response()->json([
                'success' => true,
                'message' => 'Tool retrieved successfully',
                'data' => $toolData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created tool with file uploads
     */
    public function store(StoreToolRequest $request)
    {
        try {
            $fileUploadService = new FileUploadService();
            
            $toolData = $request->only([
                'nama', 'deskripsi', 'fungsi', 'kategori', 'category_id',
                'is_featured', 'is_active', 'tags', 'url_video'
            ]);

            // Handle image upload
            if ($request->hasFile('gambar')) {
                $toolData['gambar'] = $fileUploadService->uploadImage(
                    $request->file('gambar'),
                    'tools'
                );
            }

            // Handle PDF upload
            if ($request->hasFile('file_pdf')) {
                $toolData['file_pdf'] = $fileUploadService->uploadPdf(
                    $request->file('file_pdf'),
                    'pdfs'
                );
            }

            $tool = Tool::create($toolData);
            $tool->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Tool created successfully',
                'data' => new ToolResource($tool)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified tool with file uploads
     */
    public function update(UpdateToolRequest $request, $id)
    {
        try {
            $tool = Tool::find($id);

            if (!$tool) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool not found'
                ], 404);
            }

            $fileUploadService = new FileUploadService();
            
            $toolData = $request->only([
                'nama', 'deskripsi', 'fungsi', 'kategori', 'category_id',
                'is_featured', 'is_active', 'tags', 'url_video'
            ]);

            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image
                if ($tool->gambar) {
                    $fileUploadService->deleteFile($tool->gambar, 'tools');
                }
                
                $toolData['gambar'] = $fileUploadService->uploadImage(
                    $request->file('gambar'),
                    'tools'
                );
            }

            // Handle PDF upload
            if ($request->hasFile('file_pdf')) {
                // Delete old PDF
                if ($tool->file_pdf) {
                    $fileUploadService->deleteFile($tool->file_pdf, 'pdfs');
                }
                
                $toolData['file_pdf'] = $fileUploadService->uploadPdf(
                    $request->file('file_pdf'),
                    'pdfs'
                );
            }

            $tool->update($toolData);
            $tool->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Tool updated successfully',
                'data' => new ToolResource($tool)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified tool
     */
    public function destroy($id)
    {
        try {
            $tool = Tool::find($id);

            if (!$tool) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tool not found'
                ], 404);
            }

            $fileUploadService = new FileUploadService();
            
            // Delete associated files
            if ($tool->gambar) {
                $fileUploadService->deleteFile($tool->gambar, 'tools');
            }
            
            if ($tool->file_pdf) {
                $fileUploadService->deleteFile($tool->file_pdf, 'pdfs');
            }

            $tool->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tool deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get featured tools
     */
    public function featured(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            
            $tools = Tool::with(['category'])
                ->active()
                ->featured()
                ->latest()
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Featured tools retrieved successfully',
                'data' => ToolResource::collection($tools->items()),
                'pagination' => [
                    'current_page' => $tools->currentPage(),
                    'last_page' => $tools->lastPage(),
                    'per_page' => $tools->perPage(),
                    'total' => $tools->total()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve featured tools',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get popular tools based on views
     */
    public function popular(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            
            $tools = Tool::with(['category'])
                ->active()
                ->popular()
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Popular tools retrieved successfully',
                'data' => ToolResource::collection($tools->items()),
                'pagination' => [
                    'current_page' => $tools->currentPage(),
                    'last_page' => $tools->lastPage(),
                    'per_page' => $tools->perPage(),
                    'total' => $tools->total()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve popular tools',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle favorite status for a tool
     */
    public function toggleFavorite(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $tool = Tool::active()->findOrFail($id);
            
            $favorite = Favorite::where('user_id', $user->id)
                ->where('tool_id', $tool->id)
                ->first();

            if ($favorite) {
                // Remove from favorites
                $favorite->delete();
                $message = 'Tool removed from favorites';
                $isFavorited = false;
            } else {
                // Add to favorites
                Favorite::create([
                    'user_id' => $user->id,
                    'tool_id' => $tool->id
                ]);
                $message = 'Tool added to favorites';
                $isFavorited = true;
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => [
                    'is_favorited' => $isFavorited
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle favorite',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
