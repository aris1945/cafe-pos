<div>
    <x-slot name="header">Kelola Daftar Menu</x-slot>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow mb-6">
        <h3 class="text-lg font-bold mb-4">{{ $isEdit ? 'Edit Menu' : 'Tambah Menu Baru' }}</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <div>
                <label>Nama Menu</label>
                <input type="text" wire:model="name" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Kategori</label>
                <select wire:model="category_id" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Harga</label>
                <input type="number" wire:model="price" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Gambar Menu</label>
                <input type="file" wire:model="newImage" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @if ($newImage)
                    <img src="{{ $newImage->temporaryUrl() }}" class="mt-2 h-20 rounded shadow">
                @elseif($isEdit && $existingImage)
                    <img src="{{ $existingImage }}" class="mt-2 h-20 rounded shadow">
                @endif
            </div>
            <div class="col-span-2 md:col-span-3">
                <label>Deskripsi</label>
                <input type="text" wire:model="description" class="mt-1 w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="flex items-center mt-6">
                <input type="checkbox" wire:model="is_active" class="rounded text-indigo-600 focus:ring-indigo-500">
                <label class="ml-2 font-medium">Menu Tersedia / Aktif</label>
            </div>
        </div>
        <div class="mt-4">
            @if($isEdit)
                <button wire:click="update" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Menu</button>
            @else
                <button wire:click="store" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Menu</button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded shadow p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border-b w-16">Gambar</th>
                    <th class="p-3 border-b">Kategori</th>
                    <th class="p-3 border-b">Nama</th>
                    <th class="p-3 border-b">Harga</th>
                    <th class="p-3 border-b">Status</th>
                    <th class="p-3 border-b text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                <tr class="hover:bg-gray-50 border-b">
                    <td class="p-3">
                        @if($menu->image)
                            <img src="{{ $menu->image }}" class="h-10 w-10 object-cover rounded shadow-sm">
                        @else
                            <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs shadow-sm">No img</div>
                        @endif
                    </td>
                    <td class="p-3">{{ $menu->category->name ?? '-' }}</td>
                    <td class="p-3 font-semibold">{{ $menu->name }}</td>
                    <td class="p-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 {{ $menu->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full text-xs font-bold">
                            {{ $menu->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </td>
                    <td class="p-3 text-right">
                        <button wire:click="edit({{ $menu->id }})" class="text-blue-600 hover:text-blue-800 mr-3">Edit</button>
                        <button wire:click="delete({{ $menu->id }})" class="text-red-600 hover:text-red-800">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $menus->links() }}
        </div>
    </div>
</div>
