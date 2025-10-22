@php($title='Availability')
<x-layouts.app :title="$title">
  <h1 class="text-2xl font-semibold mb-4">Availability</h1>

  <div class="grid md:grid-cols-2 gap-6">
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
        <button class="px-4 py-2 bg-emerald-600 text-white rounded">Save</button>
      </form>

      @if(session('ok'))
        <p class="mt-2 text-emerald-700">{{ session('ok') }}</p>
      @endif
    </div>

    <div class="bg-white border rounded p-4">
      <h2 class="font-semibold mb-2">Current Working Hours</h2>
      <div class="space-y-1 text-sm">
        @foreach($working as $w)
          <div class="flex justify-between border-b py-1">
            <span>{{ $w->agent->name }} — {{ ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'][$w->weekday] }}</span>
            <span>{{ $w->start_time }}–{{ $w->end_time }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</x-layouts.app>
