<x-layouts.app>
    <x-layouts.header />
    @error('error')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror
</x-layouts.app>
