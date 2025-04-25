<x-layouts.app>
    <x-layouts.header />

    <div class="flex flex-row">
        <!-- Main Content -->
        <div class="w-full overflow-x-hidden">

            <!-- Order List Section -->
            {{-- <livewire:order-list /> --}}

            <!-- Order Menu Section -->
            <livewire:order-menu />

        </div>

        <!-- Sidebar -->
        <livewire:cart />
    </div>
</x-layouts.app>
