<?php

namespace App\Livewire;

use App\Models\CustomOption;
use App\Models\DetailTransaction;
use App\Models\DetailTransactionCustomOption;
use App\Models\Menu;
use App\Models\Transaction;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{
    public $menu;
    public $customerName;
    public $orderItems = [];
    public $totalPrice;
    public $listCustomOptions;
    public $listItemCustom;
    public $selectedItemIndex;
    public $selectedOptions = [];
    public $customOptions = [];
    public $isModalOpen = false;

    public function mount()
    {
        $this->menu = new Menu();
        $this->orderItems;
    }

    private function findItemKey(int $itemId)
    {
        foreach ($this->orderItems as $key => $item) {
            if (isset($item['id']) && $item['id'] == $itemId) {
                return $key;
            }
        }

        return false;
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
                if (isset($this->orderItems[$itemKey]['customOptions'])) {
                    array_pop($this->orderItems[$itemKey]['customOptions']);
                }
            }
        }

        $this->handleTotalPrice();
    }

    #[On('increment-quantity')]
    public function incrementQuantity(int $itemId)
    {
        $menu = Menu::find($itemId);
        if (!$menu)
            return;

        $itemKey = $this->findItemKey($itemId);

        if ($itemKey !== false) {
            $this->orderItems[$itemKey]['quantity']++;

            if (isset($this->orderItems[$itemKey]['customOptions'])) {
                array_push(
                    $this->orderItems[$itemKey]['customOptions'],
                    $menu->customOptions->groupBy('category')
                        ->map(fn($group) => [
                            'id' => $group->first()->id,
                            'value' => $group->first()->value,
                            'price' => $group->first()->additional_price
                        ])
                        ->toArray()
                );
            }
        } else {
            $this->orderItems[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'quantity' => 1,
                'image' => $menu->image,
                'customOptions' => $menu->customOptions->isNotEmpty() ? [
                    $menu->customOptions->groupBy('category')
                        ->map(fn($group) => [
                            'id' => $group->first()->id,
                            'value' => $group->first()->value,
                            'price' => $group->first()->additional_price
                        ])
                        ->toArray()
                ] : null,
            ];
        }

        $this->handleTotalPrice();
    }

    public function updatedSelectedItemIndex()
    {
        $options = $this->listItemCustom[array_keys($this->listItemCustom)[0]]['customOptions'][$this->selectedItemIndex];
        $this->selectedOptions = array_combine(
            array_keys($options),
            array_column($options, 'id')
        );
    }

    public function updatedSelectedOptions()
    {
        foreach ($this->selectedOptions as $key => $option) {
            $customOptionById = CustomOption::find($option);
            data_set($this->orderItems[array_keys($this->listItemCustom)[0]], 'customOptions.' . $this->selectedItemIndex . '.' . $key . '.id', $customOptionById->id);
            data_set($this->orderItems[array_keys($this->listItemCustom)[0]], 'customOptions.' . $this->selectedItemIndex . '.' . $key . '.value', $customOptionById->value);
            data_set($this->orderItems[array_keys($this->listItemCustom)[0]], 'customOptions.' . $this->selectedItemIndex . '.' . $key . '.price', $customOptionById->additional_price);
        }
        $this->handleTotalPrice();
    }

    public function handleTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->orderItems as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
            if (isset($item['customOptions'])) {
                foreach ($item['customOptions'] as $customOptionSet) {
                    foreach ($customOptionSet as $customOption) {
                        $totalPrice += $customOption['price'];
                    }
                }
            }
            $this->handleItemPrice($item);
        }

        $this->totalPrice = $totalPrice;
    }

    public function handleItemPrice($item)
    {
        $customOptions = [];
        if (isset($item['customOptions'])) {
            foreach ($item['customOptions'] as $optionGroup) {
                foreach ($optionGroup as $option) {
                    $customOptions[$option['value']] =
                        ($customOptions[$option['value']] ?? 0) + $option['price'];
                }
            }
        }

        $this->customOptions = $customOptions;
    }

    public function processTransaction()
    {
        // dd($this->orderItems);
        try {
            $validated = $this->validate([
                'customerName' => 'required|string|min:3',
                'totalPrice' => 'required|numeric|min:1'
            ], [
                'customerName.required' => 'Nama customer belum diisi!',
                'totalPrice.required' => 'Item belum diisi!',
            ]);

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_id' => 'TRX-' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
                'customer_name' => $validated['customerName'],
                'total_price' => $validated['totalPrice'] * 1.1,
                'status' => 'pending',
            ]);

            foreach ($this->orderItems as $item) {
                $customOptionsTotal = 0;
                if (isset($item['customOptions'])) {
                    $customOptionsTotal = array_sum(
                        array_map(
                            fn($optionSet) => array_sum(array_column($optionSet, 'price')),
                            $item['customOptions']
                        )
                    );
                }

                $detailTransaction = DetailTransaction::create([
                    'transaction_id' => $transaction->id,
                    'menu_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'] + $customOptionsTotal
                ]);

                if (isset($item['customOptions'])) {
                    foreach ($item['customOptions'] as $index => $optionSet) {
                        foreach ($optionSet as $option) {
                            DetailTransactionCustomOption::create([
                                'item_index' => $index,
                                'detail_transaction_id' => $detailTransaction->id,
                                'custom_option_id' => $option['id'],
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('transaction-failed', $e->getMessage());
            return;
        }

        $this->dispatch('transaction-success');
        $this->customerName = '';
        $this->orderItems = [];
        $this->totalPrice = 0;
    }

    public function showCustomizeModal(int $itemId)
    {
        $this->selectedItemIndex = 0;
        $this->listItemCustom = array_filter($this->orderItems, fn($item) => $item['id'] === $itemId);
        $this->listCustomOptions = Menu::find($itemId)->customOptions;

        $options = $this->listItemCustom[array_keys($this->listItemCustom)[0]]['customOptions'][$this->selectedItemIndex];
        $this->selectedOptions = array_combine(
            array_keys($options),
            array_column($options, 'id')
        );

        $this->isModalOpen = true;
    }

    public function hideCustomizeModal()
    {
        $this->isModalOpen = false;
    }

    public function render()
    {
        return view('components.order.cart');
    }
}
