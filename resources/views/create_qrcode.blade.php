<x-app-layout>
    <div class="flex items-start justify-center min-h-screen bg-gray-50">
        <div class="max-w-md w-full p-4 bg-gray rounded-lg shadow-xl mt-12">
            <!-- Form -->
            <form method="POST" action="{{ route('store-qrcode') }}">
                @csrf
                <div class="mb-4">
                    <label for="document_url" class="block text-md font-semibold text-black">URL Dokumen</label>
                    <input type="url" id="document_url" name="document_url" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('document_url', $document_url ?? '') }}" required>
                    @error('document_url')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Buat QR Code -->
                <button type="submit" class="mt-4 inline-block w-full bg-red-600 text-white font-bold text-md py-2 px-4 rounded-md hover:from-white focus:outline-none transition-all duration-300">
                    Buat QR Code
                </button>
            </form>

            <!-- QR Code Display -->
            @if(session('qr_code_filename'))
                <div class="mt-6 text-center">
                    <h2 class="text-lg font-semibold text-black">QR Code Dokumen:</h2>
                    <img src="{{ asset('storage/' . session('qr_code_filename')) }}" alt="QR Code" class="mt-4 mx-auto">
                    <p class="mt-2 text-sm text-black">URL Dokumen: {{ session('document_url') }}</p>
                </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
                <div class="mt-4 text-center text-black">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
