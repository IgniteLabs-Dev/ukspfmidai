<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Tymon\JWTAuth\Facades\JWTAuth;

class BeritaController extends Controller
{
    public function createBerita()
    {
        return view('pages.create-berita');
    }


    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'is_published' => 'required|in:0,1',
            'cover' => 'required|image|mimes:jpg,jpeg,png|max:10240', // 10MB
            'content' => 'required|string',
        ], [
            'title.required' => 'Judul wajib diisi',
            'title.max' => 'Judul maksimal 255 karakter',
            'is_published.required' => 'Status berita wajib dipilih',
            'cover.required' => 'Cover wajib diunggah',
            'cover.image' => 'File harus berupa gambar',
            'cover.mimes' => 'Format yang diterima: JPG, JPEG, PNG',
            'cover.max' => 'Ukuran file maksimal 10 MB',
            'content.required' => 'Isi berita wajib diisi',
        ]);

        // Upload cover
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('files/news/', $filename, 'real_public');
            $validated['cover'] = $filename;
        }

        $user = JWTAuth::parseToken()->authenticate();
        // Simpan ke database
        News::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'cover' => $validated['cover'],
            'is_published' => (bool) $validated['is_published'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('manajemen-berita')
            ->with('success', 'Berita berhasil dibuat');
    }

    public function editBerita($id)
    {
        $berita = News::findOrFail($id);

        return view('pages.edit-berita', compact('berita'));
    }

    public function updateBerita(Request $request, $id)
    {
        $berita = News::findOrFail($id);

        $data = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'is_published' => 'required|in:0,1',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        if ($request->hasFile('cover')) {
            // 🔥 HAPUS FILE LAMA
            $oldPath = public_path('files/news/' . $berita->cover);
            if ($berita->cover && File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // 🔥 SIMPAN FILE BARU (format sama kayak store)
            $file = $request->file('cover');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('files/news'), $filename);

            $data['cover'] = $filename;
        }

        $berita->update($data);

        return redirect()->route('manajemen-berita')
            ->with('success', 'Berita berhasil diupdate');
    }


}
