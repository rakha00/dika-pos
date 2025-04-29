<?php

namespace App\Livewire;

use App\Models\DetailTransaction;
use App\Models\DetailCustomOption;
use App\Models\Menu;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $customerName;
    public $orderItems = [];
    public $totalPrice;
    public $selectedOption = [];
    public $currentItemName;
    public $isModalOpen = false;
    public $currentItemId;
    public $customOptions = [];
    public $currentItemIndex;

    public function mount()
    {
        $this->orderItems = [];
        $this->totalPrice = 0;
    }

    #[On('decrement-quantity')]
    public function decrementQuantity(int $itemId)
    {
        $menu = Menu::find($itemId);
        if (!$menu)
            return;

        $itemKey = $this->findItemKey($itemId);

        if ($itemKey !== false) {
            if ($this->orderItems[$itemKey]['quantity'] <= 1) {
                array_splice($this->orderItems, $itemKey, 1);
            } else {
                $this->orderItems[$itemKey]['quantity']--;
            }
        }
    }

    #[On('increment-quantity')]
    public function incrementQuantity(int $itemId, $customOptions = null)
    {
        $menu = Menu::find($itemId);
        if (!$menu)
            return;

        $normalizedOptions = is_array($customOptions) ? array_map('strval', $customOptions) : [];
        ksort($normalizedOptions);

        $additionalPrice = \App\Models\CustomOptionValue::whereIn('id', $normalizedOptions)->sum('additional_price');
        $newPrice = $menu->price + $additionalPrice;

        $this->orderItems[] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $newPrice,
            'quantity' => 1,
            'image' => $menu->image,
            'is_customizable' => $menu->is_customizable,
            'customOptionsList' => [$normalizedOptions],
        ];
    }

    private function findItemKey(int $itemId, $customOptions = null)
    {
        $normalizedIncoming = is_array($customOptions) ? $customOptions : [];
        ksort($normalizedIncoming);

        foreach ($this->orderItems as $key => $item) {
            $storedOptions = $item['customOptionsList'][0] ?? [];
            ksort($storedOptions);

            if (
                $item['id'] == $itemId &&
                $storedOptions == $normalizedIncoming
            ) {
                return $key;
            }
        }

        return false;
    }

    public function generateTransactionId()
    {
        $today = date('Y-m-d');
        $latestTransaction = Transaction::whereDate('created_at', $today)
            ->latest()
            ->first();

        if ($latestTransaction) {
            $lastId = $latestTransaction->id_transaction;
            $numericPart = (int) substr($lastId, 1);
            $newNumericPart = $numericPart + 1;
        } else {
            $newNumericPart = 1;
        }

        return '#' . str_pad($newNumericPart, 3, '0', STR_PAD_LEFT);
    }

    public function processTransaction()
    {
        try {
            $validated = $this->validate([
                'customerName' => 'required',
                'orderItems' => 'required|array|min:1',
            ]);

            $totalPrice = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->orderItems)) * 1.1;
            $transaction = Transaction::create([
                'id_user' => auth()->id(),
                'id_transaction' => $this->generateTransactionId(),
                'customer_name' => $validated['customerName'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($this->orderItems as $item) {
                $detailTransaction = DetailTransaction::create([
                    'id_transaction' => $transaction->id,
                    'id_menu' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                    'custom_options' => isset($item['customOptionsList'][0]) ? json_encode($item['customOptionsList'][0]) : json_encode([]),
                ]);

                if (isset($item['customOptionsList'][0])) {
                    foreach ($item['customOptionsList'][0] as $optionId) {
                        DetailCustomOption::create([
                            'detail_transaction_id' => $detailTransaction->id,
                            'custom_option_value_id' => $optionId,
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('transaction-failed', $e->getMessage());
            return;
        }

        $this->orderItems = [];
        $this->customerName = ' ';

        $this->dispatch('transaction-success');
    }

    public function getCurrentItemNameProperty()
    {
        $item = collect($this->orderItems)->firstWhere('id', $this->currentItemId);
        return $item['name'] ?? 'Menu';
    }

    public function addCustomOptions(int $itemId)
    {
        if (isset($this->orderItems[$this->currentItemIndex])) {
            $this->orderItems[$this->currentItemIndex]['customOptionsList'] = $this->selectedOption;

            $optionIds = collect($this->selectedOption[0] ?? [])->values()->all();
            $additionalPrice = \App\Models\CustomOptionValue::whereIn('id', $optionIds)->sum('additional_price');
            $basePrice = Menu::find($itemId)->price;
            $this->orderItems[$this->currentItemIndex]['price'] = $basePrice + $additionalPrice;
        }

        $this->isModalOpen = false;
    }

    public function showCustomizeModal($itemId, $index)
    {
        $this->isModalOpen = true;
        $this->currentItemId = $itemId;
        $this->currentItemIndex = $index;

        $menu = Menu::with('customOptions.customOptionValues')->find($itemId);
        if ($menu && $menu->is_customizable) {
            $this->customOptions = $menu->customOptions;
        }

        if (isset($this->orderItems[$index])) {
            $this->selectedOption = $this->orderItems[$index]['customOptionsList'];
        } else {
            $this->selectedOption = [];
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->currentItemId = null;
        $this->currentItemName = '';
        $this->selectedOption = '';
    }

    public function render()
    {
        return view('components.order.cart', [
            'orderItems' => $this->orderItems
        ]);
    }
}
