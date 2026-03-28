@extends('layouts.master')

@section('title', 'Tambah Berita')
@section('content')
    <div class="bg-white rounded-xl p-4 mb-8 md:mt-0 mt-15">
        <div class="w-full">
            <h2 class="text-3xl font-bold text-center mb-6">Tambah Berita</h2>

            <form action="{{ route('manajemen-berita-store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="w-full mt-4">
                    <div class="flex flex-col gap-4">

                        <!-- Judul & Status -->
                        <div class="w-full flex md:flex-row flex-col gap-2">
                            <div class="md:w-[85%] w-full">
                                <x-input
                                    label="Judul"
                                    name="title"
                                    id="title"
                                    type="text"
                                    placeholder="Masukkan Judul"
                                    :required="true"
                                    value="{{ old('title') }}"
                                />
                            </div>
                            <div class="md:w-[15%] w-full">
                                <x-select
                                    label="Status Berita"
                                    name="is_published"
                                    id="is_published"
                                    placeholder="Pilih Status"
                                    :options="['1' => 'Aktif','0' => 'Tidak Aktif']"
                                    :required="true"
                                    value="{{ old('is_published') }}"
                                />
                            </div>
                        </div>

                        <!-- Cover Image -->
                        <div class="">
                            <label for="cover" class="block mb-1 text-sm font-medium text-gray-900">
                                Cover
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="file"
                                id="cover"
                                name="cover"
                                accept=".jpg,.png,.jpeg"
                                class="bg-gray-50 w-full rounded-md file:bg-gray-400 file:text-white border-1 border-gray-200 cursor-pointer @error('cover') border-red-500 @enderror"
                            />
                            <p class="mt-1 text-xs text-gray-500">
                                Format yang diterima: <span class="font-medium">JPG, JPEG, PNG</span> &bull; Maksimal <span class="font-medium">10 MB</span>
                            </p>
                            @error('cover')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                            <img
                                id="blah"
                                src="#"
                                alt="preview"
                                class="mt-3 h-64 w-auto rounded-md object-cover  hidden"
                            />
                        </div>

                        <!-- Editor Content -->
                        <div class="rounded-md">
                            <label for="editor" class="block mb-1 text-sm font-medium text-gray-900">
                                Isi Berita
                                <span class="text-red-500">*</span>
                            </label>
                            <div
                                id="editor"
                                style="height: 300px; background-color: white; border: 1px solid #d1d5db;"
                            ></div>
                            <input
                                type="hidden"
                                name="content"
                                id="content"
                                value="{{ old('content') }}"
                            />
                            @error('content')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="col-span-2 flex justify-center items-end gap-2">
                            <a href="{{ route('manajemen-berita') }}" class="w-auto">
                                <button
                                    type="button"
                                    style="background-color: var(--danger);"
                                    class="cursor-pointer px-6 py-2 text-white rounded-lg hover:opacity-90 transition"
                                >
                                    Batal
                                </button>
                            </a>
                            <button
                                type="submit"
                                style="background-color: var(--success);"
                                class="cursor-pointer px-6 py-2 text-white rounded-lg hover:opacity-90 transition"
                            >
                                Buat Berita
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
        @push('scripts')

            <script>
                const cover = document.getElementById('cover');
                const blah = document.getElementById('blah');

                cover.onchange = evt => {
                    const [file] = cover.files;
                    if (file) {
                        blah.src = URL.createObjectURL(file);
                        blah.classList.remove('hidden');
                    }
                }
            </script>

            <!-- Quill Editor CSS -->
            <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

            <!-- Quill Editor JS -->
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Initialize Quill Editor
                    const quill = new Quill('#editor', {
                        theme: 'snow',
                        placeholder: 'Tulis isi berita di sini...',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'header': 1 }, { 'header': 2 }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'script': 'sub'}, { 'script': 'super' }],
                                [{ 'indent': '-1'}, { 'indent': '+1' }],
                                [{ 'size': ['small', false, 'large', 'huge'] }],
                                [{ 'header': [false, 1, 2, 3, 4, 5, 6] }],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'align': [] }],
                                ['link', 'image'],
                                ['clean']
                            ]
                        }
                    });

                    // Set initial content
                    const contentInput = document.getElementById('content');
                    if (contentInput.value) {
                        quill.root.innerHTML = contentInput.value;
                    }

                    // Update hidden input when editor changes
                    quill.on('text-change', function() {
                        contentInput.value = quill.root.innerHTML;
                    });

                    // Image preview
                    const imgInput = document.getElementById('cover');
                    const imgPreview = document.getElementById('blah');

                    imgInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Validate file size
                            const maxSize = 10 * 1024 * 1024; // 10MB
                            if (file.size > maxSize) {
                                alert('Ukuran file terlalu besar. Maksimal 10 MB');
                                this.value = '';
                                imgPreview.classList.add('hidden');
                                return;
                            }

                            // Validate file type
                            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                            if (!allowedTypes.includes(file.type)) {
                                alert('Format file tidak didukung. Gunakan JPG, JPEG, atau PNG');
                                this.value = '';
                                imgPreview.classList.add('hidden');
                                return;
                            }

                            // Show preview
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                imgPreview.src = event.target.result;
                                imgPreview.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // Form submission validation
                    document.querySelector('form').addEventListener('submit', function(e) {
                        const html = quill.root.innerHTML.trim();
                        const text = quill.getText().trim();

                        if (text.length === 0) {
                            e.preventDefault();

                            contentInput.value = '';

                            return false;
                        }

                        contentInput.value = html;
                    });
                });
            </script>
        @endpush

</div>

@endsection
