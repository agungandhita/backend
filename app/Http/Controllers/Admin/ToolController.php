<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    /**
     * Display a listing of tools
     */
    public function index()
    {
        $tools = Tool::latest()->paginate(10);
        return view('admin.tools.index', compact('tools'));
    }

    /**
     * Show the form for creating a new tool
     */
    public function create()
    {
        return view('admin.tools.create');
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->all();

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
        return view('admin.tools.edit', compact('tool'));
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'url_video' => 'nullable|url',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->all();

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
