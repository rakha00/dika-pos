<x-layouts.app>
    <x-layouts.header />

    <main class="py-6 space-y-6">
        @if (auth()->user()->role === 'admin')
            {{-- Admin melihat statistik --}}
            <livewire:stats />
        @endif

        @if (in_array(auth()->user()->role, ['admin', 'chef']))
            {{-- Admin dan Chef melihat daftar pesanan --}}
            <livewire:order-list />
        @endif
    </main>

</x-layouts.app>
