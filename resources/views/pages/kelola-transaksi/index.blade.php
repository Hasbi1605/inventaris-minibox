@extends('layouts.admin')

@section('title', 'Kelola Transaksi')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Kelola Transaksi</h6>
                    <a href="{{ route('kelola-transaksi.create') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Transaksi</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['total'] ?? 0 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                    <i class="fas fa-receipt text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Hari Ini</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['today'] ?? 0 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                    <i class="fas fa-calendar-day text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Pending</p>
                                    <h5 class="mb-0 font-bold">
                                        {{ $statistics['pending'] ?? 0 }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-500 to-yellow-500">
                                    <i class="fas fa-clock text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Pendapatan Hari Ini</p>
                                    <h5 class="mb-0 font-bold text-sm">
                                        Rp {{ number_format($statistics['total_pendapatan_today'] ?? 0, 0, ',', '.') }}
                                    </h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                    <i class="fas fa-money-bill-wave text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Table -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-slate-700">Daftar Transaksi</h6>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
                <div class="p-0 overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No. Transaksi</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Pelanggan</th>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Layanan</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Tanggal</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksi as $item)
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div class="flex flex-col justify-center">
                                            <h6 class="mb-0 leading-normal text-sm font-semibold">{{ $item->nomor_transaksi }}</h6>
                                            <p class="mb-0 leading-tight text-xs text-slate-400">{{ $item->metode_pembayaran }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 leading-normal text-sm">{{ $item->nama_pelanggan }}</h6>
                                        <p class="mb-0 leading-tight text-xs text-slate-400">{{ $item->telepon_pelanggan ?? '-' }}</p>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="text-xs font-semibold leading-tight text-slate-400">
                                        {{ $item->layanan->nama_layanan ?? 'Layanan tidak ditemukan' }}
                                    </span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex flex-col justify-center">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">
                                            {{ $item->tanggal_transaksi->format('d/m/Y') }}
                                        </span>
                                        <span class="text-xs leading-tight text-slate-400">
                                            {{ $item->waktu_mulai }} - {{ $item->waktu_selesai ?? 'Belum selesai' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="text-xs font-semibold leading-tight text-slate-400">
                                        {{ $item->formatted_total_harga }}
                                    </span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="bg-gradient-to-tl {{ $item->status_badge_color }} px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        {{ str_replace('_', ' ', ucfirst($item->status)) }}
                                    </span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <a href="{{ route('kelola-transaksi.show', $item->id) }}" class="text-xs font-semibold leading-tight text-slate-400 hover:text-blue-500 mr-2" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('kelola-transaksi.edit', $item->id) }}" class="text-xs font-semibold leading-tight text-slate-400 hover:text-green-500 mr-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($item->status !== 'selesai')
                                    <form action="{{ route('kelola-transaksi.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-semibold leading-tight text-slate-400 hover:text-red-500" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center">
                                    <p class="text-slate-400">Belum ada data transaksi.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($transaksi->hasPages())
        <div class="mt-6">
            {{ $transaksi->links() }}
        </div>
        @endif
    </div>
</div>

@if(session('success'))
<div class="fixed top-4 right-4 z-50">
    <div class="bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed top-4 right-4 z-50">
    <div class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Auto hide alerts after 3 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.fixed.top-4.right-4 > div');
        alerts.forEach(alert => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });
    }, 3000);
</script>
@endpush
