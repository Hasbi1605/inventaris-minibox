<!-- Kartu Metrik Utama Pendapatan -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <!-- Pendapatan Kotor -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Kotor</p>
                        <h5 class="mb-0 font-bold text-lg text-green-600" id="gross-revenue">Rp 15.400.000</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-dollar-sign text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendapatan Bersih -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Bersih</p>
                        <h5 class="mb-0 font-bold text-lg text-blue-600" id="net-revenue">Rp 12.200.000</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-receipt text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Target Bulanan -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="flex flex-row items-center justify-between">
                <div class="flex-1">
                    <div>
                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Progress Target</p>
                        <h5 class="mb-0 font-bold text-lg text-purple-600">77%</h5>
                    </div>
                </div>
                <div class="text-right ml-4">
                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-400 flex items-center justify-center shadow-soft-md">
                        <i class="fas fa-bullseye text-lg text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grafik dan Tabel Pendapatan -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Grafik Tren Pendapatan -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Tren Pendapatan</h6>
        </div>
        <div class="flex-auto p-4">
            <canvas id="revenue-trend-chart" class="chart-canvas" height="300"></canvas>
        </div>
    </div>

    <!-- Perbandingan Pendapatan per Cabang -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Pendapatan per Cabang</h6>
        </div>
        <div class="flex-auto p-4">
            <canvas id="branch-revenue-chart" class="chart-canvas" height="300"></canvas>
        </div>
    </div>
</div>

<!-- Tabel Peringkat Barber -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mt-6">
    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="font-bold">Peringkat Performa Barber</h6>
    </div>
    <div class="flex-auto p-4">
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom">
                    <tr>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">#</th>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nama Barber</th>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Cabang</th>
                        <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total Pendapatan</th>
                        <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jumlah Transaksi</th>
                    </tr>
                </thead>
                <tbody id="barber-performance-table">
                    <!-- Data will be loaded via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>
