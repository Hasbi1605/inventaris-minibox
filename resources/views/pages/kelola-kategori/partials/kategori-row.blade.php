<!-- Kategori Row -->
<tr data-id="{{ $kategori->id }}" class="kategori-level-{{ $level }}">
    <td class="text-center">
        <i class="fas fa-grip-vertical drag-handle text-gray-400 cursor-move"></i>
    </td>
    <td>
        <div class="flex items-center">
            @if($level > 0)
                <span class="text-gray-400 mr-2">
                    @for($i = 0; $i < $level; $i++)
                        <i class="fas fa-long-arrow-alt-right"></i>
                    @endfor
                </span>
            @endif
            
            @if($kategori->warna)
                <span class="inline-block w-4 h-4 rounded-full mr-2" 
                      style="background-color: {{ $kategori->warna }}"></span>
            @endif
            
            @if($kategori->ikon)
                <i class="fas {{ $kategori->ikon }} mr-2"></i>
            @endif
            
            <span class="font-medium">{{ $kategori->nama_kategori }}</span>
            
            @if($kategori->children->count() > 0)
                <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                    {{ $kategori->children->count() }} sub
                </span>
            @endif
        </div>
    </td>
    <td>
        <code class="bg-gray-100 px-2 py-1 rounded text-sm">{{ $kategori->kode_kategori }}</code>
    </td>
    <td class="text-sm text-gray-600">
        {{ Str::limit($kategori->deskripsi, 50) ?: '-' }}
    </td>
    <td>
        @if($kategori->status)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <i class="fas fa-check-circle mr-1"></i>
                Aktif
            </span>
        @else
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                <i class="fas fa-times-circle mr-1"></i>
                Nonaktif
            </span>
        @endif
    </td>
    <td>
        @php
            $totalPenggunaan = 0;
            if(isset($statistik)) {
                $stat = collect($statistik)->firstWhere('kategori.id', $kategori->id);
                $totalPenggunaan = $stat ? $stat['total_penggunaan'] : 0;
            }
        @endphp
        
        @if($totalPenggunaan > 0)
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                <i class="fas fa-tag mr-1"></i>
                {{ $totalPenggunaan }}
            </span>
        @else
            <span class="text-gray-400 text-sm">-</span>
        @endif
    </td>
    <td>
        <div class="flex items-center space-x-2">
            <!-- View -->
            <a href="{{ route('kelola-kategori.show', $kategori->id) }}" 
               class="text-blue-600 hover:text-blue-900 text-sm" title="Lihat Detail">
                <i class="fas fa-eye"></i>
            </a>
            
            <!-- Edit -->
            <a href="{{ route('kelola-kategori.edit', $kategori->id) }}" 
               class="text-yellow-600 hover:text-yellow-900 text-sm" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            
            <!-- Add Sub Category -->
            <a href="{{ route('kelola-kategori.create', ['parent_id' => $kategori->id, 'jenis' => $kategori->jenis_kategori]) }}" 
               class="text-green-600 hover:text-green-900 text-sm" title="Tambah Sub-Kategori">
                <i class="fas fa-plus"></i>
            </a>
            
            <!-- Delete -->
            @if($totalPenggunaan == 0)
                <a href="{{ route('kelola-kategori.destroy', $kategori->id) }}" 
                   class="text-red-600 hover:text-red-900 text-sm btn-delete" 
                   data-name="{{ $kategori->nama_kategori }}"
                   title="Hapus">
                    <i class="fas fa-trash"></i>
                </a>
            @else
                <span class="text-gray-300 text-sm" title="Tidak dapat dihapus karena masih digunakan">
                    <i class="fas fa-trash"></i>
                </span>
            @endif
        </div>
    </td>
</tr>

<!-- Child Categories -->
@if($kategori->children->count() > 0)
    @foreach($kategori->children as $child)
        @include('pages.kelola-kategori.partials.kategori-row', ['kategori' => $child, 'level' => $level + 1])
    @endforeach
@endif