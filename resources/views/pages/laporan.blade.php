@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div class="flex flex-wrap -mx-3">
    <!-- Statistics Cards -->
    <div class="w-full max-w-full px-3 mb-6">
        <div class="flex flex-wrap -mx-3">
            <!-- Total Transaksi -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Transaksi</p>
                                    <h5 class="mb-0 font-bold">Rp 15,400,000</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pengeluaran -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Pengeluaran</p>
                                    <h5 class="mb-0 font-bold">Rp 3,200,000</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">
                                    <i class="ni ni-cart text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Item Inventaris -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Item</p>
                                    <h5 class="mb-0 font-bold">125</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                    <i class="ni ni-app text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Cabang -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Cabang</p>
                                    <h5 class="mb-0 font-bold">5</h5>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-400">
                                    <i class="ni ni-building text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Keuangan -->
    <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Laporan Keuangan Bulanan</h6>
                <p class="text-sm leading-normal">
                    <i class="fa fa-arrow-up text-lime-500" aria-hidden="true"></i>
                    <span class="font-semibold">12% lebih tinggi</span> dari bulan lalu
                </p>
            </div>
            <div class="flex-auto p-4">
                <div class="p-6 bg-gray-50 rounded-lg">
                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Laporan Aktivitas Terbaru -->
    <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Aktivitas Terbaru</h6>
                <p class="text-sm leading-normal">
                    <span class="font-semibold">15 aktivitas</span> hari ini
                </p>
            </div>
            <div class="flex-auto p-4">
                <div class="before:font-awesome before:content-['\f0da'] before:text-xs before:text-slate-500 before:mr-2">
                    <div class="relative flex flex-wrap items-center justify-between py-2">
                        <div class="py-1 pr-1 mb-2 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg">
                            <h6 class="text-xs font-medium text-white">09:30</h6>
                        </div>
                        <div class="flex-auto px-2">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Transaksi baru</h6>
                            <p class="mb-0 text-xs leading-tight text-slate-400">Potong rambut + styling - Rp 85,000</p>
                        </div>
                        <div class="text-right basis-1/4">
                            <span class="text-xs font-semibold leading-tight text-slate-400">2 menit lalu</span>
                        </div>
                    </div>
                </div>

                <div class="before:font-awesome before:content-['\f0da'] before:text-xs before:text-slate-500 before:mr-2">
                    <div class="relative flex flex-wrap items-center justify-between py-2">
                        <div class="py-1 pr-1 mb-2 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg">
                            <h6 class="text-xs font-medium text-white">09:15</h6>
                        </div>
                        <div class="flex-auto px-2">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Inventaris ditambah</h6>
                            <p class="mb-0 text-xs leading-tight text-slate-400">Shampo L'oreal - 10 botol</p>
                        </div>
                        <div class="text-right basis-1/4">
                            <span class="text-xs font-semibold leading-tight text-slate-400">17 menit lalu</span>
                        </div>
                    </div>
                </div>

                <div class="before:font-awesome before:content-['\f0da'] before:text-xs before:text-slate-500 before:mr-2">
                    <div class="relative flex flex-wrap items-center justify-between py-2">
                        <div class="py-1 pr-1 mb-2 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg">
                            <h6 class="text-xs font-medium text-white">08:45</h6>
                        </div>
                        <div class="flex-auto px-2">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Pengeluaran baru</h6>
                            <p class="mb-0 text-xs leading-tight text-slate-400">Pembelian peralatan - Rp 450,000</p>
                        </div>
                        <div class="text-right basis-1/4">
                            <span class="text-xs font-semibold leading-tight text-slate-400">47 menit lalu</span>
                        </div>
                    </div>
                </div>

                <div class="before:font-awesome before:content-['\f0da'] before:text-xs before:text-slate-500 before:mr-2">
                    <div class="relative flex flex-wrap items-center justify-between py-2">
                        <div class="py-1 pr-1 mb-2 bg-gradient-to-tl from-gray-900 to-slate-800 rounded-lg">
                            <h6 class="text-xs font-medium text-white">08:30</h6>
                        </div>
                        <div class="flex-auto px-2">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Layanan selesai</h6>
                            <p class="mb-0 text-xs leading-tight text-slate-400">Facial treatment - Rp 120,000</p>
                        </div>
                        <div class="text-right basis-1/4">
                            <span class="text-xs font-semibold leading-tight text-slate-400">1 jam lalu</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Export Section -->
    <div class="w-full max-w-full px-3 mt-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Filter & Export Laporan</h6>
                <p class="text-sm leading-normal">Pilih periode dan jenis laporan yang ingin di-export</p>
            </div>
            <div class="flex-auto p-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Tanggal Mulai</label>
                        <input type="date" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" value="2024-09-01">
                    </div>
                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Tanggal Akhir</label>
                        <input type="date" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" value="2024-09-30">
                    </div>
                    <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                        <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Jenis Laporan</label>
                        <select class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                            <option>Laporan Keuangan</option>
                            <option>Laporan Transaksi</option>
                            <option>Laporan Inventaris</option>
                            <option>Laporan Layanan</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full max-w-full px-3">
                        <button class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="ni ni-single-copy-04 mr-2"></i>Export PDF
                        </button>
                        <button class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="ni ni-archive-2 mr-2"></i>Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Chart untuk laporan keuangan
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep"],
            datasets: [{
                label: "Pendapatan",
                tension: 0.4,
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                backgroundColor: "rgba(255, 255, 255, .8)",
                data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                maxBarThickness: 6
            }, ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 500,
                        beginAtZero: true,
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                        color: "#fff"
                    },
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5],
                        color: 'rgba(255, 255, 255, .2)'
                    },
                    ticks: {
                        display: true,
                        color: '#f8f9fa',
                        padding: 10,
                        font: {
                            size: 14,
                            weight: 300,
                            family: "Roboto",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>
@endsection
@endsection
