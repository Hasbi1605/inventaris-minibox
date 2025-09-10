@extends('layouts.admin')

@section('title', 'Kelola Cabang')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Statistics Cards -->
        <div class="flex flex-wrap -mx-3">
            <!-- Total Cabang -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Cabang</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['total_cabang'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                    <i class="ni leading-none ni-building text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabang Aktif -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Cabang Aktif</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['cabang_aktif'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                    <i class="ni leading-none ni-check-bold text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sedang Buka -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Sedang Buka</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['cabang_sedang_buka'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-600 to-yellow-400">
                                    <i class="ni leading-none ni-time-alarm text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cabang Baru -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/4 sm:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Cabang Baru (30 hari)</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['cabang_baru'] }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-400">
                                    <i class="ni leading-none ni-shop text-lg relative top-3.5 text-white"></i>
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
                    <form method="GET" action="{{ route('kelola-cabang.index') }}" class="flex flex-wrap -mx-3">
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/5 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                            <select name="status" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="renovasi" {{ request('status') == 'renovasi' ? 'selected' : '' }}>Renovasi</option>
                            </select>
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/5 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Manager</label>
                            <select name="manager" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Manager</option>
                                @foreach($managers as $manager)
                                <option value="{{ $manager }}" {{ request('manager') == $manager ? 'selected' : '' }}>
                                    {{ $manager }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/5 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/5 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full max-w-full px-3 mb-4 md:w-1/5 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, alamat, telepon..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <div class="w-full px-3 flex items-end gap-2">
                            <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('kelola-cabang.index') }}" class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-slate-700 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in hover:shadow-soft-xs active:opacity-85 hover:scale-102">
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
                    <h6 class="mb-0">Data Cabang ({{ $cabang->total() }} total)</h6>
                    <a href="{{ route('kelola-cabang.create') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-plus mr-2"></i>Tambah Cabang
                    </a>
                </div>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Cabang</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Manager</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jam Operasional</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cabang as $item)
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="px-2 py-1">
                                        <div>
                                            <h6 class="mb-0 text-sm leading-normal font-semibold">{{ $item->nama_cabang }}</h6>
                                            <p class="mb-0 text-xs leading-tight text-slate-400">{{ $item->short_alamat }}</p>
                                            <p class="mb-0 text-xs leading-tight text-slate-600">
                                                <i class="fas fa-phone text-xxs mr-1"></i>{{ $item->telepon }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="px-2 py-1">
                                        <div>
                                            <h6 class="mb-0 text-sm leading-normal">{{ $item->manager }}</h6>
                                            @if($item->email)
                                            <p class="mb-0 text-xs leading-tight text-slate-400">{{ $item->email }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="px-2 py-1">
                                        <span class="bg-gradient-to-tl {{ $item->status_badge_color }} px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                        @if($item->is_open)
                                        <div class="text-xs text-green-600 mt-1">
                                            <i class="fas fa-circle text-xxs mr-1"></i>Sedang Buka
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="text-sm leading-tight text-slate-600">{{ $item->jam_operasional }}</span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('kelola-cabang.show', $item->id) }}" class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:scale-102">
                                            <i class="fas fa-eye text-white"></i>
                                        </a>
                                        <a href="{{ route('kelola-cabang.edit', $item->id) }}" class="relative z-10 inline-block px-4 py-3 mb-0 font-bold text-center text-transparent uppercase align-middle transition-all border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>
                                        <form action="{{ route('kelola-cabang.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cabang ini?')">
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
                                        <i class="fas fa-building text-4xl text-slate-300 mb-4"></i>
                                        <p class="text-slate-400 mb-4">Belum ada data cabang</p>
                                        <a href="{{ route('kelola-cabang.create') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                            <i class="fas fa-plus mr-2"></i>Tambah Cabang Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($cabang->hasPages())
                <div class="px-6 py-4">
                    {{ $cabang->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
