@extends('layout.master')

@section('content')
    <div>

        <form class="flex flex-col gap-5 mx-20 my-24" method="POST"
            action="{{ route('review.store', ['id' => $produk->id]) }}" enctype="multipart/form-data">

            @csrf

            <!-- Produk -->
            <div class="flex gap-4 items-center">
                <img class="w-[80px] h-[80px] rounded-lg" src="{{ $produk->gambarProduks->first()->gambar }}" alt="">

                <input type="hidden" name="id_produk" value="{{ $produk->id }}">

                <div>
                    <h1 class="font-medium">{{ $produk->nama }}</h1>
                    <p>{{ number_format($produk->harga) }}</p>
                </div>
            </div>

            <!-- Rating -->
            <div class="flex gap-2 items-center">
                <img src="{{ asset('img/star.png') }}" class="w-[20px] h-[20px]" alt="">
                <input type="text" name="rating" class="w-[100px] h-[30px] border border-gray-400 rounded-lg p-2"
                    placeholder="5" required>
            </div>

            <!-- Review -->
            <div class="flex flex-col gap-2">
                <h1 class="text-xl font-medium">Review</h1>
                <textarea name="review" class="w-full h-[100px] border border-gray-400 rounded-lg p-2" placeholder="Your review"
                    required></textarea>
            </div>

            <!-- Upload Image -->
            <div>
                <h1 class="text-xl font-semibold mb-4">Image</h1>

                <div class="flex items-center gap-4">

                    <label id="drop-zone"
                        class="w-48 h-48 p-5 flex flex-col items-center justify-center
                           border-2 border-dashed border-gray-500 rounded-lg
                           text-center text-gray-500 transition duration-300
                           hover:border-blue-500 hover:text-blue-500">

                        <p class="text-lg font-semibold">Drop files here</p>

                        <input type="file" id="file-input" name="gambar[]" class="hidden" multiple />

                        <p class="text-sm mt-2">or click to upload</p>
                    </label>

                    <div id="preview" class="flex flex-wrap justify-center gap-4"></div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit"
                    class="rounded py-1 px-4 text-sm bg-[#B5733A] text-white
                           hover:bg-[#9a5e2e] transition-all">
                    Post
                </button>
            </div>

        </form>

        <!-- Script -->
        <script>
            const dropZone = document.getElementById("drop-zone");
            const fileInput = document.getElementById("file-input");
            const previewContainer = document.getElementById("preview");

            let allFiles = [];

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, e => e.preventDefault());
            });

            dropZone.addEventListener("dragover", () => {
                dropZone.classList.add("bg-gray-200");
            });

            dropZone.addEventListener("dragleave", () => {
                dropZone.classList.remove("bg-gray-200");
            });

            dropZone.addEventListener("drop", (e) => {
                dropZone.classList.remove("bg-gray-200");
                const files = Array.from(e.dataTransfer.files);
                if (files.length) addFiles(files);
            });

            fileInput.addEventListener("change", () => {
                addFiles(Array.from(fileInput.files));
            });

            function addFiles(files) {
                files.forEach(file => {
                    if (!file.type.startsWith("image/")) return;

                    if (!allFiles.some(f => f.name === file.name && f.size === file.size)) {
                        allFiles.push(file);

                        const reader = new FileReader();
                        reader.onload = e => {
                            const img = document.createElement("img");
                            img.src = e.target.result;
                            img.className = "w-48 h-48 object-cover rounded shadow";
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

    </div>
@endsection
