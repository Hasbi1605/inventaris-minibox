@extends('layouts.admin')

@section('title', 'Kelola Pengeluaran')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Statistics Cards -->
        <div class="flex flex-wrap -mx-3">
            <!-- Total Pengeluaran -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Pengeluaran</p>
                                    <h5 class="mb-0 font-bold">
                                        Rp {{ number_format($statistics['total_pengeluaran'], 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">
                                    <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Bulan Ini -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Bulan Ini</p>
                                    <h5 class="mb-0 font-bold">
                                        Rp {{ number_format($statistics['pengeluaran_bulan_ini'], 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-600 to-yellow-400">
                                    <i class="ni leading-none ni-calendar-grid-58 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran Hari Ini -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Hari Ini</p>
                                    <h5 class="mb-0 font-bold">
                                        Rp {{ number_format($statistics['pengeluaran_hari_ini'], 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                    <i class="ni leading-none ni-single-02 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Harian -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Rata-rata Harian</p>
                                    <h5 class="mb-0 font-bold">
                                        Rp {{ number_format($statistics['rata_rata_harian'], 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                    <i class="ni leading-none ni-chart-bar-32 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0">Filter & Pencarian</h6>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-6">
                    <form method="GET" action="{{ route('kelola-pengeluaran.index') }}" class="flex flex-wrap -mx-3">
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/6 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori</label>
                            <select name="kategori" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/6 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/6 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/6 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jumlah Min</label>
                            <input type="number" name="jumlah_min" value="{{ request('jumlah_min') }}" placeholder="0" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/6 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jumlah Max</label>
                            <input type="number" name="jumlah_max" value="{{ request('jumlah_max') }}" placeholder="999999999" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/6 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full px-3 flex items-end gap-2">
                            <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('kelola-pengeluaran.index') }}" class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-slate-700 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0">Data Pengeluaran ({{ $pengeluaran->total() }} total)</h6>
                    <a href="{{ route('kelola-pengeluaran.create') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-plus mr-2"></i>Tambah Pengeluaran
                    </a>
                </div>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Tanggal</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Deskripsi</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Kategori</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jumlah</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengeluaran as $item)
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="px-2 py-1">
                                        <div>
                                            <h6 class="mb-0 text-sm leading-normal">{{ $item->tanggal_pengeluaran->format('d M Y') }}</h6>
                                            <p class="mb-0 text-xs leading-tight text-slate-400">{{ $item->tanggal_pengeluaran->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="px-2 py-1">
                                        <div>
                                            <h6 class="mb-0 text-sm leading-normal">{{ $item->deskripsi }}</h6>
                                            @if($item->catatan)
                                            <p class="mb-0 text-xs leading-tight text-slate-400">{{ Str::limit($item->catatan, 50) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="px-2 py-1">
                                        <span class="bg-gradient-to-tl {{ $item->kategori_badge_color }} px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                            {{ ucfirst(str_replace('_', ' ', $item->kategori)) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="text-sm font-semibold leading-tight text-slate-600">{{ $item->formatted_jumlah }}</span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('kelola-pengeluaran.show', $item->id) }}" class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102">
                                            <i class="fas fa-eye text-white"></i>
                                        </a>
                                        <a href="{{ route('kelola-pengeluaran.edit', $item->id) }}" class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
                                        <form action="{{ route('kelola-pengeluaran.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102">
                                                <i class="fas fa-trash text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center align-middle bg-transparent border-b shadow-transparent">
                                    <div class="py-8">
                                        <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                                        <p class="text-slate-400 mb-4">Belum ada data pengeluaran</p>
                                        <a href="{{ route('kelola-pengeluaran.create') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                            <i class="fas fa-plus mr-2"></i>Tambah Pengeluaran Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($pengeluaran->hasPages())
                <div class="px-6 py-4">
                    {{ $pengeluaran->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
