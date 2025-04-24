<div class="fixed inset-0 flex items-center justify-center z-50" style="display: {{ $isOpen ? 'block' : 'none' }}">
    <div class="modal-overlay fixed inset-0 bg-gray-500 opacity-75" wire:click="closeModal"></div>
    <div class="modal-content bg-white p-6 rounded-md shadow-lg">
        <div class="modal-header flex justify-between">
            <h3 class="text-lg font-bold">Custom Menu</h3>
            <button wire:click="closeModal" class="text-gray-500">X</button>
        </div>
        <div class="modal-body">
            <!-- Konten Modal, misalnya pilihan custom menu -->
            <div>
                <label for="customMenu">Pilih Custom Menu</label>
                <select id="customMenu" name="customMenu" class="w-full p-2 border border-gray-300 rounded">
                    <option value="custom1">Custom Menu 1</option>
                    <option value="custom2">Custom Menu 2</option>
                    <option value="custom3">Custom Menu 3</option>
                </select>
            </div>
        </div>
        <div class="modal-footer mt-4 text-right">
            <button wire:click="closeModal" class="px-4 py-2 bg-blue-500 text-white rounded">Tutup</button>
        </div>
    </div>
</div>