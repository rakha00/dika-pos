<x-layouts.app>
    <x-layouts.header />
    <x-order.order-list />
    @error('error')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror
</x-layouts.app>
