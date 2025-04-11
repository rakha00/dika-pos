<x-layouts.app>
    <x-layouts.header />

    <div class="flex flex-row-reverse">
        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main Content -->
        <div class="overflow-x-hidden">

            <!-- Order List Section -->
            <h2 class="m-6 text-2xl font-bold text-gray-800">Order List</h2>
            <x-dashboard.order_list />

            <!-- Food Category Navigation -->
            <div class="m-6 rounded-lg bg-white shadow">
                <div class="flex justify-between overflow-x-auto px-4 py-3">
                    <a href="#appetizer"
                        class="mx-1 whitespace-nowrap rounded-md px-4 py-2 text-center text-gray-700 transition-colors hover:bg-blue-500 hover:text-white">
                        Appetizer
                    </a>
                    <a href="#main-course"
                        class="mx-1 whitespace-nowrap rounded-md px-4 py-2 text-center text-gray-700 transition-colors hover:bg-blue-500 hover:text-white">
                        Main Course
                    </a>
                    <a href="#dessert"
                        class="mx-1 whitespace-nowrap rounded-md px-4 py-2 text-center text-gray-700 transition-colors hover:bg-blue-500 hover:text-white">
                        Dessert
                    </a>
                    <a href="#beverage"
                        class="mx-1 whitespace-nowrap rounded-md px-4 py-2 text-center text-gray-700 transition-colors hover:bg-blue-500 hover:text-white">
                        Beverage
                    </a>
                </div>
            </div>

            <!-- Menu Section -->
            <h2 class="m-6 text-2xl font-bold text-gray-800">Menu</h2>
            <div class="mx-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $menuItems = [
                        [
                            'name' => 'Nasi Goreng Spesial',
                            'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar pilihan.',
                            'price' => 35000,
                            'stock' => 15,
                            'image' => 'food-sample.jpg',
                        ],
                        [
                            'name' => 'Ayam Bakar Madu',
                            'description' => 'Ayam bakar dengan bumbu madu dan rempah pilihan.',
                            'price' => 45000,
                            'stock' => 8,
                            'image' => 'food-sample2.jpg',
                        ],
                        [
                            'name' => 'Es Teh Manis',
                            'description' => 'Teh manis dingin dengan es batu.',
                            'price' => 8000,
                            'stock' => 25,
                            'image' => 'food-sample3.jpg',
                        ],
                        [
                            'name' => 'Soto Ayam',
                            'description' => 'Soto ayam dengan bumbu rempah khas Indonesia.',
                            'price' => 30000,
                            'stock' => 12,
                            'image' => 'food-sample.jpg',
                        ],
                        [
                            'name' => 'Bakso Sapi',
                            'description' => 'Bakso daging sapi dengan kuah gurih.',
                            'price' => 25000,
                            'stock' => 18,
                            'image' => 'food-sample2.jpg',
                        ],
                        [
                            'name' => 'Mie Goreng',
                            'description' => 'Mie goreng dengan bumbu khas dan telur.',
                            'price' => 28000,
                            'stock' => 20,
                            'image' => 'food-sample3.jpg',
                        ],
                        [
                            'name' => 'Sate Ayam',
                            'description' => 'Sate ayam dengan bumbu kacang.',
                            'price' => 32000,
                            'stock' => 15,
                            'image' => 'food-sample.jpg',
                        ],
                        [
                            'name' => 'Gado-gado',
                            'description' => 'Sayuran segar dengan bumbu kacang.',
                            'price' => 22000,
                            'stock' => 10,
                            'image' => 'food-sample2.jpg',
                        ],
                        [
                            'name' => 'Es Jeruk',
                            'description' => 'Jeruk segar dengan es batu.',
                            'price' => 10000,
                            'stock' => 22,
                            'image' => 'food-sample3.jpg',
                        ],
                        [
                            'name' => 'Rendang Sapi',
                            'description' => 'Daging sapi dengan bumbu rendang khas Padang.',
                            'price' => 50000,
                            'stock' => 7,
                            'image' => 'food-sample.jpg',
                        ],
                    ];
                @endphp

                @for ($i = 0; $i < 10; $i++)
                    <!-- Food Card Item -->
                    <div class="flex h-full flex-col rounded-lg bg-white p-3 shadow-md sm:p-4">
                        <div class="flex flex-col gap-2 sm:flex-row">
                            <div class="overflow-hidden rounded-lg sm:w-1/3">
                                <img src="https://daganghalal.blob.core.windows.net/43646/Product/ayam-goreng-1718787242430.jpg"
                                    alt="{{ $menuItems[$i % count($menuItems)]['name'] }}"
                                    class="h-40 w-full object-cover object-center sm:h-full">
                            </div>
                            <div class="sm:w-2/3">
                                <h3 class="line-clamp-1 text-lg font-semibold text-gray-800 sm:text-xl">
                                    {{ $menuItems[$i]['name'] }}
                                </h3>
                                <p class="mt-1 line-clamp-2 text-xs text-gray-600 sm:text-sm">
                                    {{ $menuItems[$i]['description'] }}
                                </p>
                                <p class="mt-2 text-xs text-gray-500 sm:text-sm">Stok: {{ $menuItems[$i]['stock'] }}</p>
                            </div>
                        </div>
                        <div class="mt-auto flex items-center justify-between pt-3">
                            <p class="flex-shrink-0 text-base font-bold text-blue-600 sm:text-lg md:text-xl">Rp
                                {{ number_format($menuItems[$i]['price'], 0, ',', '.') }}</p>
                            <!-- Quantity Control -->
                            <div class="flex flex-shrink-0 items-center justify-end">
                                <button
                                    class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 transition-colors hover:bg-blue-500 hover:text-white md:h-8 md:w-8">
                                    <i class="fas fa-minus text-xs md:text-sm"></i>
                                </button>
                                <span
                                    class="mx-1 w-4 text-center text-xs font-medium sm:mx-2 sm:w-5 md:mx-2 md:w-6 md:text-sm">0</span>
                                <button
                                    class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-200 text-gray-700 transition-colors hover:bg-blue-500 hover:text-white md:h-8 md:w-8">
                                    <i class="fas fa-plus text-xs md:text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</x-layouts.app>
