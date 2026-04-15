<div>
    <x-slot name="header">Kelola Akun Kasir</x-slot>

    @if (session()->has('success'))
        <div class="mb-6 bg-green-100 text-green-700 p-4 rounded-lg flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="text-green-700" onclick="this.parentElement.remove();">&times;</button>
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-800">{{ $isEdit ? 'Edit Akun Kasir' : 'Tambah Kasir Baru' }}</h3>
            @if($isEdit)
                <button wire:click="resetFields" class="text-sm text-gray-500 hover:text-gray-700 font-semibold underline">Batal Edit</button>
            @endif
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" wire:model="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" wire:model="email" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    Password 
                    @if($isEdit)<span class="text-gray-400 font-normal text-xs ml-1">(Kosongkan jika tidak ingin mengubah)</span>@endif
                </label>
                <input type="password" wire:model="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition">
                @error('password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex items-center pt-6">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Akun Aktif (Dapat Login)</span>
                </label>
            </div>
        </div>
        
        <div class="mt-8 flex justify-end">
            @if($isEdit)
                <button wire:click="update" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold py-2 px-8 rounded-xl shadow-md transition transform active:scale-95">Update Kasir</button>
            @else
                <button wire:click="store" class="bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-bold py-2 px-8 rounded-xl shadow-md transition transform active:scale-95">Simpan Kasir</button>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full mb-0 text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-sm text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="py-4 px-6 font-semibold">Nama</th>
                        <th class="py-4 px-6 font-semibold">Email</th>
                        <th class="py-4 px-6 font-semibold text-center">Status</th>
                        <th class="py-4 px-6 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($kasirs as $kasir)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-4 px-6 font-bold">{{ $kasir->name }}</td>
                        <td class="py-4 px-6">{{ $kasir->email }}</td>
                        <td class="py-4 px-6 text-center">
                            @if($kasir->is_active)
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Non-aktif</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right space-x-3">
                            <button wire:click="edit({{ $kasir->id }})" class="text-blue-600 hover:text-blue-800 font-semibold transition">Edit</button>
                            <button wire:click="delete({{ $kasir->id }})" onclick="confirm('Yakin ingin menghapus kasir ini?') || event.stopImmediatePropagation()" class="text-red-600 hover:text-red-800 font-semibold transition">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500 text-lg">Belum ada akun kasir.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kasirs->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $kasirs->links() }}
        </div>
        @endif
    </div>
</div>
