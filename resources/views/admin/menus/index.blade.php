@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Daftar Menu Minuman</h1>
    <button onclick="openModal('addModal')" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
        + Tambah Menu Baru
    </button>
</div>

<div class="bg-white shadow-md rounded my-6 overflow-hidden">
    <table class="min-w-full w-full table-auto">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Foto</th>
                <th class="py-3 px-6 text-left">Nama Menu</th>
                <th class="py-3 px-6 text-left">Harga</th>
                <th class="py-3 px-6 text-center">Stok</th>
                <th class="py-3 px-6 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($menus as $menu)
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6 text-left whitespace-nowrap">
                    @if($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}" class="w-12 h-12 rounded object-cover border">
                    @else
                        <span class="text-gray-400">No IMG</span>
                    @endif
                </td>
                <td class="py-3 px-6 text-left font-bold">{{ $menu->name }}</td>
                <td class="py-3 px-6 text-left">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                <td class="py-3 px-6 text-center">
                    @if($menu->is_available)
                        <span class="bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs">Tersedia</span>
                    @else
                        <span class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs">Habis</span>
                    @endif
                </td>
                <td class="py-3 px-6 text-center">
                    <div class="flex item-center justify-center">
                        <button onclick="openEditModal({{ $menu }})" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus menu ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-4 transform hover:text-red-500 hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="menuModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">Tambah Menu Baru</h3>
            <form id="menuForm" action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="mt-2 text-left">
                @csrf
                <div id="methodField"></div> <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Menu</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                    <input type="number" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto Menu</label>
                    <input type="file" name="image" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                </div>

                <div class="mb-4">
                     <label class="inline-flex items-center">
                        <input type="checkbox" name="is_available" id="is_available" value="1" checked class="form-checkbox h-5 w-5 text-blue-600">
                        <span class="ml-2 text-gray-700">Stok Tersedia</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" onclick="closeModal()" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('menuModal');
    const form = document.getElementById('menuForm');
    const title = document.getElementById('modalTitle');
    const methodField = document.getElementById('methodField');

    // Buka Modal Tambah
    function openModal() {
        form.action = "{{ route('menus.store') }}";
        form.reset();
        methodField.innerHTML = ''; // Kosongkan method PUT
        title.innerText = "Tambah Menu Baru";
        modal.classList.remove('hidden');
    }

    // Buka Modal Edit (Isi data otomatis)
    function openEditModal(menu) {
        form.action = "/admin/menus/" + menu.id; // Set URL update
        methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">'; // Tambah method PUT

        document.getElementById('name').value = menu.name;
        document.getElementById('price').value = menu.price;
        document.getElementById('is_available').checked = menu.is_available;

        title.innerText = "Edit Menu: " + menu.name;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>
@endsection
