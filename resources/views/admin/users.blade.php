<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna (User List)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-800 text-white text-sm uppercase">
                            <th class="py-3 px-4">Nama User</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Kontak / WA</th>
                            <th class="py-3 px-4">Peran (Role)</th>
                            <th class="py-3 px-4">Bergabung Sejak</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm">
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-bold">{{ $user->name }}</td>
                            <td class="py-3 px-4">{{ $user->email }}</td>
                            <td class="py-3 px-4">
                                @if($user->no_hp)
                                    <span class="text-green-600 font-mono text-xs font-bold">
                                        <i class="fab fa-whatsapp"></i> {{ $user->no_hp }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs italic">- Kosong -</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($user->role == 'owner')
                                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">Juragan</span>
                                @else
                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">Anak Kos</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin MENGHAPUS user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-3 rounded text-xs shadow transition">
                                        🗑️ Hapus Akun
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($users->isEmpty())
                    <p class="text-center text-gray-500 mt-4">Belum ada user lain selain kamu.</p>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>