<div x-data="{ open:false, date:'{{ $date ?? now()->toDateString() }}' }" class="relative">
  <input type="date" x-model="date" name="{{ $name ?? 'date' }}" class="border rounded px-3 py-2">
</div>
