<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToolController extends Controller
{
    /**
     * Display a listing of tools
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        
        $query = Tool::query();
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('fungsi', 'like', '%' . $search . '%');
            });
        }
        
        $tools = $query->latest()->paginate($perPage);

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
    }

    /**
     * Display the specified tool
     */
    public function show($id)
    {
        $tool = Tool::find($id);

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
    }

    /**
     * Store a newly created tool
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fungsi' => 'required|string',
            'gambar' => 'nullable|string',
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $tool = Tool::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tool created successfully',
            'data' => new ToolResource($tool)
        ], 201);
    }

    /**
     * Update the specified tool
     */
    public function update(Request $request, $id)
    {
        $tool = Tool::find($id);

        if (!$tool) {
            return response()->json([
                'success' => false,
                'message' => 'Tool not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fungsi' => 'required|string',
            'gambar' => 'nullable|string',
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $tool->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tool updated successfully',
            'data' => new ToolResource($tool)
        ]);
    }

    /**
     * Remove the specified tool
     */
    public function destroy($id)
    {
        $tool = Tool::find($id);

        if (!$tool) {
            return response()->json([
                'success' => false,
                'message' => 'Tool not found'
            ], 404);
        }

        $tool->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tool deleted successfully'
        ]);
    }
}
