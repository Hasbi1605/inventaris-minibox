@extends('layouts.admin')

@section('title', 'Detail Cabang')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Detail Cabang: {{ $cabang->nama_cabang }}</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('kelola-cabang.edit', $cabang->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('kelola-cabang.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Content -->
        <div class="flex flex-wrap -mx-3">
            <!-- Main Info -->
            <div class="w-full max-w-full px-3 lg:w-2/3 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Informasi Cabang</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Cabang</label>
                                <div class="text-lg font-semibold text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $cabang->nama_cabang }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Manager</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $cabang->manager }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="bg-gradient-to-tl {{ $cabang->status_badge_color }} px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        {{ ucfirst(str_replace('_', ' ', $cabang->status)) }}
                                    </span>
                                    @if($cabang->is_open)
                                    <div class="text-xs text-green-600 mt-2">
                                        <i class="fas fa-circle text-xxs mr-1"></i>Sedang Buka Sekarang
                                    </div>
                                    @else
                                    <div class="text-xs text-slate-400 mt-2">
                                        <i class="fas fa-circle text-xxs mr-1"></i>Sedang Tutup
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Alamat Lengkap</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $cabang->alamat }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Telepon</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    <i class="fas fa-phone text-xs mr-2"></i>{{ $cabang->telepon }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Email</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    @if($cabang->email)
                                    <i class="fas fa-envelope text-xs mr-2"></i>{{ $cabang->email }}
                                    @else
                                    <span class="text-slate-400">Tidak ada email</span>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3 min-h-[80px]">
                                    {{ $cabang->deskripsi ?? 'Tidak ada deskripsi' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Operational & Timeline Info -->
            <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                <!-- Operational Information -->
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Operasional</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jam Operasional</label>
                            <div class="text-lg font-semibold text-slate-600">
                                {{ $cabang->jam_operasional }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Buka</label>
                            <div class="text-sm text-slate-600">
                                {{ $cabang->tanggal_buka->format('d F Y') }}
                                <div class="text-xs text-slate-400 mt-1">
                                    {{ $cabang->tanggal_buka->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Usia Cabang</label>
                            <div class="text-sm text-slate-600">
                                {{ $cabang->age_in_days }} hari
                                <div class="text-xs text-slate-400 mt-1">
                                    Sekitar {{ round($cabang->age_in_days / 30, 1) }} bulan
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status Saat Ini</label>
                            <div class="text-sm text-slate-600">
                                @if($cabang->status === 'aktif')
                                    @if($cabang->is_open)
                                    <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        <i class="fas fa-circle text-xxs mr-1"></i>Buka
                                    </span>
                                    @else
                                    <span class="bg-gradient-to-tl from-orange-600 to-yellow-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        <i class="fas fa-circle text-xxs mr-1"></i>Tutup
                                    </span>
                                    @endif
                                @else
                                <span class="bg-gradient-to-tl from-red-600 to-rose-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                    <i class="fas fa-times text-xxs mr-1"></i>Tidak Aktif
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Information -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Timeline</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Dibuat</label>
                            <div class="text-sm text-slate-600">
                                {{ $cabang->created_at->format('d F Y H:i') }}
                                <div class="text-xs text-slate-400">
                                    {{ $cabang->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Terakhir Diperbarui</label>
                            <div class="text-sm text-slate-600">
                                {{ $cabang->updated_at->format('d F Y H:i') }}
                                <div class="text-xs text-slate-400">
                                    {{ $cabang->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">ID Record</label>
                            <div class="text-sm text-slate-600 font-mono">
                                #{{ str_pad($cabang->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        @if($cabang->created_at != $cabang->updated_at)
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status Record</label>
                            <div class="text-xs">
                                <span class="bg-gradient-to-tl from-orange-600 to-yellow-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                    Telah Diperbarui
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-slate-700">Aksi Cepat</h6>
            </div>
            <div class="flex-auto p-6">
                <div class="flex gap-3">
                    <a href="{{ route('kelola-cabang.edit', $cabang->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-edit mr-2"></i>Edit Cabang
                    </a>
                    
                    @if($cabang->status === 'aktif')
                    <form action="{{ route('kelola-cabang.toggle-status', $cabang->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menonaktifkan cabang ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-orange-600 to-yellow-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-pause mr-2"></i>Nonaktifkan
                        </button>
                    </form>
                    @else
                    <form action="{{ route('kelola-cabang.toggle-status', $cabang->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin mengaktifkan cabang ini?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-play mr-2"></i>Aktifkan
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('kelola-cabang.destroy', $cabang->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus cabang ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-trash mr-2"></i>Hapus Cabang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
