<?php

namespace App\Livewire;

use App\Models\News;
use App\Models\Tahun;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class ManajemenBerita extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $title,$content, $cover, $is_published ;

    protected $rules = [
        'title' => 'required|string',
        'content' => 'required',
        'cover' => 'required|image|max:2048',
        'is_published' => 'required|boolean',
    ];

    public function render()
    {
        $data = News::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('title', 'like', '%' . $this->filter . '%')
                    ->orWhere('content', 'like', '%' . $this->filter . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(10);




        return view('livewire.manajemen-berita', compact('data',))->extends('layouts.master');
    }
    public function toggleMode()
    {
        $this->mode = $this->mode === 'view' ? 'edit' : 'view';
    }

    public function delete($id, CrudService $crud)
    {
        $berita = News::findOrFail($id);

        // 🔥 hapus file cover
        $filePath = public_path('files/news/' . $berita->cover);
        if ($berita->cover && File::exists($filePath)) {
            File::delete($filePath);
        }

        // 🔥 hapus data dari database
        $crud->delete(News::class, $id, 'Berita berhasil dihapus!', 'Gagal menghapus Berita.');

    }
    public function updatedFilter()
    {
        $this->resetPage();
    }


}
