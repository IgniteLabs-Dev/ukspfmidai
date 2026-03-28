<?php

namespace App\Livewire;

use App\Models\Tahun;
use App\Services\CrudService;
use Livewire\Component;
use Livewire\WithPagination;

class ManajemenBerita extends Component
{
    use WithPagination;
    public $mode = 'view';
    public $editId = null;
    public $deleteId = null;
    public $filter = null;
    public $tahun, $status;

    protected $rules = [

        'tahun' => 'required|integer',
        'status' => 'required|string',

    ];

    public function render()
    {
        $data = Tahun::when(!empty($this->filter), function ($query) {
            $query->where(function ($subquery) {
                $subquery->where('tahun', 'like', '%' . $this->filter . '%');
            });
        })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $scripts = $this->testscript();


        return view('livewire.manajemen-berita', compact('data','scripts'))->extends('layouts.master');
    }
    public function toggleMode()
    {
        $this->mode = $this->mode === 'view' ? 'edit' : 'view';
    }
    public function resetInput()
    {
        $this->mode = 'view';
        $this->editId = null;
        $this->resetValidation();
        $this->reset(['tahun', 'status']);
    }
    public function create(CrudService $crud)
    {
        $this->validate();

        $data = [
            'tahun' => $this->tahun,
            'status' => $this->status,
        ];

        $crud->create(Tahun::class, $data, 'Tahun berhasil dibuat!', 'Gagal membuat Tahun.');
        $this->resetInput();
    }
    public function edit($id, CrudService $crud)
    {
        $data = $crud->find(Tahun::class, $id);

        if ($data) {
            $this->tahun = $data->tahun;
            $this->status = $data->status;
            $this->mode = 'edit';
            $this->editId = $id;
        }
    }
    public function update(CrudService $crud)
    {

        $this->validate();
        $data = [
            'tahun' => $this->tahun,
            'status' => $this->status,
        ];

        $crud->update(Tahun::class, $this->editId, $data, 'Tahun berhasil diperbarui!', 'Gagal memperbarui Tahun.');
        $this->resetInput();
    }

    public function delete($id, CrudService $crud)
    {
        $crud->delete(Tahun::class, $id, 'Tahun berhasil dihapus!', 'Gagal menghapus Tahun.');
        $this->resetInput();
    }
    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function testscript()
    {
        $script = <<<HTML
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<script>
    let quill;

    function initQuill() {
        const el = document.getElementById('editor');
        if (!el) return;

        el.innerHTML = '';

        quill = new Quill(el, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['link', 'image']
                ]
            }
        });

        if (window.quillContent) {
            quill.root.innerHTML = window.quillContent;
        }

        quill.on('text-change', () => {
            let html = quill.root.innerHTML;

            window.quillContent = html;

            Livewire.dispatch('setContent', { value: html });
        });
    }

    document.addEventListener('DOMContentLoaded', initQuill);

    document.addEventListener('livewire:commit', () => {
        setTimeout(() => {
            initQuill();
        }, 50);
    });
</script>
@endpush
HTML;

        return $script;
    }
}
