@extends('layouts.admin')

@section('title', 'Edit Cabang')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Edit Cabang: {{ $cabang->nama_cabang }}</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('kelola-cabang.show', $cabang->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-eye mr-2"></i>Lihat
                        </a>
                        <a href="{{ route('kelola-cabang.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-slate-700">Edit Informasi Cabang</h6>
            </div>
            <div class="flex-auto p-6">
                <form action="{{ route('kelola-cabang.update', $cabang->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-wrap -mx-3">
                        <!-- Nama Cabang -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Cabang <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $cabang->nama_cabang) }}" placeholder="Contoh: Cabang Jakarta Timur" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_cabang') border-red-300 @enderror" required>
                            @error('nama_cabang')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Manager -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Manager <span class="text-red-500">*</span></label>
                            <input type="text" name="manager" value="{{ old('manager', $cabang->manager) }}" placeholder="Nama lengkap manager cabang" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('manager') border-red-300 @enderror" required>
                            @error('manager')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div class="w-full max-w-full px-3 mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" placeholder="Alamat lengkap cabang..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('alamat') border-red-300 @enderror" required>{{ old('alamat', $cabang->alamat) }}</textarea>
                            @error('alamat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telepon -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Telepon <span class="text-red-500">*</span></label>
                            <input type="tel" name="telepon" value="{{ old('telepon', $cabang->telepon) }}" placeholder="021-12345678" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('telepon') border-red-300 @enderror" required>
                            @error('telepon')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Email (Opsional)</label>
                            <input type="email" name="email" value="{{ old('email', $cabang->email) }}" placeholder="cabang@barbershop.com" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('email') border-red-300 @enderror">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status <span class="text-red-500">*</span></label>
                            <select name="status" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('status') border-red-300 @enderror" required>
                                <option value="">-- Pilih Status --</option>
                                @foreach($statusOptions as $key => $value)
                                <option value="{{ $key }}" {{ old('status', $cabang->status) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Buka -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Buka <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_buka" value="{{ old('tanggal_buka', $cabang->tanggal_buka->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_buka') border-red-300 @enderror" required>
                            @error('tanggal_buka')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Info Update -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Terakhir Diperbarui</label>
                            <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                {{ $cabang->updated_at->format('d F Y H:i') }}
                                <br>
                                <span class="text-xs text-slate-400">{{ $cabang->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <!-- Jam Operasional Buka -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jam Buka (Opsional)</label>
                            <input type="time" name="jam_operasional_buka" value="{{ old('jam_operasional_buka', $cabang->jam_operasional_buka) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jam_operasional_buka') border-red-300 @enderror">
                            @error('jam_operasional_buka')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jam Operasional Tutup -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jam Tutup (Opsional)</label>
                            <input type="time" name="jam_operasional_tutup" value="{{ old('jam_operasional_tutup', $cabang->jam_operasional_tutup) }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jam_operasional_tutup') border-red-300 @enderror">
                            @error('jam_operasional_tutup')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="w-full max-w-full px-3 mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi (Opsional)</label>
                            <textarea name="deskripsi" rows="4" placeholder="Deskripsi atau catatan tambahan tentang cabang..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-300 @enderror">{{ old('deskripsi', $cabang->deskripsi) }}</textarea>
                            @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="w-full px-3 flex gap-4">
                            <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-save mr-2"></i>Perbarui Cabang
                            </button>
                            <a href="{{ route('kelola-cabang.show', $cabang->id) }}" class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-slate-700 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
