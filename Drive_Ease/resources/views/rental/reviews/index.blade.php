{{-- Rental Review Page --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review Pelanggan (Oleh Rental)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Debug: Show type and contents of $pendingBookings --}}
            <pre style="background:#fffbe6;color:#b45309;padding:8px;border-radius:6px;font-size:13px;">
Type: {{ gettype($pendingBookings) }}
@if(is_array($pendingBookings))
Count: {{ count($pendingBookings) }}
@endif
{{ print_r($pendingBookings, true) }}
</pre>
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Pemesanan Selesai - Belum Direview</h3>
                @if((is_array($pendingBookings) && count($pendingBookings) === 0) || (is_object($pendingBookings) && method_exists($pendingBookings, 'isEmpty') && $pendingBookings->isEmpty()) || empty($pendingBookings))
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg class="w-16 h-16 text-yellow-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16zm0 0v-2m0-4v-4m0 0V8m0 0h.01" />
                        </svg>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2">Belum ada pemesanan selesai yang bisa direview.</h4>
                        <p class="text-gray-500 text-center max-w-md">Booking yang sudah selesai (status <span class="font-semibold text-green-600">'selesai'</span>) akan muncul di sini untuk Anda review. Setelah pelanggan menyelesaikan pemesanan, Anda dapat memberikan review kepada mereka.</p>
                        <p class="mt-4 text-sm text-gray-400">Tips: Pantau status pemesanan secara berkala untuk memberikan review tepat waktu.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Sewa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pendingBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->user_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->vehicle_id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->start_date }} - {{ $booking->end_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button
                                                type="button"
                                                class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition"
                                                onclick="openReviewModal(
                                                    {{ $booking->id }},
                                                    '{{ addslashes($booking->user->name ?? '') }}',
                                                    '{{ addslashes($booking->user->email ?? '') }}',
                                                    '{{ addslashes($booking->vehicle->name ?? '') }}',
                                                    '{{ addslashes($booking->vehicle->category ?? '') }}',
                                                    '{{ $booking->start_date }}',
                                                    '{{ $booking->end_date }}'
                                                )"
                                            >
                                                Beri Review
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Already Reviewed --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Review yang Sudah Diberikan</h3>
                @if($reviews->isEmpty())
                    <div class="text-gray-500 text-center py-8">
                        <svg class="mx-auto mb-2 w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Belum ada review yang diberikan.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Sewa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reviews as $review)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->customer->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $review->customer->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $review->booking->vehicle->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $review->booking->vehicle->category ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($review->booking->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($review->booking->end_date)->format('d M Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endfor
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $review->comment }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('rental.reviews.edit', $review) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('rental.reviews.destroy', $review) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Hapus review ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Enhanced Review Modal --}}
<div id="review-modal" class="fixed z-50 inset-0 hidden overflow-y-auto">
    <!-- Backdrop with blur effect -->
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity duration-300 ease-out backdrop-blur-sm bg-black bg-opacity-50" 
             onclick="closeReviewModal()"></div>
        
        <!-- Modal container with smooth animations -->
        <div class="inline-block align-bottom bg-white rounded-2xl shadow-2xl transform transition-all duration-300 ease-out sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative overflow-hidden">
            <!-- Gradient header -->
            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 p-6 relative">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <button onclick="closeReviewModal()" 
                        class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors duration-200 p-2 rounded-full hover:bg-white hover:bg-opacity-20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <div class="relative">
                    <div class="flex items-center mb-2">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-white">Share Your Experience</h4>
                            <p class="text-white text-opacity-90 text-sm">Help others with your honest review</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking details card -->
            <div class="px-6 pt-6">
                <div id="modal-booking-details" class="bg-gray-50 rounded-xl p-4 mb-6 border-l-4 border-indigo-500">
                    <!-- Booking details will be inserted here -->
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <span>Booking details loading...</span>
                    </div>
                </div>
            </div>

            <!-- Form content -->
            <form id="review-form" action="/rental/reviews" method="POST" class="px-6 pb-6 space-y-6">
                @csrf
                <input type="hidden" name="booking_id" id="modal-booking-id" value="{{ old('booking_id') }}">
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="space-y-3">
                    <label class="block text-lg font-semibold text-gray-800">How was your experience?</label>
                    <div class="flex items-center justify-center space-x-2 py-4" id="star-rating-group">
                        @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}" class="hidden" {{ old('rating') == $i ? 'checked' : '' }} required>
                            <label for="rating{{ $i }}" class="cursor-pointer">
                                <svg class="w-10 h-10 {{ old('rating', 0) >= $i ? 'text-yellow-400' : 'text-gray-300' }} star-svg" data-value="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <div id="rating-text" class="text-center text-sm text-gray-500 min-h-5">
                        @if(old('rating'))
                            {{ [1=>"😞 Poor - Not satisfied",2=>"😐 Fair - Below expectations",3=>"🙂 Good - Met expectations",4=>"😊 Very Good - Exceeded expectations",5=>"🤩 Excellent - Outstanding experience!"][old('rating')] ?? 'Select a rating' }}
                        @else
                            Select a rating
                        @endif
                    </div>
                    @error('rating')
                        <p class="text-sm text-red-600 flex items-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-3">
                    <label for="comment" class="block text-lg font-semibold text-gray-800">
                        Tell us more about your experience
                    </label>
                    <div class="relative">
                        <textarea name="comment" id="comment" rows="4"
                                  placeholder="Share what you liked, any issues you encountered, or suggestions for improvement..."
                                  class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 resize-none p-4 text-gray-700 placeholder-gray-400">{{ old('comment') }}</textarea>
                        <div class="absolute bottom-3 right-3 text-xs text-gray-400" id="char-count">
                            {{ strlen(old('comment', '')) }} characters
                        </div>
                    </div>
                    @error('comment')
                        <p class="text-sm text-red-600 flex items-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                    <button type="button" onclick="closeReviewModal()"
                            class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200 rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Review
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Enhanced animations and effects */
#review-modal.show {
    display: flex !important;
}

#review-modal.show .inline-block {
    animation: modalSlideIn 0.3s ease-out forwards;
}

#review-modal.closing .inline-block {
    animation: modalSlideOut 0.3s ease-in forwards;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@keyframes modalSlideOut {
    from {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
    to {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
}

/* Star hover effects */
.star-rating label:hover ~ label svg {
    color: rgb(209 213 219) !important;
}

/* Smooth focus effects */
textarea:focus {
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}
</style>

<script>
const ratingTexts = {
    1: "😞 Poor - Not satisfied",
    2: "😐 Fair - Below expectations",
    3: "🙂 Good - Met expectations",
    4: "😊 Very Good - Exceeded expectations",
    5: "🤩 Excellent - Outstanding experience!"
};

function openReviewModal(id, customerName, customerEmail, vehicleName, vehicleCategory, startDate, endDate) {
    const modal = document.getElementById('review-modal');
    const bookingDetails = document.getElementById('modal-booking-details');
    const form = document.getElementById('review-form');
    const bookingIdInput = document.getElementById('modal-booking-id');
    bookingDetails.innerHTML = `
        <p><strong>Booking ID:</strong> ${id}</p>
        <p><strong>Pelanggan:</strong> ${customerName} (${customerEmail})</p>
        <p><strong>Kendaraan:</strong> ${vehicleName} (${vehicleCategory})</p>
        <p><strong>Tanggal Sewa:</strong> ${startDate} - ${endDate}</p>
    `;
    bookingIdInput.value = id;
    modal.classList.remove('hidden');
}

function closeReviewModal() {
    const modal = document.getElementById('review-modal');
    modal.classList.add('hidden');
}

function resetForm() {
    document.getElementById('review-form').reset();
    document.getElementById('rating-text').textContent = 'Select a rating';
    document.getElementById('char-count').textContent = '0 characters';
    
    // Reset star colors
    document.querySelectorAll('label svg').forEach(svg => {
        svg.classList.remove('text-yellow-400');
        svg.classList.add('text-gray-300');
    });
}

// Interactive star rating
const starGroup = document.getElementById('star-rating-group');
if (starGroup) {
    starGroup.querySelectorAll('label').forEach(label => {
        label.addEventListener('mouseenter', function() {
            const value = parseInt(this.htmlFor.replace('rating', ''));
            highlightStars(value);
        });
        label.addEventListener('mouseleave', function() {
            const checked = document.querySelector('input[name="rating"]:checked');
            highlightStars(checked ? parseInt(checked.value) : 0);
        });
        label.addEventListener('click', function() {
            const value = parseInt(this.htmlFor.replace('rating', ''));
            document.getElementById('rating' + value).checked = true;
            highlightStars(value);
            document.getElementById('rating-text').textContent = ratingTexts[value];
        });
    });
    // On load, highlight stars if old value exists
    const checked = document.querySelector('input[name="rating"]:checked');
    highlightStars(checked ? parseInt(checked.value) : 0);
}
function highlightStars(rating) {
    document.querySelectorAll('.star-svg').forEach((svg, idx) => {
        if (idx < rating) {
            svg.classList.add('text-yellow-400');
            svg.classList.remove('text-gray-300');
        } else {
            svg.classList.remove('text-yellow-400');
            svg.classList.add('text-gray-300');
        }
    });
}
// Character counter for textarea
const commentInput = document.getElementById('comment');
if (commentInput) {
    commentInput.addEventListener('input', function() {
        const charCount = document.getElementById('char-count');
        const length = this.value.length;
        charCount.textContent = `${length} character${length !== 1 ? 's' : ''}`;
        if (length > 500) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    });
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('review-modal');
    if (event.target === modal) {
        closeReviewModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('review-modal');
        if (modal.classList.contains('show')) {
            closeReviewModal();
        }
    }
});

// Form submission with loading state
document.getElementById('review-form').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Submitting...
    `;
});
</script>

@if ($errors->any() && old('booking_id'))
<script>
window.addEventListener('DOMContentLoaded', function() {
    openReviewModal(
        {{ old('booking_id') }},
        '', '', '', '', '', ''
    );
});
</script>
@endif
</x-app-layout> 