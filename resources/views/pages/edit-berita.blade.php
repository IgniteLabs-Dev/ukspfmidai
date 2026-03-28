@extends('layouts.master')

@section('title', 'Tambah Berita')
@section('content')
    <div class="bg-white rounded-xl p-4 mb-8 md:mt-0 mt-15">
        <div class="w-full">
            <h2 class="text-3xl font-bold text-center mb-6">Perbarui Berita</h2>

            <form action="{{ route('manajemen-berita-update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="w-full mt-4">
                    <div class="flex flex-col gap-4">

                        <!-- Judul & Status -->
                        <div class="w-full flex md:flex-row flex-col gap-2">
                            <div class="w-[85%] w-full">
                                <x-input
                                    label="Judul"
                                    name="title"
                                    id="title"
                                    type="text"
                                    placeholder="Masukkan Judul"
                                    :required="true"
                                    value="{{ old('title', $berita->title) }}"
                                />
                            </div>
                            <div class="w-[15%] w-full">
                                <div>
                                    <label for="is_published" class="block mb-2 text-sm font-medium text-gray-900">
                                        Status Berita
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <select
                                        id="is_published"
                                        name="is_published"
                                        class="bg-gray-50 pe-8 cursor-pointer border border-gray-200 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('is_published') border-red-500 @enderror"
                                        required
                                    >
                                        <option value="">Pilih salah satu...</option>

                                        <option value="1"
                                            {{ old('is_published', $berita->is_published) == 1 ? 'selected' : '' }}>
                                            Aktif
                                        </option>

                                        <option value="0"
                                            {{ old('is_published', $berita->is_published) == 0 ? 'selected' : '' }}>
                                            Tidak Aktif
                                        </option>
                                    </select>

                                    @error('is_published')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
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
                            <div class="flex gap-2">
                                <img
                                    id="blah"
                                    src="#"
                                    alt="preview"
                                    class="mt-3 h-64 w-auto rounded-md object-cover  hidden"
                                />

                                @if($berita->cover && file_exists(public_path('files/news/' . $berita->cover)))
                                    <img
                                        id="oldImage"
                                        src="{{ asset('files/news/' . $berita->cover) }}"
                                        class="mt-3 h-64 rounded-md"
                                    >
                                @endif
                            </div>
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
                                value="{{ old('content', $berita->content) }}"
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
                                Perbarui Berita
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
                const oldImage = document.getElementById('oldImage');

                cover.onchange = evt => {
                    const [file] = cover.files;

                    if (file) {
                        // tampilkan preview baru
                        blah.src = URL.createObjectURL(file);
                        blah.classList.remove('hidden');

                        // sembunyikan gambar lama
                        if (oldImage) {
                            oldImage.classList.add('hidden');
                        }
                    }
                };
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
