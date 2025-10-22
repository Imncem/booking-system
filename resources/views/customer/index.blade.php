@php($title='Book a Slot')
<x-layouts.app :title="$title">
  <h1 class="text-2xl font-semibold mb-4">Book a Slot</h1>
  @include('components.slot-grid', ['services'=>$services, 'agents'=>$agents, 'date'=>$date])
</x-layouts.app>
