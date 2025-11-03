@php($title='Availability')
<x-layouts.app :title="$title">

  {{-- Header + Logout --}}
  <div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-semibold">Availability</h1>

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

  <div class="grid md:grid-cols-2 gap-6">
    <!-- Set Working Hours -->
    <div class="bg-white border rounded p-4">
      <h2 class="font-semibold mb-2">Set Working Hours</h2>
      <form method="POST" action="{{ route('provider.availability.store') }}" class="space-y-2">
        @csrf
        <label class="block">Agent</label>
        <select name="agent_id" class="border rounded px-3 py-2 w-full" required>
          @foreach($agents as $a)
            <option value="{{ $a->id }}">{{ $a->name }}</option>
          @endforeach
        </select>

        <label class="block">Weekday</label>
        <select name="weekday" class="border rounded px-3 py-2 w-full">
          @foreach([0=>'Sun',1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat'] as $k=>$v)
            <option value="{{ $k }}">{{ $v }}</option>
          @endforeach
        </select>

        <div class="flex gap-2">
          <input type="time" name="start_time" class="border rounded px-3 py-2 w-full" required>
          <input type="time" name="end_time" class="border rounded px-3 py-2 w-full" required>
        </div>

        <button class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 transition">
          Save
        </button>
      </form>

      @if(session('ok'))
        <p class="mt-2 text-emerald-700">{{ session('ok') }}</p>
      @endif
    </div>

    <!-- Current Working Hours -->
    <div class="bg-white border rounded p-4">
      <h2 class="font-semibold mb-2">Current Working Hours</h2>

      <div class="space-y-1 text-sm">
        @forelse($working as $w)
          <div class="flex justify-between items-center border-b py-1">
            <div>
              <span class="font-medium text-gray-800">{{ $w->agent->name }}</span>
              <span class="text-gray-600"> — {{ ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][$w->weekday] }}</span>
            </div>

            <div class="flex items-center gap-3">
              <span class="text-gray-700">{{ $w->start_time }}–{{ $w->end_time }}</span>

              <!-- Delete button -->
              <form
                action="{{ route('provider.availability.destroy', $w->id) }}"
                method="POST"
                onsubmit="return confirm('Delete this working hour?');"
              >
                @csrf
                @method('DELETE')
                <button
                  type="submit"
                  class="inline-flex h-6 w-6 items-center justify-center rounded-full text-gray-400 hover:text-red-600 hover:bg-red-50"
                  title="Delete"
                >
                  &times;
                </button>
              </form>
            </div>
          </div>
        @empty
          <p class="text-gray-500">No working hours yet.</p>
        @endforelse
      </div>
    </div>
  </div>
</x-layouts.app>
