<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    /**
     * Display a listing of tools
     */
    public function index()
    {
        $tools = Tool::with('category')
            ->when(request('search'), function($query) {
                $query->where('nama', 'LIKE', '%' . request('search') . '%')
                      ->orWhere('deskripsi', 'LIKE', '%' . request('search') . '%')
                      ->orWhere('fungsi', 'LIKE', '%' . request('search') . '%');
            })
            ->when(request('category'), function($query) {
                $query->where('category_id', request('category'));
            })
            ->when(request('featured') !== null, function($query) {
                $query->where('is_featured', request('featured'));
            })
            ->when(request('status') !== null, function($query) {
                $query->where('is_active', request('status'));
            })
            ->when(request('sort'), function($query) {
                switch(request('sort')) {
                    case 'nama_asc':
                        $query->orderBy('nama', 'asc');
                        break;
                    case 'nama_desc':
                        $query->orderBy('nama', 'desc');
                        break;
                    case 'popular':
                        $query->orderBy('views_count', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    default:
                        $query->latest();
                }
            }, function($query) {
                $query->latest();
            })
            ->paginate(12);
            
        $categories = Category::orderBy('nama')->get();
        
        return view('admin.tools.index', compact('tools', 'categories'));
    }

    /**
     * Show the form for creating a new tool
     */
    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.tools.create', compact('categories'));
    }

    /**
     * Store a newly created tool
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fungsi' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'tags' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active') ? true : true; // Default active
        $data['views_count'] = 0;

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('tools', 'public');
        }

        // Handle PDF file upload
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('tools/pdfs', 'public');
        }

        Tool::create($data);

        return redirect()->route('admin.tools.index')
            ->with('success', 'Tool berhasil ditambahkan.');
    }

    /**
     * Display the specified tool
     */
    public function show(Tool $tool)
    {
        return view('admin.tools.show', compact('tool'));
    }

    /**
     * Show the form for editing the specified tool
     */
    public function edit(Tool $tool)
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.tools.edit', compact('tool', 'categories'));
    }

    /**
     * Update the specified tool
     */
    public function update(Request $request, Tool $tool)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fungsi' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'tags' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $data = $request->except(['_token', '_method']);
        $data['is_featured'] = $request->has('is_featured');
        $data['is_active'] = $request->has('is_active');

        // Handle file upload
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($tool->gambar) {
                Storage::disk('public')->delete($tool->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('tools', 'public');
        }

        // Handle PDF file upload
        if ($request->hasFile('file_pdf')) {
            // Delete old PDF
            if ($tool->file_pdf) {
                Storage::disk('public')->delete($tool->file_pdf);
            }
            $data['file_pdf'] = $request->file('file_pdf')->store('tools/pdfs', 'public');
        }

        $tool->update($data);

        return redirect()->route('admin.tools.index')
            ->with('success', 'Tool berhasil diupdate.');
    }

    /**
     * Remove the specified tool
     */
    public function destroy(Tool $tool)
    {
        // Delete image if exists
        if ($tool->gambar) {
            Storage::disk('public')->delete($tool->gambar);
        }

        // Delete PDF if exists
        if ($tool->file_pdf) {
            Storage::disk('public')->delete($tool->file_pdf);
        }

        $tool->delete();

        return redirect()->route('admin.tools.index')
            ->with('success', 'Tool berhasil dihapus.');
    }
}
