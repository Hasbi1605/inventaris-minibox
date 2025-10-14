<div id="content-cabang-cabang-{{ $cabangId }}" class="cabang-content hidden">
    <!-- Mini Statistics Cards - ADAPTIVE -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Item (Always Show) -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
            <div class="flex-auto p-4">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex-1">
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Item</p>
                        <h5 class="mb-0 font-bold text-slate-700">
                            {{ $statistics['total'] ?? 0 }}
                        </h5>
                    </div>
                    <div class="text-right ml-4">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                            <i class="fas fa-boxes text-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($statistics['has_operasional'] ?? false)
            {{-- ADAPTIVE MODE: Show Retail vs Operasional breakdown --}}
            
            <!-- Produk Retail -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Produk Retail</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                {{ $statistics['total_retail'] ?? 0 }}
                            </h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-shopping-bag text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Aset Operasional -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Aset Operasional</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                {{ $statistics['total_operasional'] ?? 0 }}
                            </h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-tools text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- RETAIL ONLY MODE: Show stock alerts --}}
            
            <!-- Stok Rendah -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Stok Rendah</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                {{ $statistics['hampir_habis'] ?? 0 }}
                            </h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-exclamation-triangle text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stok Habis -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Stok Habis</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                {{ $statistics['habis'] ?? 0 }}
                            </h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-times-circle text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif

        <!-- Total Nilai (Always Show) -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
            <div class="flex-auto p-4">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex-1">
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">
                            Total Nilai{{ ($statistics['has_operasional'] ?? false) ? ' Retail' : '' }}
                        </p>
                        <h5 class="mb-0 font-bold text-slate-700">
                            Rp {{ number_format($statistics['total_nilai'] ?? 0, 0, ',', '.') }}
                        </h5>
                    </div>
                    <div class="text-right ml-4">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                            <i class="fas fa-money-bill-wave text-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Daftar Inventaris - {{ $cabangNama }}</h6>
        </div>
        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Barang</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Kategori</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Stok</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Harga</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventaris as $item)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 leading-normal text-sm">{{ $item->nama_barang }}</h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400">{{ $item->satuan }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-slate-400">{{ $item->kategoriRelasi->nama_kategori ?? '-' }}</span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                @php
                                    $kategori = $item->kategoriRelasi->nama_kategori ?? '';
                                    $isOperasional = stripos($kategori, 'operasional') !== false || 
                                                    stripos($kategori, 'aset') !== false || 
                                                    stripos($kategori, 'peralatan') !== false;
                                @endphp
                                
                                @if($isOperasional)
                                    {{-- Tampilan untuk Aset Operasional --}}
                                    <div class="flex flex-col items-center">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">
                                            {{ $item->stok_saat_ini }} {{ $item->satuan }}
                                        </span>
                                        <span class="text-xxs text-slate-300 mt-0.5">
                                        </span>
                                    </div>
                                @else
                                    {{-- Tampilan untuk Produk Retail --}}
                                    <span class="text-xs font-semibold leading-tight {{ $item->stok_saat_ini <= $item->stok_minimal ? 'text-red-500' : 'text-slate-400' }}">
                                        {{ $item->stok_saat_ini }} / {{ $item->stok_minimal }} {{ $item->satuan }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                @if($isOperasional)
                                    {{-- Harga tidak relevan untuk operasional --}}
                                    <span class="text-xs font-semibold leading-tight text-slate-300">
                                        <i class="fas fa-minus"></i>
                                    </span>
                                @else
                                    <span class="text-xs font-semibold leading-tight text-slate-400">
                                        {{ $item->formatted_harga }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="bg-gradient-to-tl @if($item->status == 'tersedia') from-green-600 to-lime-400 @elseif($item->status == 'habis') from-red-600 to-rose-400 @elseif($item->status == 'hampir_habis') from-yellow-600 to-orange-400 @else from-gray-600 to-slate-400 @endif px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                    {{ ucfirst(str_replace('_',' ',$item->status)) }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex justify-center items-center space-x-3">
                                    <a href="{{ route('kelola-inventaris.show', $item->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kelola-inventaris.edit', $item->id) }}"
                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                       title="Edit Inventaris">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('kelola-inventaris.destroy', $item->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus inventaris {{ $item->nama_barang }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-red-600 to-yellow-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                                title="Hapus Inventaris">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="py-8">
                                    <i class="fas fa-boxes text-4xl text-slate-300 mb-4"></i>
                                    <p class="text-slate-500 mb-2">Belum ada data inventaris untuk cabang ini.</p>
                                    <p class="text-sm text-slate-400 mb-4">Coba ubah filter atau tambahkan data baru.</p>
                                    <a href="{{ route('kelola-inventaris.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">Tambah inventaris pertama</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($inventaris->hasPages())
        <div class="px-6 py-4">
            {{ $inventaris->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
