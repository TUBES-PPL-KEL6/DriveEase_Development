<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reported Reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($reportedReviews->isEmpty())
                        <p class="text-center text-gray-500">No reported reviews to moderate.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Reason</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reportedReviews as $review)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->vehicle->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->rating }}/5</td>
                                            <td class="px-6 py-4">{{ Str::limit($review->comment, 100) }}</td>
                                            <td class="px-6 py-4">{{ $review->report_reason }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.reviews.remove', $review) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this review?')">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $reportedReviews->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 