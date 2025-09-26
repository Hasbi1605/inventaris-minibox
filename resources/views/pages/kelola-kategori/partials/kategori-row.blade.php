<!-- Kategori Row -->
<div data-id="{{ $kategori->id }}" 
     class="kategori-item kategori-level-{{ $level }} flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $level > 0 ? 'ml-' . ($level * 4) : '' }}">
    
    <!-- Left Section: Category Info -->
    <div class="flex items-center flex-1 min-w-0">
        <!-- Drag Handle -->
        <div class="mr-3 cursor-move">
            <i class="fas fa-grip-vertical text-gray-400 hover:text-gray-600 transition-colors"></i>
        </div>
        
        <!-- Hierarchy Indicator -->
        @if($level > 0)
            <div class="text-gray-400 mr-3 flex items-center">
                @for($i = 0; $i < $level; $i++)
                    <i class="fas fa-level-up-alt transform rotate-90 text-xs mr-1"></i>
                @endfor
            </div>
        @endif
        
        <!-- Category Visual Identity -->
        <div class="flex items-center mr-3">
            @if($kategori->warna)
                <div class="w-4 h-4 rounded-full mr-2 flex-shrink-0 shadow-sm" 
                     style="background-color: {{ $kategori->warna }}; border: 1px solid rgba(0,0,0,0.1);"></div>
            @endif
            
            @if($kategori->ikon)
                <div class="mr-2 text-slate-600">
                    <i class="{{ $kategori->ikon }} text-sm"></i>
                </div>
            @endif
        </div>
        
        <!-- Category Name and Details -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center mb-1">
                <h6 class="font-semibold text-slate-700 truncate mr-2">{{ $kategori->nama_kategori }}</h6>
                
                @if($kategori->children->count() > 0)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 flex-shrink-0">
                        <i class="fas fa-sitemap mr-1"></i>
                        {{ $kategori->children->count() }} sub
                    </span>
                @endif
                
                @if(!$kategori->status)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 ml-2 flex-shrink-0">
                        Non-aktif
                    </span>
                @endif
            </div>
            
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <code class="bg-gray-100 px-2 py-0.5 rounded font-mono">{{ $kategori->kode_kategori }}</code>
                
                @if($kategori->deskripsi)
                    <span class="truncate">{{ Str::limit($kategori->deskripsi, 40) }}</span>
                @endif
                
                @php
                    $totalPenggunaan = 0;
                    if(isset($statistik)) {
                        $stat = collect($statistik)->firstWhere('kategori.id', $kategori->id);
                        $totalPenggunaan = $stat ? $stat['total_penggunaan'] : 0;
                    }
                @endphp
                
                @if($totalPenggunaan > 0)
                    <span class="inline-flex items-center text-blue-600">
                        <i class="fas fa-tag mr-1"></i>
                        {{ $totalPenggunaan }} digunakan
                    </span>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Right Section: Actions -->
    <div class="flex items-center gap-1 ml-3">
        <!-- View Detail -->
        @if(Route::has('kelola-kategori.show'))
        <a href="{{ route('kelola-kategori.show', $kategori->id) }}" 
           class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200" 
           title="Lihat Detail">
            <i class="fas fa-eye text-sm"></i>
        </a>
        @endif
        
        <!-- Edit -->
        <a href="{{ route('kelola-kategori.edit', $kategori->id) }}" 
           class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-yellow-600 hover:bg-yellow-50 transition-all duration-200" 
           title="Edit Kategori">
            <i class="fas fa-edit text-sm"></i>
        </a>
        
        <!-- Add Sub Category -->
        <a href="{{ route('kelola-kategori.create', ['parent_id' => $kategori->id, 'jenis' => $kategori->jenis_kategori]) }}" 
           class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-green-600 hover:bg-green-50 transition-all duration-200" 
           title="Tambah Sub-Kategori">
            <i class="fas fa-plus text-sm"></i>
        </a>
        
        <!-- Delete -->
        @if($totalPenggunaan == 0 && $kategori->children->count() == 0)
            <form action="{{ route('kelola-kategori.destroy', $kategori->id) }}" 
                  method="POST" 
                  class="inline"
                  onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->nama_kategori }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200" 
                        title="Hapus Kategori">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </form>
        @else
            <div class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-300" 
                 title="{{ $totalPenggunaan > 0 ? 'Tidak dapat dihapus karena sedang digunakan' : 'Tidak dapat dihapus karena memiliki sub-kategori' }}">
                <i class="fas fa-lock text-sm"></i>
            </div>
        @endif
    </div>
</div>

<!-- Child Categories -->
@if($kategori->children->count() > 0)
    @foreach($kategori->children as $child)
        @include('pages.kelola-kategori.partials.kategori-row', ['kategori' => $child, 'level' => $level + 1])
    @endforeach
@endif