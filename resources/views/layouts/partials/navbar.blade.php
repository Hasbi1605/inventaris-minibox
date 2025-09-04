<!-- Navbar -->
<nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
    <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
        <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                <li class="text-sm leading-normal">
                    <a class="opacity-50 text-slate-700" href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">
                    @yield('page-title', 'Dashboard')
                </li>
            </ol>
            <h6 class="mb-0 font-bold capitalize">@yield('page-title', 'Dashboard')</h6>
        </nav>

        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">
                <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease-soft">
                    <span class="text-sm ease-soft leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="pl-8.75 text-sm focus:shadow-soft-primary-outline ease-soft w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" placeholder="Cari..." />
                </div>
            </div>
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                <!-- Notifications -->
                <li class="flex items-center px-4">
                    <a href="#" class="ease-nav-brand text-sm font-semibold leading-normal transition-all duration-250">
                        <i class="fa fa-bell cursor-pointer text-slate-500"></i>
                    </a>
                </li>
                <!-- Profile -->
                <li class="flex items-center">
                    <a href="#" class="ease-nav-brand text-sm font-semibold leading-normal transition-all duration-250">
                        <i class="fa fa-user cursor-pointer text-slate-500"></i>
                    </a>
                </li>
                <!-- Mobile menu button -->
                <li class="flex items-center xl:hidden">
                    <a href="#" class="ease-nav-brand text-sm font-semibold leading-normal transition-all duration-250" sidenav-trigger>
                        <i class="fa fa-bars cursor-pointer text-slate-500"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
