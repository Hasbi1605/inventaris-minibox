<div id="content-cabang-{{ $cabangId }}" class="tab-content hidden">
    <!-- Statistics Cards untuk Cabang Ini -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Layanan di Cabang -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Layanan</p>
                                <h5 class="mb-0 font-bold text-lg">{{ $statistics['total'] ?? 0 }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="flex w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 items-center justify-center shadow-soft-md">
                                <i class="fas fa-cut text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Aktif di Cabang -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Layanan Aktif</p>
                                <h5 class="mb-0 font-bold text-lg">{{ $statistics['aktif'] ?? 0 }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="flex w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 items-center justify-center shadow-soft-md">
                                <i class="fas fa-check-circle text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Harga Tertinggi -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Harga Tertinggi</p>
                                <h5 class="mb-0 font-bold text-lg">Rp {{ number_format($statistics['max_harga'] ?? 0, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="flex w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 items-center justify-center shadow-soft-md">
                                <i class="fas fa-arrow-up text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Harga Terendah -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Harga Terendah</p>
                                <h5 class="mb-0 font-bold text-lg">Rp {{ number_format($statistics['min_harga'] ?? 0, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="flex w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 items-center justify-center shadow-soft-md">
                                <i class="fas fa-arrow-down text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Data -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Daftar Layanan - {{ $cabangNama }}</h6>
        </div>
        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Layanan</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Kategori</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Harga di Cabang Ini</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status di Cabang</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($layanan as $item)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 leading-normal text-sm font-semibold">{{ $item->nama_layanan }}</h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400">{{ Str::limit($item->deskripsi, 50) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-slate-600">
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                @php
                                    $cabangLayanan = $item->cabangs->firstWhere('id', $cabangId);
                                    $hargaCabang = $cabangLayanan ? $cabangLayanan->pivot->harga : $item->harga;
                                @endphp
                                <span class="text-xs font-semibold leading-tight text-slate-600">
                                    Rp {{ number_format($hargaCabang, 0, ',', '.') }}
                                </span>
                                @if($cabangLayanan && $cabangLayanan->pivot->harga != $item->harga)
{{--                                     <span class="block text-xxs text-slate-400 mt-1">
                                        Base: Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </span> --}}
                                @endif
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                @php
                                    $statusCabang = $cabangLayanan ? $cabangLayanan->pivot->status : 'tidak_aktif';
                                @endphp
                                @if($statusCabang == 'aktif')
                                    <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        Aktif
                                    </span>
                                @else
                                    <span class="bg-gradient-to-tl from-slate-600 to-slate-300 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex justify-center items-center space-x-3">
                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('kelola-layanan.show', $item->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('kelola-layanan.edit', $item->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                       title="Edit Layanan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                     <!-- Tombol Delete -->
                                    <form action="{{ route('kelola-layanan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan {{ $item->nama_layanan }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-red-600 to-yellow-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                                title="Hapus Layanan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center">
                                <p class="text-slate-400">Belum ada layanan untuk cabang {{ $cabangNama }}.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($layanan->hasPages())
        <div class="px-6 pb-6">
            {{ $layanan->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
