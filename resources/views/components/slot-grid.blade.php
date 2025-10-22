<div x-data="slotGrid()" x-init="init()" class="space-y-3">
  <div class="flex gap-2 items-end">
    <div>
      <label class="block text-sm">Service</label>
      <select x-model="service_id" class="border rounded px-3 py-2">
        <option value="">-- choose --</option>
        @foreach($services as $s)
          <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->duration_min }}m)</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm">Agent</label>
      <select x-model="agent_id" class="border rounded px-3 py-2">
        <option value="">-- choose --</option>
        @foreach($agents as $a)
          <option value="{{ $a->id }}">{{ $a->name }}</option>
        @endforeach
      </select>
    </div>
    <div>
      <label class="block text-sm">Date</label>
      <input type="date" x-model="date" class="border rounded px-3 py-2">
    </div>
    <button @click="load()" class="px-4 py-2 bg-blue-600 text-white rounded">Load Slots</button>
  </div>

  <template x-if="loading">
    <p>Loading...</p>
  </template>

  <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2" x-show="slots.length">
    <template x-for="s in slots" :key="s.start">
      <form method="POST" action="{{ route('customer.book') }}"
            class="border rounded p-2 flex flex-col gap-2 bg-white">
        @csrf
        <input type="hidden" name="service_id" :value="service_id">
        <input type="hidden" name="agent_id" :value="agent_id">
        <input type="hidden" name="starts_at" :value="s.start">
        <div class="font-semibold" x-text="s.label"></div>
        <input name="customer_name" required placeholder="Your name" class="border rounded px-2 py-1 text-sm">
        <input name="customer_email" placeholder="Email (optional)" class="border rounded px-2 py-1 text-sm">
        <input name="customer_phone" placeholder="Phone (optional)" class="border rounded px-2 py-1 text-sm">
        <button class="px-3 py-1.5 bg-emerald-600 text-white rounded text-sm">Book</button>
      </form>
    </template>
  </div>

  <template x-if="!loading && loaded && slots.length===0">
    <p class="text-gray-500">No slots found for the selected date/service/agent.</p>
  </template>
</div>

<script>
function slotGrid(){
  return {
    service_id: '', agent_id: '', date: '{{ $date ?? now()->toDateString() }}',
    slots: [], loading: false, loaded:false,
    init(){ /* auto load if default set */ },
    async load(){
      this.loading = true; this.loaded = true; this.slots = [];
      if(!this.service_id || !this.agent_id || !this.date){ this.loading=false; return; }
      const params = new URLSearchParams({ service_id:this.service_id, agent_id:this.agent_id, date:this.date });
      const res = await fetch('{{ route('provider.slots') }}' + '?' + params.toString());
      const data = await res.json();
      this.slots = data.slots || [];
      this.loading = false;
    }
  }
}
</script>
