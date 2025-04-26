<div class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="fixed inset-0 z-50 cursor-pointer bg-black opacity-50" wire:click="hideCustomizeModal">
    </div>
    <div class="z-100 relative max-h-[80vh] overflow-y-auto rounded-md bg-white p-6 shadow-lg">
        <div class="flex justify-end">
            <button wire:click="hideCustomizeModal" class="text-gray-500 transition-colors hover:text-red-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div>
            <!-- Dropdown for selecting item number -->
            <div class="mb-4">
                <label for="itemSelector" class="block font-semibold">Pilih Item:</label>
                <select id="itemSelector" wire:model.change="selectedItemIndex"
                    class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @foreach (current($listItemCustom)['customOptions'] as $index => $item)
                        <option value="{{ $index }}" wire:key="{{ $index }}">
                            {{ '#' . ($index + 1) . ' ' . current($listItemCustom)['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Customize Item Details -->
            <div class="mb-4">
                <div id="itemDetails" class="mb-4 rounded-md p-4 shadow-sm">
                    <div class="custom-options-container">
                        @foreach ($listCustomOptions->groupBy('category') as $category => $options)
                            <div class="option-group mb-4" wire:key="{{ $category }}">
                                <label class="block font-semibold text-gray-700">{{ $category }}</label>
                                <div class="mt-2 space-y-2">
                                    @foreach ($options as $index => $option)
                                        <label class="mr-4 inline-flex items-center" wire:key="{{ $option->id }}">
                                            <input type="radio" name="custom_option_{{ $category }}"
                                                value="{{ $option->id }}"
                                                wire:model.change="selectedOptions.{{ $category }}"
                                                class="form-radio h-4 w-4 text-blue-600">
                                            <span class="ml-2 text-sm text-gray-700">
                                                {{ $option->value }}
                                                {{ $option->additional_price }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 text-right">
            <button wire:click="hideCustomizeModal"
                class="rounded bg-blue-500 px-4 py-2 text-white transition-colors hover:bg-blue-600">
                Save
            </button>
        </div>
    </div>
</div>
