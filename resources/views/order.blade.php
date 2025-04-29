<x-layouts.app>
    <x-layouts.header />

    <div class="flex flex-row-reverse">
        <!-- Sidebar -->
        <livewire:cart />

        <!-- Main Content -->
        <div class="overflow-x-hidden w-full">

            <!-- Order Menu Section -->
            <livewire:order-menu />

        </div>
    </div>
</x-layouts.app>
