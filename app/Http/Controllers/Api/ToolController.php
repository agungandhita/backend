<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolResource;
use App\Models\Tool;

use Illuminate\Http\Request;


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
     * Display the specified tool
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

            return response()->json([
                'success' => true,
                'message' => 'Tool retrieved successfully',
                'data' => new ToolResource($tool)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }




}
