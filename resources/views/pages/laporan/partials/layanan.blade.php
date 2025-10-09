<!-- Kartu Metrik Layanan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Layanan Terjual -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Layanan</p>
                        <h5 class="mb-0 font-bold text-lg text-blue-600">245</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-cut text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Retail Terjual -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Produk Retail</p>
                        <h5 class="mb-0 font-bold text-lg text-orange-600">156</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-600 to-yellow-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-box text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paket Layanan -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Paket Premium</p>
                        <h5 class="mb-0 font-bold text-lg text-purple-600">89</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-star text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rata-rata Nilai Transaksi -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Rata-rata Transaksi</p>
                        <h5 class="mb-0 font-bold text-lg text-green-600">Rp 65K</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-chart-bar text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grafik dan Tabel Layanan -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Grafik Layanan Terlaris -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Distribusi Layanan</h6>
        </div>
        <div class="flex-auto p-4">
            <canvas id="services-distribution-chart" class="chart-canvas" height="300"></canvas>
        </div>
    </div>

    <!-- Tabel Layanan Terlaris -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Peringkat Layanan Terlaris</h6>
        </div>
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">#</th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Layanan</th>
                            <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Terjual</th>
                            <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody id="services-ranking-table">
                        <!-- Data will be loaded via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
