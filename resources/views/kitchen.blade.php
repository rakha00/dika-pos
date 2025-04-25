<x-layouts.app>
    <x-layouts.header />
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="mb-6 text-2xl font-bold text-gray-800">Kitchen Orders</h1>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @for ($i = 1; $i <= 10; $i++)
                    <div class="overflow-hidden rounded-lg bg-white shadow-md">
                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                            <h2 class="font-semibold text-gray-800">Order #{{ 1000 + $i }}</h2>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600">Customer: <span
                                        class="font-medium text-gray-800">Customer {{ $i }}</span></p>
                                <p class="text-sm text-gray-600">Time: <span
                                        class="font-medium text-gray-800">{{ now()->subMinutes(rand(5, 60))->format('H:i') }}</span>
                                </p>
                            </div>

                            <div class="mb-4">
                                <h3 class="mb-2 font-medium text-gray-800">Items:</h3>
                                <ul class="ml-4 list-disc text-sm text-gray-600">
                                    <li>Item 1 x {{ rand(1, 3) }}</li>
                                    <li>Item 2 x {{ rand(1, 3) }}</li>
                                    @if (rand(0, 1))
                                        <li>Item 3 x {{ rand(1, 2) }}</li>
                                    @endif
                                </ul>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    class="rounded-md bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700">
                                    Mark as Ready
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-layouts.app>
