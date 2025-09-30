<!-- sidenav -->
<aside id="sidenav-main" class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-all duration-300 xl:left-0 xl:translate-x-0 xl:bg-transparent sidebar-expanded">
    
    <div class="h-19.5 relative">
        <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        
        <!-- Logo and Title Container with dynamic toggle positioning -->
        <div class="px-8 py-6 pt-8 relative">
            <!-- Toggle Button - positioned dynamically based on sidebar state -->
            <div class="sidebar-toggle-container">
                <button id="sidebar-toggle" class="sidebar-toggle-btn flex h-6 w-6 items-center justify-center rounded-md bg-gray-50 hover:bg-gray-100 border border-gray-200 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" aria-label="Toggle sidebar">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="arrow-icon transition-transform duration-300">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <!-- Logo and title centered -->
            <div class="flex items-center justify-center pt-2">
                <a class="flex items-center text-sm whitespace-nowrap text-slate-700" href="{{ route('dashboard') }}">
                    <img src="{{ asset('assets/img/logos/logo-barber.png') }}" class="sidebar-logo-img h-8 w-8 transition-all duration-300 ease-nav-brand flex-shrink-0" alt="main_logo" />
                    <span class="sidebar-text ml-3 font-semibold transition-all duration-300 ease-nav-brand">Inventaris Barbershop</span>
                </a>
            </div>
        </div>
        
        <!-- Expand Button for Collapsed State -->
        <div id="expand-button" class="absolute -right-3 top-2 z-50 opacity-0 invisible transition-all duration-300">
            <button class="flex h-6 w-6 items-center justify-center rounded-md bg-white shadow-lg border border-gray-200 hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" aria-label="Expand sidebar">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

    <div class="items-center block w-auto h-full flex-1 flex flex-col">
        <ul class="flex flex-col pl-0 mb-0 flex-1 w-full">
            <!-- Dashboard -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('dashboard', 'home') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('dashboard') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('dashboard', 'home') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 45 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>shop</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1716.000000, -439.000000)" fill="{{ request()->routeIs('dashboard', 'home') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(0.000000, 148.000000)">
                                            <path d="M46.7199583,10.7414583 L40.8449583,0.949791667 C40.4909749,0.360605034 39.8540131,0 39.1666667,0 L7.83333333,0 C7.1459869,0 6.50902508,0.360605034 6.15504167,0.949791667 L0.280041667,10.7414583 C0.0969176761,11.0460037 -1.23209662e-05,11.3946378 -1.23209662e-05,11.75 C-0.00758042603,16.0663731 3.48367543,19.5725301 7.80004167,19.5833333 L7.81570833,19.5833333 C9.75003686,19.5882688 11.6168794,18.8726691 13.0522917,17.5760417 C16.0171492,20.2556967 20.5292675,20.2556967 23.494125,17.5760417 C26.4604562,20.2616016 30.9794188,20.2616016 33.94575,17.5760417 C36.2421905,19.6477597 39.5441143,20.1708521 42.3684437,18.9103691 C45.1927731,17.649886 47.0084685,14.8428276 47.0000295,11.75 C47.0000295,11.3946378 46.9030823,11.0460037 46.7199583,10.7414583 Z"></path>
                                            <path d="M39.198,22.4912623 C37.3776246,22.4928106 35.5817531,22.0149171 33.951625,21.0951667 L33.92225,21.1107282 C31.1430221,22.6838032 27.9255001,22.9318916 24.9844167,21.7998837 C24.4750389,21.605469 23.9777983,21.3722567 23.4960833,21.1018359 L23.4745417,21.1129513 C20.6961809,22.6871153 17.4786145,22.9344611 14.5386667,21.7998837 C14.029926,21.6054643 13.533337,21.3722507 13.0522917,21.1018359 C11.4250962,22.0190609 9.63246555,22.4947009 7.81570833,22.4912623 C7.16510551,22.4842162 6.51607673,22.4173045 5.875,22.2911849 L5.875,44.7220845 C5.875,45.9498589 6.7517757,46.9451667 7.83333333,46.9451667 L39.1666667,46.9451667 C40.2482243,46.9451667 41.125,45.9498589 41.125,44.7220845 L41.125,22.2822926 C40.4887822,22.4116582 39.8442868,22.4815492 39.198,22.4912623 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Dashboard</span>
                    <div class="sidebar-tooltip">Dashboard</div>
                </a>
            </li>

            <!-- Kelola Layanan -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-layanan.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-layanan.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-layanan.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>office</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1869.000000, -293.000000)" fill="{{ request()->routeIs('kelola-layanan.*') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g id="office" transform="translate(153.000000, 2.000000)">
                                            <path d="M12.25,17.5 L8.75,17.5 L8.75,1.75 C8.75,0.78225 9.53225,0 10.5,0 L31.5,0 C32.46775,0 33.25,0.78225 33.25,1.75 L33.25,12.25 L29.75,12.25 L29.75,3.5 L12.25,3.5 L12.25,17.5 Z"></path>
                                            <path d="M40.25,14 L24.5,14 C23.53225,14 22.75,14.78225 22.75,15.75 L22.75,26.25 L19.25,26.25 L19.25,22.75 L40.25,22.75 L40.25,14 Z"></path>
                                            <path d="M0,38.5 L0,33.25 L42,33.25 L42,38.5 L0,38.5 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Layanan</span>
                    <div class="sidebar-tooltip">Kelola Layanan</div>
                </a>
            </li>

            <!-- Kelola Transaksi -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-transaksi.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-transaksi.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-transaksi.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>credit-card</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2169.000000, -745.000000)" fill="{{ request()->routeIs('kelola-transaksi.*') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(453.000000, 454.000000)">
                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Transaksi</span>
                    <div class="sidebar-tooltip">Kelola Transaksi</div>
                </a>
            </li>

            <!-- Kelola Pengeluaran -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-pengeluaran.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-pengeluaran.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-pengeluaran.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>box-3d-50</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2319.000000, -291.000000)" fill="{{ request()->routeIs('kelola-pengeluaran.*') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(603.000000, 0.000000)">
                                            <path d="M22.7597136,19.3090182 L38.8987031,11.2395234 C39.3926816,10.9925342 39.592906,10.3918611 39.3459167,9.89788265 C39.249157,9.70436312 39.0922432,9.5474493 38.8987261,9.45068932 L20.2741875,0.1378125 L20.2741875,0.1378125 C19.905375,-0.04725 19.469625,-0.04725 19.0995,0.1378125 L3.1011696,8.13815822 C2.60720568,8.38517662 2.40701679,8.98586148 2.6540352,9.4798254 C2.75080129,9.67332903 2.90771305,9.83023153 3.10122239,9.9269862 L21.8652864,19.3090182 C22.1468139,19.4497819 22.4781861,19.4497819 22.7597136,19.3090182 Z"></path>
                                            <path d="M20.2741875,21.7715625 L20.2741875,39.9488125 C20.2741875,40.4973375 20.7256625,40.9488125 21.2741875,40.9488125 C21.4979855,40.9488125 21.7130356,40.8739431 21.8892462,40.7365463 L39.076,31.1885 C39.6269998,30.8994177 40.0014377,30.3251688 40.0000023,29.7040236 L40.0000023,13.2675 C40.0000023,12.7189751 39.5485273,12.2675 39.0000023,12.2675 C38.7762043,12.2675 38.5611542,12.3423693 38.3849436,12.4797661 L21.1946875,22.0270625 C20.7473125,22.2806875 20.5005,22.7650625 20.5005,23.2885 L20.2741875,21.7715625 Z"></path>
                                            <path d="M0.999997744,13.2675 L0.999997744,29.7040236 C0.998562226,30.3251688 1.37300008,30.8994177 1.92400003,31.1885 L19.1119998,40.7365463 C19.2882104,40.8739431 19.5032605,40.9488125 19.7270585,40.9488125 C20.2755835,40.9488125 20.7270585,40.4973375 20.7270585,39.9488125 L20.7270585,21.7715625 L20.5006459,23.2885 C20.5006459,22.7650625 20.2539334,22.2806875 19.8065584,22.0270625 L2.61615,12.4797661 C2.43989937,12.3423693 2.22485061,12.2675 2.00105263,12.2675 C1.45252766,12.2675 1.00105263,12.7189751 1.00105263,13.2675 L0.999997744,13.2675 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Pengeluaran</span>
                    <div class="sidebar-tooltip">Kelola Pengeluaran</div>
                </a>
            </li>

            <!-- Kelola Inventaris -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-inventaris.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-inventaris.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-inventaris.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 40 44" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>settings</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-2020.000000, -442.000000)" fill="{{ request()->routeIs('kelola-inventaris.*') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(304.000000, 151.000000)">
                                            <polygon class="color-background" opacity="0.596981957" points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667"></polygon>
                                            <path class="color-background" d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z"></path>
                                            <path class="color-background" d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Inventaris</span>
                    <div class="sidebar-tooltip">Kelola Inventaris</div>
                </a>
            </li>

            <!-- Kelola Cabang -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-cabang.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-cabang.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-cabang.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 46 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>customer-support</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1717.000000, -291.000000)" fill="{{ request()->routeIs('kelola-cabang.*') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(1.000000, 0.000000)">
                                            <path class="color-background opacity-60" d="M45,0 L26,0 C25.447,0 25,0.447 25,1 L25,20 C25,20.379 25.214,20.725 25.553,20.895 C25.694,20.965 25.848,21 26,21 C26.212,21 26.424,20.933 26.6,20.8 L34.333,15 L45,15 C45.553,15 46,14.553 46,14 L46,1 C46,0.447 45.553,0 45,0 Z"></path>
                                            <path class="color-background" d="M22.883,32.86 C20.761,32.012 17.324,31 13,31 C8.676,31 5.239,32.012 3.117,32.86 C1.224,33.619 0,35.438 0,37.494 L0,41 C0,41.553 0.447,42 1,42 L25,42 C25.553,42 26,41.553 26,41 L26,37.494 C26,35.438 24.776,33.619 22.883,32.86 Z"></path>
                                            <path class="color-background" d="M13,29 C17.432,29 21,25.432 21,21 C21,16.568 17.432,13 13,13 C8.568,13 5,16.568 5,21 C5,25.432 8.568,29 13,29 Z"></path>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Cabang</span>
                    <div class="sidebar-tooltip">Kelola Cabang</div>
                </a>
            </li>

            <!-- Kelola Kapster -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-kapster.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-kapster.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-kapster.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <i class="fas fa-user-tie text-sm {{ request()->routeIs('kelola-kapster.*') ? 'text-white' : 'text-slate-700' }}"></i>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Kapster</span>
                    <div class="sidebar-tooltip">Kelola Kapster</div>
                </a>
            </li>

            <!-- Kelola Kategori -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('kelola-kategori.*') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('kelola-kategori.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('kelola-kategori.*') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <i class="fas fa-tags text-sm {{ request()->routeIs('kelola-kategori.*') ? 'text-white' : 'text-slate-700' }}"></i>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Kelola Kategori</span>
                    <div class="sidebar-tooltip">Kelola Kategori</div>
                </a>
            </li>

            <!-- Laporan -->
            <li class="mt-0.5 w-full relative">
                <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 transition-all duration-200 {{ request()->routeIs('laporan') ? 'bg-white shadow-soft-xl font-semibold text-slate-700' : 'hover:bg-white/10' }}" href="{{ route('laporan') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5 {{ request()->routeIs('laporan') ? 'bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl' : 'bg-white' }}">
                        <svg width="12px" height="12px" viewBox="0 0 42 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <title>chart-bar-32</title>
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-1869.000000, -293.000000)" fill="{{ request()->routeIs('laporan') ? '#FFFFFF' : '#1f2937' }}" fill-rule="nonzero">
                                    <g transform="translate(1716.000000, 291.000000)">
                                        <g transform="translate(153.000000, 2.000000)">
                                            <path d="M6,9 L6,39 L36,39 L36,9 L6,9 Z M8,11 L34,11 L34,37 L8,37 L8,11 Z"></path>
                                            <rect x="10" y="16" width="4" height="17"></rect>
                                            <rect x="16" y="13" width="4" height="20"></rect>
                                            <rect x="22" y="19" width="4" height="14"></rect>
                                            <rect x="28" y="10" width="4" height="23"></rect>
                                        </g>
                                    </g>
                                </g>
                            </g>
                        </svg>
                    </div>
                    <span class="sidebar-text ml-1 duration-300 opacity-100 pointer-events-none ease-soft">Laporan</span>
                    <div class="sidebar-tooltip">Laporan</div>
                </a>
            </li>
        </ul>
    </div>

</aside>
