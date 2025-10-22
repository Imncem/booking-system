<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Appointments' }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tailwind via CDN for quick start -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800">
  <nav class="bg-white shadow sticky top-0 z-10">
    <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
      <a href="/" class="font-semibold">Appointments</a>
      <div class="space-x-4 text-sm">
        <a href="{{ route('provider.dashboard') }}" class="hover:underline">Provider</a>
        <a href="{{ route('provider.availability') }}" class="hover:underline">Availability</a>
        <a href="{{ route('customer.index') }}" class="hover:underline">Customer</a>
      </div>
    </div>
  </nav>
  <main class="max-w-6xl mx-auto p-4">
    {{ $slot }}
  </main>
</body>
</html>
