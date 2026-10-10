<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::latest()->get();
        return view('admin.contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.contents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['type', 'title', 'body']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        Content::create($data);

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil ditambahkan.');
    }

    public function edit(Content $content)
    {
        return view('admin.contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'body']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($content->image) \Storage::disk('public')->delete($content->image);
            $data['image'] = $request->file('image')->store('contents', 'public');
        }

        $content->update($data);

        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil diperbarui.');
    }

    public function destroy(Content $content)
    {
        if ($content->image) \Storage::disk('public')->delete($content->image);
        $content->delete();
        return redirect()->route('admin.contents.index')->with('success', 'Konten berhasil dihapus.');
    }
}
