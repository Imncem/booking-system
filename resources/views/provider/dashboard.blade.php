@php($title='Provider Dashboard')
<x-layouts.app :title="$title">

  {{-- Header + Logout --}}
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Provider Dashboard</h1>

    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button
        type="submit"
        class="px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
      >
        Logout
      </button>
    </form>
  </div>

  {{-- Date filter --}}
  <div class="mb-4">
    <form method="GET" action="{{ route('provider.dashboard') }}" class="flex items-end gap-2">
      <div>
        <label class="block text-sm">Date</label>
        <input type="date" name="date" value="{{ $date }}" class="border rounded px-3 py-2">
      </div>
      <button class="px-4 py-2 bg-blue-600 text-white rounded">Go</button>
    </form>
  </div>

  {{-- Bookings list --}}
  <div class="bg-white border rounded p-4">
    <h2 class="font-semibold mb-2">
      Bookings on {{ \Carbon\Carbon::parse($date)->format('j M Y') }}
    </h2>

    <div class="divide-y">
      @forelse($bookings as $b)
        <div class="py-2 flex items-center justify-between">
          <div>
            <div class="font-medium">
              {{ $b->starts_at->format('g:i A') }} - {{ $b->ends_at->format('g:i A') }}
            </div>
            <div class="text-sm text-gray-600">
              {{ $b->service->name }} &middot; {{ $b->customer_name }}
            </div>
          </div>
          <span class="text-xs px-2 py-1 rounded bg-gray-100">{{ $b->status }}</span>
        </div>
      @empty
        <p class="text-gray-500">No bookings.</p>
      @endforelse
    </div>
  </div>

</x-layouts.app>
