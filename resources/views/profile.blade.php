<x-layouts.app>
    <x-layouts.header />
    <div class="flex justify-center pt-8">
        <div class="mx-4 w-full max-w-7xl overflow-hidden rounded-lg bg-white p-8 shadow-md">
            <h1 class="text-lg font-bold text-gray-800">Profile Information</h1>
            <p class="mb-6 text-gray-600">Update your account's profile information and email address.</p>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-6 flex gap-6">
                    <div class="flex">
                        <div class="h-32 w-32 overflow-hidden rounded-full border-2 border-blue-200 shadow-md">
                            <img id="image"
                                src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('storage/profile-photos/default.png') }}"
                                alt="Profile Photo" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="flex flex-col justify-center">
                        <label class="mb-2 block text-sm font-medium text-gray-700">Profile Photo</label>
                        <input type="file" name="image" id="image-upload"
                            class="block w-full rounded-md border border-gray-300 px-3 py-2 text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700"
                            onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])">
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" value="{{ auth()->user()->name }}"
                        class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                        class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex">
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="flex justify-center py-8">
        <div class="mx-4 w-full max-w-7xl overflow-hidden rounded-lg bg-white p-8 shadow-md">
            <h1 class="text-lg font-bold text-gray-800">Update Password</h1>
            <p class="mb-6 text-gray-600">Ensure your account is using a long, random password to stay secure.</p>
            <form action="{{ route('profile.update-password') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="current_password" class="mb-2 block text-sm font-medium text-gray-700">Current
                        Password</label>
                    <input type="password" id="current_password" name="current_password"
                        class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password" class="mb-2 block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" id="new_password" name="new_password"
                        class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('new_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="mb-2 block text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                        class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('new_password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex">
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>


</x-layouts.app>
