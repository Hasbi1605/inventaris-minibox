@extends('layouts.admin')

@section('title', 'Virtual Reality')
@section('page-title', 'Virtual Reality')

@section('content')
<div class="min-h-screen bg-cover bg-center relative" style="background-image: url('{{ asset('assets/img/vr-bg.jpg') }}')">
    <span class="absolute top-0 left-0 w-full h-full bg-center bg-cover bg-gradient-to-tl from-gray-900 to-slate-800 opacity-60"></span>
    
    <div class="relative z-10">
        <!-- Top Section -->
        <div class="flex flex-wrap -mx-3 mb-6">
            <div class="w-full max-w-full px-3 mx-auto mt-0 text-center lg:flex-0 shrink-0 lg:w-5/12">
                <h1 class="text-white mt-12 mb-2 text-5xl font-bold">Soft UI</h1>
                <p class="text-white">Feel the experience of using a VR headset, you can easily incorporate this type of language into the theme.</p>
            </div>
        </div>

        <!-- VR Boxes Grid -->
        <div class="flex flex-wrap -mx-3">
            <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap -mx-3">
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                                <div class="flex flex-col h-full">
                                    <p class="pt-2 mb-1 font-semibold text-gradient bg-gradient-to-tl from-blue-600 to-cyan-400 bg-clip-text">Freelancers</p>
                                    <h5 class="font-weight-bolder">1,400</h5>
                                    <p class="mb-0">
                                        <span class="text-sm font-weight-bolder text-success">+55%</span>
                                        since yesterday
                                    </p>
                                </div>
                            </div>
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none lg:text-right">
                                <div class="inline-block w-12 h-12 text-center bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg">
                                    <i class="ni ni-world text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap -mx-3">
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                                <div class="flex flex-col h-full">
                                    <p class="pt-2 mb-1 font-semibold text-gradient bg-gradient-to-tl from-red-600 to-rose-400 bg-clip-text">Click Events</p>
                                    <h5 class="font-weight-bolder">2,400</h5>
                                    <p class="mb-0">
                                        <span class="text-sm font-weight-bolder text-success">+124%</span>
                                        since last week
                                    </p>
                                </div>
                            </div>
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none lg:text-right">
                                <div class="inline-block w-12 h-12 text-center bg-gradient-to-tl from-red-600 to-rose-400 rounded-lg">
                                    <i class="ni ni-favourite-28 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <div class="flex flex-wrap -mx-3">
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                                <div class="flex flex-col h-full">
                                    <p class="pt-2 mb-1 font-semibold text-gradient bg-gradient-to-tl from-green-600 to-lime-400 bg-clip-text">Purchases</p>
                                    <h5 class="font-weight-bolder">2400</h5>
                                    <p class="mb-0">
                                        <span class="text-sm font-weight-bolder text-danger">-12%</span>
                                        since last month
                                    </p>
                                </div>
                            </div>
                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none lg:text-right">
                                <div class="inline-block w-12 h-12 text-center bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center VR Content -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 mx-auto mt-4 sm:my-auto sm:mb-0 text-center lg:flex-0 shrink-0 lg:w-6/12">
                <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none lg:py4 rounded-2xl bg-clip-border">
                    <div class="p-6 text-center">
                        <h2 class="text-white mb-0">Feel the Experience</h2>
                        <p class="lead text-white opacity-8">A fully immersive VR experience that will transport you to another world.</p>
                        <img src="{{ asset('assets/img/illustrations/vr-glasses.png') }}" alt="vr-glasses" class="max-w-full h-auto mx-auto mb-6">
                        <button type="button" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25">
                            Start Experience
                        </button>
                        <button type="button" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 leading-pro text-xs ease-soft-in tracking-tight-soft bg-150 bg-x-25 border-white hover:bg-transparent hover:text-white hover:shadow-none">
                            Read More
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="flex flex-wrap mt-6 -mx-3">
            <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 mt-6 break-words border-0 shadow-none lg:py4 rounded-2xl bg-clip-border">
                    <div class="p-6 text-center">
                        <div class="inline-block w-16 h-16 mb-4 text-center bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg">
                            <i class="ni ni-app text-2xl relative top-4 text-white"></i>
                        </div>
                        <h5 class="text-white">Desktop</h5>
                        <p class="text-white opacity-8">A modern approach for Desktop with lots of beautiful elements</p>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 mt-6 break-words border-0 shadow-none lg:py4 rounded-2xl bg-clip-border">
                    <div class="p-6 text-center">
                        <div class="inline-block w-16 h-16 mb-4 text-center bg-gradient-to-tl from-red-600 to-rose-400 rounded-lg">
                            <i class="ni ni-mobile-button text-2xl relative top-4 text-white"></i>
                        </div>
                        <h5 class="text-white">Mobile</h5>
                        <p class="text-white opacity-8">Newest mobile interface with many options and a beautiful design</p>
                    </div>
                </div>
            </div>
            <div class="w-full max-w-full px-3 lg:w-4/12 lg:flex-none">
                <div class="relative flex flex-col min-w-0 mt-6 break-words border-0 shadow-none lg:py4 rounded-2xl bg-clip-border">
                    <div class="p-6 text-center">
                        <div class="inline-block w-16 h-16 mb-4 text-center bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg">
                            <i class="ni ni-satisfied text-2xl relative top-4 text-white"></i>
                        </div>
                        <h5 class="text-white">VR/AR</h5>
                        <p class="text-white opacity-8">Cutting edge technology for an immersive user experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .min-h-screen {
        min-height: 100vh;
    }
    .text-gradient {
        background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .bg-gradient-to-tl {
        background-image: linear-gradient(to top left, var(--tw-gradient-stops));
    }
    .from-blue-600 {
        --tw-gradient-from: #2563eb;
    }
    .to-cyan-400 {
        --tw-gradient-to: #22d3ee;
    }
</style>
@endpush
