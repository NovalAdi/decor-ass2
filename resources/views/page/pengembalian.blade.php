@extends('layout.master')

@section('content')
<div class="max-w-3xl mx-auto my-20 p-8 bg-white rounded-xl shadow">

    <h1 class="text-3xl font-semibold mb-8 text-gray-800">Pengajuan Pengembalian</h1>

    <form method="POST" action="{{ route('pengembalian.store') }}" enctype="multipart/form-data" class="space-y-7">
        @csrf

        <input type="hidden" name="pesanan_id" value="{{ $id }}">

        {{-- Tipe --}}
        <div class="space-y-2">
            <label class="font-medium text-gray-700">Tipe</label>
            <select name="tipe" class="border border-gray-400 rounded-lg p-2 w-full focus:ring focus:ring-blue-300">
                <option value="rusak">Rusak</option>
                <option value="tidak_sesuai">Tidak Sesuai</option>
            </select>
        </div>

        {{-- Judul --}}
        <div class="space-y-2">
            <label class="font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" placeholder="Judul Pengembalian"
                class="border border-gray-400 rounded-lg p-2 w-full focus:ring focus:ring-blue-300" required>
        </div>

        {{-- Deskripsi --}}
        <div class="space-y-2">
            <label class="font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" placeholder="Jelaskan masalahnya..."
                class="border border-gray-400 rounded-lg p-3 w-full h-32 focus:ring focus:ring-blue-300"
                required></textarea>
        </div>

        {{-- Upload Image --}}
        <div class="space-y-3">
            <h2 class="text-xl font-semibold text-gray-800">Upload Gambar</h2>

            <div class="flex items-start gap-6">

                <!-- Dropzone -->
                <label id="drop-zone"
                    class="w-48 h-48 flex flex-col items-center justify-center border-2 border-dashed border-gray-400
                           rounded-lg text-gray-500 hover:border-blue-500 hover:text-blue-500 transition cursor-pointer">

                    <p class="font-medium">Drop files here</p>

                    <input type="file" id="file-input" name="gambar[]" class="hidden" multiple>

                    <p class="text-xs mt-1">or click to upload</p>
                </label>

                <!-- Preview -->
                <div id="preview" class="flex flex-wrap gap-4"></div>

            </div>
        </div>

        {{-- Submit --}}
        <div class="flex justify-end">
            <button type="submit"
                class="px-5 py-2 bg-[#B5733A] text-white rounded-lg font-medium shadow
                       hover:bg-[#9a5e2e] transition">
                Kirim Pengajuan
            </button>
        </div>

    </form>

</div>

{{-- Script --}}
<script>
    const dropZone = document.getElementById("drop-zone");
    const fileInput = document.getElementById("file-input");
    const previewContainer = document.getElementById("preview");

    let allFiles = [];

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, e => e.preventDefault());
    });

    dropZone.addEventListener("dragover", () => dropZone.classList.add("bg-gray-100"));
    dropZone.addEventListener("dragleave", () => dropZone.classList.remove("bg-gray-100"));

    dropZone.addEventListener("drop", e => {
        dropZone.classList.remove("bg-gray-100");
        addFiles(Array.from(e.dataTransfer.files));
    });

    fileInput.addEventListener("change", () => addFiles(Array.from(fileInput.files)));

    function addFiles(files) {
        files.forEach(file => {
            if (!file.type.startsWith("image/")) return;

            if (!allFiles.some(f => f.name === file.name && f.size === file.size)) {
                allFiles.push(file);

                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.className = "w-28 h-28 object-cover rounded shadow";
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        const dataTransfer = new DataTransfer();
        allFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
</script>

@endsection
