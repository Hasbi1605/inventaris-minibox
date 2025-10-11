@extends('layouts.admin')

@section('title', 'Detail Kapster')
@section('page-title', 'Detail Kapster')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Detail Kapster</h4>
            <p class="mb-0 text-sm text-slate-500">Informasi lengkap kapster: {{ $kelola_kapster->nama_kapster }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kelola-kapster.index') }}" 
                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="relative p-4 mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="relative p-4 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information Card -->
        <div class="lg:col-span-2">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex items-center justify-between">
                        <h6 class="font-bold">Informasi Kapster</h6>
                        <span class="bg-gradient-to-tl {{ $kelola_kapster->status === 'aktif' ? 'from-green-600 to-lime-400' : 'from-gray-600 to-slate-400' }} px-3 text-xs rounded-1.8 py-1.5 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                            {{ $kelola_kapster->status }}
                        </span>
                    </div>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Nama Kapster -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Kapster</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <h5 class="mb-0 font-semibold text-slate-700">{{ $kelola_kapster->nama_kapster }}</h5>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <span class="inline-flex items-center">
                                    <i class="fas fa-circle text-xs {{ $kelola_kapster->status == 'aktif' ? 'text-green-500' : 'text-gray-500' }} mr-2"></i>
                                    {{ ucfirst($kelola_kapster->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Cabang -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Cabang</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">{{ $kelola_kapster->cabang->nama_cabang }}</p>
                            </div>
                        </div>

                        <!-- No. Telepon -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">No. Telepon</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">
                                    @if($kelola_kapster->telepon)
                                        <i class="fas fa-phone text-xs mr-2"></i>
                                        {{ $kelola_kapster->telepon }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Spesialisasi -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Spesialisasi</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">{{ $kelola_kapster->spesialisasi ?: '-' }}</p>
                            </div>
                        </div>

                        <!-- Komisi Section -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Persentase Komisi</label>
                            <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-lg border border-blue-200">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="flex flex-col items-center p-3 bg-white rounded-lg shadow-sm">
                                        <i class="fas fa-cut text-blue-600 text-xl mb-2"></i>
                                        <span class="text-xs text-slate-600 mb-1">Potong Rambut</span>
                                        <span class="text-lg font-bold text-blue-700">{{ number_format($kelola_kapster->komisi_potong_rambut ?? 40, 0) }}%</span>
                                    </div>
                                    <div class="flex flex-col items-center p-3 bg-white rounded-lg shadow-sm">
                                        <i class="fas fa-spa text-blue-600 text-xl mb-2"></i>
                                        <span class="text-xs text-slate-600 mb-1">Layanan Lain</span>
                                        <span class="text-lg font-bold text-blue-700">{{ number_format($kelola_kapster->komisi_layanan_lain ?? 25, 0) }}%</span>
                                    </div>
                                    <div class="flex flex-col items-center p-3 bg-white rounded-lg shadow-sm">
                                        <i class="fas fa-shopping-bag text-blue-600 text-xl mb-2"></i>
                                        <span class="text-xs text-slate-600 mb-1">Produk</span>
                                        <span class="text-lg font-bold text-blue-700">{{ number_format($kelola_kapster->komisi_produk ?? 25, 0) }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats & Actions -->
        <div class="lg:col-span-1">
            <!-- Quick Stats -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Statistik Cepat</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-4 mt-4">
                        <!-- Status Visual -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Status Kapster</span>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ $kelola_kapster->status == 'aktif' ? 'bg-green-500' : 'bg-gray-500' }} mr-2"></div>
                                <span class="text-sm font-semibold">{{ ucfirst($kelola_kapster->status) }}</span>
                            </div>
                        </div>

                        <!-- Total Transaksi -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Total Transaksi</span>
                            <span class="text-sm font-semibold">
                                {{ $kelola_kapster->transaksi->count() }} transaksi
                            </span>
                        </div>

                        <!-- Bergabung Sejak -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Bergabung Sejak</span>
                            <span class="text-sm font-semibold">
                                {{ $kelola_kapster->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Aksi Cepat</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-3 mt-4">
                        <!-- Edit Action -->
                        <a href="{{ route('kelola-kapster.edit', $kelola_kapster->id) }}" 
                            class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Kapster
                        </a>

                        <!-- Delete Action -->
                        <form action="{{ route('kelola-kapster.destroy', $kelola_kapster->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kapster ini? Tindakan ini tidak dapat dibatalkan.')" 
                            class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Kapster
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Metadata Card -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Informasi Sistem</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-3 mt-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">ID Kapster:</span>
                            <span class="font-mono text-slate-800">#{{ $kelola_kapster->id }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Dibuat:</span>
                            <span class="text-slate-800">{{ $kelola_kapster->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Diperbarui:</span>
                            <span class="text-slate-800">{{ $kelola_kapster->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Transaksi Terbaru</h6>
            <p class="text-sm leading-normal text-slate-400">
                10 transaksi terakhir yang dilakukan oleh {{ $kelola_kapster->nama_kapster }}
            </p>
        </div>
        
        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                No. Transaksi
                            </th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Pelanggan
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Total
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelola_kapster->transaksi->take(10) as $transaksi)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-sm font-semibold leading-tight text-slate-600 px-6">
                                    {{ $transaksi->nomor_transaksi }}
                                </span>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex flex-col px-6">
                                    <span class="text-sm font-semibold leading-tight text-slate-700">
                                        {{ $transaksi->nama_pelanggan }}
                                    </span>
                                    @if($transaksi->telepon_pelanggan)
                                        <span class="text-xs text-slate-400">
                                            {{ $transaksi->telepon_pelanggan }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-slate-600">
                                    {{ $transaksi->tanggal_transaksi->format('d M Y') }}
                                </span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-sm font-semibold leading-tight text-slate-700">
                                    {{ $transaksi->formatted_total_harga }}
                                </span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="bg-gradient-to-tl {{ $transaksi->status_badge_color }} px-2 py-1 text-xs rounded font-bold uppercase text-white">
                                    {{ $transaksi->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fas fa-receipt text-4xl text-slate-300"></i>
                                    <p class="text-sm text-slate-500">Belum ada transaksi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection