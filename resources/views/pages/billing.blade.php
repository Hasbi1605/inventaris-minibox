@extends('layouts.admin')

@section('title', 'Billing')
@section('page-title', 'Billing')

@section('content')
<div class="flex flex-wrap -mx-3">
    <!-- Left Column -->
    <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
        <!-- Billing Information -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Billing Information</h6>
            </div>
            <div class="flex-auto p-6 pt-0">
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                    <li class="relative flex justify-between p-6 mb-2 border-0 rounded-t-inherit rounded-xl bg-gray-50 border-l-solid">
                        <div class="flex flex-col">
                            <h6 class="mb-4 text-sm font-semibold leading-normal text-slate-700">Oliver Liam</h6>
                            <span class="mb-2 text-xs leading-tight">Company Name: <span class="font-semibold text-slate-700 sm:ml-2">Viking Burrito</span></span>
                            <span class="mb-2 text-xs leading-tight">Email Address: <span class="font-semibold text-slate-700 sm:ml-2">oliver@burrito.com</span></span>
                            <span class="text-xs leading-tight">VAT Number: <span class="font-semibold text-slate-700 sm:ml-2">FRB1235476</span></span>
                        </div>
                        <div class="flex flex-col items-end justify-start text-right">
                            <a class="inline-block px-0 py-2.5 mb-0 mr-4 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700" href="javascript:;">
                                <i class="mr-2 fas fa-trash text-slate-700" aria-hidden="true"></i>Delete
                            </a>
                            <a class="inline-block px-0 py-2.5 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700" href="javascript:;">
                                <i class="mr-2 fas fa-pencil-alt text-slate-700" aria-hidden="true"></i>Edit
                            </a>
                        </div>
                    </li>
                    <li class="relative flex justify-between p-6 mb-2 border-0 rounded-xl bg-gray-50 border-l-solid">
                        <div class="flex flex-col">
                            <h6 class="mb-4 text-sm font-semibold leading-normal text-slate-700">Lucas Harper</h6>
                            <span class="mb-2 text-xs leading-tight">Company Name: <span class="font-semibold text-slate-700 sm:ml-2">Stone Tech Zone</span></span>
                            <span class="mb-2 text-xs leading-tight">Email Address: <span class="font-semibold text-slate-700 sm:ml-2">lucas@stone-tech.com</span></span>
                            <span class="text-xs leading-tight">VAT Number: <span class="font-semibold text-slate-700 sm:ml-2">FRB1235476</span></span>
                        </div>
                        <div class="flex flex-col items-end justify-start text-right">
                            <a class="inline-block px-0 py-2.5 mb-0 mr-4 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700" href="javascript:;">
                                <i class="mr-2 fas fa-trash text-slate-700" aria-hidden="true"></i>Delete
                            </a>
                            <a class="inline-block px-0 py-2.5 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700" href="javascript:;">
                                <i class="mr-2 fas fa-pencil-alt text-slate-700" aria-hidden="true"></i>Edit
                            </a>
                        </div>
                    </li>
                    <li class="relative flex justify-between p-6 border-0 rounded-b-inherit rounded-xl bg-gray-50 border-l-solid">
                        <div class="flex flex-col">
                            <h6 class="mb-4 text-sm font-semibold leading-normal text-slate-700">Ethan James</h6>
                            <span class="mb-2 text-xs leading-tight">Company Name: <span class="font-semibold text-slate-700 sm:ml-2">Fiber Notion</span></span>
                            <span class="mb-2 text-xs leading-tight">Email Address: <span class="font-semibold text-slate-700 sm:ml-2">ethan@fiber.com</span></span>
                            <span class="text-xs leading-tight">VAT Number: <span class="font-semibold text-slate-700 sm:ml-2">FRB1235476</span></span>
                        </div>
                        <div class="flex flex-col items-end justify-start text-right">
                            <a class="inline-block px-0 py-2.5 mb-0 mr-4 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700" href="javascript:;">
                                <i class="mr-2 fas fa-trash text-slate-700" aria-hidden="true"></i>Delete
                            </a>
                            <a class="inline-block px-0 py-2.5 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700" href="javascript:;">
                                <i class="mr-2 fas fa-pencil-alt text-slate-700" aria-hidden="true"></i>Edit
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Your Transaction -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Your Transaction's</h6>
                <p class="text-sm leading-normal">
                    <i class="fa fa-arrow-up text-lime-500"></i>
                    <span class="font-semibold">23%</span> this month
                </p>
            </div>
            <div class="flex-auto p-6 pt-0">
                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Newest</h6>
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-inherit text-inherit rounded-xl">
                        <div class="flex items-center">
                            <button class="leading-pro ease-soft-in text-xs bg-150 w-6.35 h-6.35 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-red-600 border-transparent bg-transparent text-center align-middle font-bold uppercase text-red-600 transition-all hover:bg-transparent hover:text-red-600 hover:opacity-75 hover:shadow-none active:bg-red-600 active:text-white active:hover:bg-transparent active:hover:text-red-600">
                                <i class="fas fa-arrow-down" aria-hidden="true"></i>
                            </button>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal text-slate-700">Netflix</h6>
                                <span class="text-xs leading-tight">27 March 2020, at 12:30 PM</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-center text-right">
                            <p class="mb-1 text-sm leading-normal font-semibold text-slate-700">- $ 2,500</p>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex items-center">
                            <button class="leading-pro ease-soft-in text-xs bg-150 w-6.35 h-6.35 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:bg-transparent hover:text-lime-500 hover:opacity-75 hover:shadow-none active:bg-lime-500 active:text-white active:hover:bg-transparent active:hover:text-lime-500">
                                <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            </button>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal text-slate-700">Apple</h6>
                                <span class="text-xs leading-tight">27 March 2020, at 04:30 AM</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-center text-right">
                            <p class="mb-1 text-sm leading-normal font-semibold text-slate-700">+ $ 2,000</p>
                        </div>
                    </li>
                </ul>
                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Yesterday</h6>
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex items-center">
                            <button class="leading-pro ease-soft-in text-xs bg-150 w-6.35 h-6.35 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:bg-transparent hover:text-lime-500 hover:opacity-75 hover:shadow-none active:bg-lime-500 active:text-white active:hover:bg-transparent active:hover:text-lime-500">
                                <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            </button>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal text-slate-700">Stripe</h6>
                                <span class="text-xs leading-tight">26 March 2020, at 13:45 PM</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-center text-right">
                            <p class="mb-1 text-sm leading-normal font-semibold text-slate-700">+ $ 750</p>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex items-center">
                            <button class="leading-pro ease-soft-in text-xs bg-150 w-6.35 h-6.35 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:bg-transparent hover:text-lime-500 hover:opacity-75 hover:shadow-none active:bg-lime-500 active:text-white active:hover:bg-transparent active:hover:text-lime-500">
                                <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            </button>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal text-slate-700">HubSpot</h6>
                                <span class="text-xs leading-tight">26 March 2020, at 12:30 PM</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-center text-right">
                            <p class="mb-1 text-sm leading-normal font-semibold text-slate-700">+ $ 1,000</p>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 border-0 rounded-b-inherit rounded-xl text-inherit">
                        <div class="flex items-center">
                            <button class="leading-pro ease-soft-in text-xs bg-150 w-6.35 h-6.35 p-1.2 rounded-3.5xl tracking-tight-soft bg-x-25 mr-4 mb-0 flex cursor-pointer items-center justify-center border border-solid border-lime-500 border-transparent bg-transparent text-center align-middle font-bold uppercase text-lime-500 transition-all hover:bg-transparent hover:text-lime-500 hover:opacity-75 hover:shadow-none active:bg-lime-500 active:text-white active:hover:bg-transparent active:hover:text-lime-500">
                                <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            </button>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal text-slate-700">Creative Tim</h6>
                                <span class="text-xs leading-tight">26 March 2020, at 08:30 AM</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-center text-right">
                            <p class="mb-1 text-sm leading-normal font-semibold text-slate-700">+ $ 2,500</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
        <!-- Master Card -->
        <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py4 rounded-2xl bg-clip-border mb-6">
            <div class="relative overflow-hidden bg-cover rounded-2xl" style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}')">
                <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-80"></span>
                <div class="relative z-10 flex-auto p-4">
                    <i class="fas fa-wifi text-white p-2 text-xs"></i>
                    <h5 class="pb-2 mt-6 mb-12 text-white">4562&nbsp;&nbsp;&nbsp;1122&nbsp;&nbsp;&nbsp;4594&nbsp;&nbsp;&nbsp;7852</h5>
                    <div class="flex">
                        <div class="flex">
                            <div class="mr-6">
                                <p class="mb-0 text-white text-sm opacity-8">Card Holder</p>
                                <h6 class="mb-0 text-white">Jack Peterson</h6>
                            </div>
                            <div>
                                <p class="mb-0 text-white text-sm opacity-8">Expires</p>
                                <h6 class="mb-0 text-white">11/22</h6>
                            </div>
                        </div>
                        <div class="ml-auto w-1/5 flex justify-end">
                            <img class="w-60 mt-2" src="{{ asset('assets/img/logos/mastercard.png') }}" alt="logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Payment Method</h6>
            </div>
            <div class="flex-auto p-6 pt-0">
                <div class="flex items-center p-4 border border-solid rounded-lg border-gray-200">
                    <img class="w-10 mr-4" src="{{ asset('assets/img/logos/mastercard.png') }}" alt="mastercard">
                    <div class="flex flex-col">
                        <h6 class="mb-0 text-sm leading-normal">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;7852</h6>
                    </div>
                    <i class="fas fa-pencil-alt cursor-pointer text-slate-700 ml-auto" aria-hidden="true"></i>
                </div>
                <div class="flex items-center p-4 border border-solid rounded-lg border-gray-200 mt-4">
                    <img class="w-10 mr-4" src="{{ asset('assets/img/logos/visa.png') }}" alt="visa">
                    <div class="flex flex-col">
                        <h6 class="mb-0 text-sm leading-normal">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;5248</h6>
                    </div>
                    <i class="fas fa-pencil-alt cursor-pointer text-slate-700 ml-auto" aria-hidden="true"></i>
                </div>
            </div>
        </div>

        <!-- Invoices -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Invoices</h6>
            </div>
            <div class="flex-auto p-6 pt-0">
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-inherit text-inherit rounded-xl">
                        <div class="flex flex-col">
                            <h6 class="mb-1 text-sm font-semibold leading-normal text-slate-700">March, 01, 2020</h6>
                            <span class="text-xs leading-tight">#MS-415646</span>
                        </div>
                        <div class="flex items-center text-sm leading-normal">
                            $180
                            <button class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer text-sm ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700">
                                <i class="fas fa-file-pdf text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex flex-col">
                            <h6 class="mb-1 text-sm font-semibold leading-normal text-slate-700">February, 10, 2021</h6>
                            <span class="text-xs leading-tight">#RV-126749</span>
                        </div>
                        <div class="flex items-center text-sm leading-normal">
                            $250
                            <button class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer text-sm ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700">
                                <i class="fas fa-file-pdf text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex flex-col">
                            <h6 class="mb-1 text-sm font-semibold leading-normal text-slate-700">April, 05, 2020</h6>
                            <span class="text-xs leading-tight">#FB-212562</span>
                        </div>
                        <div class="flex items-center text-sm leading-normal">
                            $560
                            <button class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer text-sm ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700">
                                <i class="fas fa-file-pdf text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex flex-col">
                            <h6 class="mb-1 text-sm font-semibold leading-normal text-slate-700">June, 25, 2019</h6>
                            <span class="text-xs leading-tight">#QW-103578</span>
                        </div>
                        <div class="flex items-center text-sm leading-normal">
                            $120
                            <button class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer text-sm ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700">
                                <i class="fas fa-file-pdf text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="relative flex justify-between py-2 pr-4 border-0 rounded-b-inherit rounded-xl text-inherit">
                        <div class="flex flex-col">
                            <h6 class="mb-1 text-sm font-semibold leading-normal text-slate-700">March, 01, 2019</h6>
                            <span class="text-xs leading-tight">#AR-803481</span>
                        </div>
                        <div class="flex items-center text-sm leading-normal">
                            $300
                            <button class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer text-sm ease-soft-in bg-150 hover:scale-102 active:opacity-85 text-slate-700">
                                <i class="fas fa-file-pdf text-lg" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
