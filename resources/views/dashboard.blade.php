@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Row 1 - Statistics Cards -->
<div class="flex flex-wrap -mx-3">
    <!-- Card 1 - Today's Money -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Today's Money</p>
                            <h5 class="mb-0 font-bold">
                                $53,000
                                <span class="text-sm leading-normal font-weight-bolder text-lime-500">+55%</span>
                            </h5>
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

    <!-- Card 2 - Today's Users -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Today's Users</p>
                            <h5 class="mb-0 font-bold">
                                2,300
                                <span class="text-sm leading-normal font-weight-bolder text-lime-500">+3%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-world text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 - New Clients -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">New Clients</p>
                            <h5 class="mb-0 font-bold">
                                +3,462
                                <span class="text-sm leading-normal font-weight-bolder text-red-600">-2%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 - Sales -->
    <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Sales</p>
                            <h5 class="mb-0 font-bold">
                                $103,430
                                <span class="text-sm leading-normal font-weight-bolder text-lime-500">+5%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-cart text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2 - Charts -->
<div class="flex flex-wrap mt-6 -mx-3">
        <!-- Sales Overview Chart -->
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                    <h6 class="mb-0">Sales overview</h6>
                    <p class="text-sm leading-normal">
                        <i class="fa fa-arrow-up text-lime-500"></i>
                        <span class="font-semibold">4% more</span> in 2021
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="relative">
                        <canvas id="chart-bars" class="chart-canvas" height="170" style="display: block; box-sizing: border-box; height: 170px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column -->
        <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
            <!-- Built by developers Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border mb-6">
                <div class="relative overflow-hidden bg-cover rounded-2xl" style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}')">
                    <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-80"></span>
                    <div class="relative z-10 flex-auto p-4">
                        <h5 class="mt-6 mb-12 text-white">Built by developers</h5>
                        <p class="text-white">From colors, cards, typography to complex elements, you will find the full documentation.</p>
                        <a class="text-white text-sm font-weight-bold leading-normal icon-move-right" href="javascript:;">
                            Read More
                            <i class="fas fa-arrow-right text-sm ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>        <!-- Work with the rockets Card -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                    <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                            <h5 class="mb-0 font-weight-bolder">Work with the rockets</h5>
                            <p class="mb-4 text-sm">Wealth creation is an evolutionarily recent positive-sum game. It is all about who take the opportunity first.</p>
                            <a class="text-body text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                                Read More
                                <i class="fas fa-arrow-right text-sm ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <div class="px-3 text-right basis-1/3">
                        <img class="w-full max-w-none" src="{{ asset('assets/img/illustrations/rocket-white.png') }}" alt="rocket">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3 - Projects and Orders -->
<div class="flex flex-wrap mt-6 -mx-3">
    <!-- Projects Table -->
    <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <div class="flex justify-between">
                    <h6 class="mb-0">Projects</h6>
                    <p class="text-sm leading-normal">
                        <i class="fa fa-check text-cyan-500"></i>
                        <span class="font-semibold">30 done</span> this month
                    </p>
                </div>
            </div>
            <div class="flex-auto p-0">
                <div class="p-0 overflow-x-auto">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">COMPANIES</th>
                                <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">MEMBERS</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">BUDGET</th>
                                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">COMPLETION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('assets/img/small-logos/logo-xd.svg') }}" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl" alt="xd">
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h6 class="mb-0 text-sm leading-normal">Soft UI XD Version</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('assets/img/team-1.jpg') }}" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 text-sm h-9 w-9 rounded-xl" alt="team1">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/img/team-2.jpg') }}" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 text-sm h-9 w-9 rounded-xl" alt="team2">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/img/team-3.jpg') }}" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 text-sm h-9 w-9 rounded-xl" alt="team3">
                                        </div>
                                        <div>
                                            <img src="{{ asset('assets/img/team-4.jpg') }}" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 text-sm h-9 w-9 rounded-xl" alt="team4">
                                        </div>
                                    </div>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <span class="text-xs font-semibold leading-tight text-slate-400">$14,000</span>
                                </td>
                                <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                    <div class="flex items-center justify-center">
                                        <span class="mr-2 text-xs font-semibold leading-tight text-slate-400">60%</span>
                                        <div class="text-xs h-0.75 w-30 m-0 flex overflow-visible rounded-lg bg-gray-200">
                                            <div class="duration-600 ease-soft bg-gradient-to-tl from-blue-600 to-cyan-400 -mt-0.38 -ml-px flex h-1.5 w-3/5 flex-col justify-center overflow-hidden whitespace-nowrap rounded bg-fuchsia-500 text-center text-white transition-all" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Add more project rows here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Overview -->
    <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-4 pb-0 mb-0 bg-white border-b-0 rounded-t-2xl">
                <h6 class="mb-0">Orders overview</h6>
                <p class="text-sm leading-normal">
                    <i class="fa fa-arrow-up text-lime-500"></i>
                    <span class="font-semibold">24%</span> this month
                </p>
            </div>
            <div class="flex-auto p-4">
                <div class="before:border-r-solid relative before:absolute before:top-0 before:left-4 before:h-full before:border-r-2 before:border-r-slate-100 before:content-[''] before:lg:-ml-px">
                    <div class="relative mb-4 mt-0 after:clear-both after:table after:content-['']">
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="ni ni-bell-55 relative z-10 leading-none text-transparent bg-gradient-to-tl from-green-600 to-lime-400 bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">$2400, Design changes</h6>
                            <p class="mt-1 mb-0 text-xs leading-tight text-slate-400">22 DEC 7:20 PM</p>
                        </div>
                    </div>
                    <div class="relative mb-4 after:clear-both after:table after:content-['']">
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="ni ni-html5 relative z-10 leading-none text-transparent bg-gradient-to-tl from-red-600 to-rose-400 bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">New order #1832412</h6>
                            <p class="mt-1 mb-0 text-xs leading-tight text-slate-400">21 DEC 11 PM</p>
                        </div>
                    </div>
                    <div class="relative mb-4 after:clear-both after:table after:content-['']">
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="ni ni-cart relative z-10 leading-none text-transparent bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Server payments for April</h6>
                            <p class="mt-1 mb-0 text-xs leading-tight text-slate-400">21 DEC 9:34 PM</p>
                        </div>
                    </div>
                    <div class="relative mb-4 after:clear-both after:table after:content-['']">
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="ni ni-credit-card relative z-10 leading-none text-transparent bg-gradient-to-tl from-red-500 to-yellow-400 bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">New card added for order #4395133</h6>
                            <p class="mt-1 mb-0 text-xs leading-tight text-slate-400">20 DEC 2:20 AM</p>
                        </div>
                    </div>
                    <div class="relative mb-4 after:clear-both after:table after:content-['']">
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="ni ni-key-25 relative z-10 leading-none text-transparent bg-gradient-to-tl from-purple-700 to-pink-500 bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">Unlock packages for development</h6>
                            <p class="mt-1 mb-0 text-xs leading-tight text-slate-400">18 DEC 4:54 AM</p>
                        </div>
                    </div>
                    <div class="relative mb-4 after:clear-both after:table after:content-['']">
                        <span class="w-6.5 h-6.5 text-base absolute left-4 z-10 inline-flex -translate-x-1/2 items-center justify-center rounded-full bg-white text-center font-semibold">
                            <i class="ni ni-money-coins relative z-10 leading-none text-transparent bg-gradient-to-tl from-gray-900 to-slate-800 bg-clip-text fill-transparent"></i>
                        </span>
                        <div class="ml-11.252 pt-1.4 lg:max-w-120 relative -top-1.5 w-auto">
                            <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">New order #9583120</h6>
                            <p class="mt-1 mb-0 text-xs leading-tight text-slate-400">17 DEC</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
// Chart.js Bar Chart Configuration
var ctx = document.getElementById("chart-bars").getContext("2d");

new Chart(ctx, {
    type: "bar",
    data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Sales",
            tension: 0.4,
            borderWidth: 0,
            borderRadius: 4,
            borderSkipped: false,
            backgroundColor: "rgba(255, 255, 255, .8)",
            data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
            maxBarThickness: 6
        }],
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
                    fontSize: 11,
                    fontColor: "#fff",
                    lineHeight: 2,
                    color: "rgba(255, 255, 255, .8)"
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
                    color: "rgba(255, 255, 255, .8)",
                    padding: 10,
                    fontSize: 11,
                    lineHeight: 2
                },
            },
        },
    },
});
</script>
@endpush
