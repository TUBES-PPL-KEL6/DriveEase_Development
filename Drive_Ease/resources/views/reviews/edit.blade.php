<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Edit Ulasan Anda</h2>
            {{-- Tambahkan link kembali jika relevan, contoh:
            <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:text-blue-600 hover:underline flex items-center">
                <svg class="w-4 h-4 mr-1 rtl:ml-1 rtl:mr-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            --}}
        </div>
    </x-slot>

    <div class="py-10 px-4 md:px-8">
        <div class="max-w-xl mx-auto">
            <form action="{{ route('reviews.update', $review->id) }}" method="POST"
                  class="bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">Rating Anda</label>
                    <select name="rating" id="rating" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" 
                            required>
                        <option value="" disabled>Pilih Rating</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                {{ $i }} ⭐
                            </option>
                        @endfor
                    </select>
                    @error('rating') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Komentar Anda</label>
                    <textarea name="comment" id="comment" rows="5" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm" 
                              placeholder="Bagikan pengalaman Anda mengenai kendaraan atau layanan..."
                              required>{{ old('comment', $review->comment) }}</textarea>
                    @error('comment') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" 
                            class="w-full inline-flex justify-center py-2.5 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Simpan Perubahan Ulasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>