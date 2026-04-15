<div>
    <x-slot name="header">Kelola Kategori Menu</x-slot>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-lg font-bold mb-4">{{ $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru' }}</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Nama Kategori</label>
                <input type="text" wire:model="name" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Slug</label>
                <input type="text" wire:model="slug" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="mt-4">
            @if($isEdit)
                <button wire:click="update" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
            @else
                <button wire:click="store" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan</button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded shadow p-6">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border-b">ID</th>
                    <th class="p-3 border-b">Nama</th>
                    <th class="p-3 border-b">Slug</th>
                    <th class="p-3 border-b text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">{{ $cat->id }}</td>
                    <td class="p-3 border-b">{{ $cat->name }}</td>
                    <td class="p-3 border-b">{{ $cat->slug }}</td>
                    <td class="p-3 border-b text-right">
                        <button wire:click="edit({{ $cat->id }})" class="text-blue-600 hover:text-blue-800 mr-3">Edit</button>
                        <button wire:click="delete({{ $cat->id }})" class="text-red-600 hover:text-red-800">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
