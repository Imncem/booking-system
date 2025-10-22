@php($title='Booking Confirmation')
<x-layouts.app :title="$title">
  <h1 class="text-2xl font-semibold mb-4">Booking Created</h1>
  <div class="bg-white border rounded p-4 max-w-lg">
    <p class="mb-2">Thank you, <strong>{{ $booking->customer_name }}</strong>.</p>
    <p class="mb-2">Your booking for <strong>{{ $booking->service->name }}</strong> with <strong>{{ $booking->agent->name }}</strong> is tentatively created.</p>
    <p class="mb-2">Date/Time: <strong>{{ $booking->starts_at->format('j M Y g:i A') }}</strong> - {{ $booking->ends_at->format('g:i A') }}</p>
    <p class="mb-4">Status: <span class="px-2 py-1 text-xs rounded bg-yellow-100">{{ $booking->status }}</span></p>
    <p class="text-sm text-gray-600">Next step: integrate Bizappay checkout and update status to <em>confirmed</em> on payment success.</p>
  </div>
</x-layouts.app>
