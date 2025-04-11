<x-layouts.app>
    <x-layouts.header />

    <div class="flex flex-row-reverse">
        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main Content -->
        <div class="overflow-x-hidden">

            <!-- Order List Section -->
            <x-dashboard.order-list />

            <!-- Order Menu Section -->
            <livewire:order-menu />

        </div>
    </div>
</x-layouts.app>
