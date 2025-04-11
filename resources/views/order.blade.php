<x-layouts.app>
    <x-layouts.header />

    <div class="flex flex-row-reverse">
        <!-- Sidebar -->
        <livewire:cart />

        <!-- Main Content -->
        <div class="w-full overflow-x-hidden">

            <!-- Order List Section -->
            <livewire:order-list />

            <!-- Order Menu Section -->
            <livewire:order-menu />

        </div>
    </div>
</x-layouts.app>
