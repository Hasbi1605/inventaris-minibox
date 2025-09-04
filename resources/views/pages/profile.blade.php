@extends('layouts.admin')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Platform Settings</h6>
            </div>
            <div class="flex-auto p-6">
                <p class="text-uppercase text-sm">Account</p>
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" checked="">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Email me when someone follows me</label>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault1">
                        <label class="form-check-label" for="flexSwitchCheckDefault1">Email me when someone answers on my post</label>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2" checked="">
                        <label class="form-check-label" for="flexSwitchCheckDefault2">Email me when someone mentions me</label>
                    </div>
                </div>
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Application</p>
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault3">
                        <label class="form-check-label" for="flexSwitchCheckDefault3">New launches and projects</label>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault4" checked="">
                        <label class="form-check-label" for="flexSwitchCheckDefault4">Monthly product updates</label>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault5">
                        <label class="form-check-label" for="flexSwitchCheckDefault5">Subscribe to newsletter</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Profile Information</h6>
            </div>
            <div class="flex-auto p-6">
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                        <div class="mb-4">
                            <label for="username" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Username</label>
                            <input type="text" name="username" value="lucky.jesse" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                        <div class="mb-4">
                            <label for="email" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Email address</label>
                            <input type="email" name="email" value="jesse@example.com" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                        <div class="mb-4">
                            <label for="first name" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">First name</label>
                            <input type="text" name="first name" value="Jesse" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-6/12 md:flex-0">
                        <div class="mb-4">
                            <label for="last name" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Last name</label>
                            <input type="text" name="last name" value="Lucky" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 shrink-0">
                        <div class="mb-4">
                            <label for="address" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Address</label>
                            <input type="text" name="address" value="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                        <div class="mb-4">
                            <label for="city" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">City</label>
                            <input type="text" name="city" value="New York" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                        <div class="mb-4">
                            <label for="country" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Country</label>
                            <input type="text" name="country" value="United States" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                    <div class="w-full max-w-full px-3 shrink-0 md:w-4/12 md:flex-0">
                        <div class="mb-4">
                            <label for="postal code" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Postal code</label>
                            <input type="text" name="postal code" value="437300" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow" />
                        </div>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full max-w-full px-3 shrink-0">
                        <div class="mb-4">
                            <label for="about me" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">About me</label>
                            <textarea name="about me" rows="5" class="focus:shadow-soft-primary-outline min-h-unset text-sm leading-5.6 ease-soft block h-auto w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">A beautiful Dashboard for Bootstrap 5. It is Free and Open Source.</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-wrap -mx-3">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6>Conversations</h6>
            </div>
            <div class="flex-auto p-6">
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                    <li class="relative block p-0 border-0 rounded-t-inherit text-inherit rounded-xl">
                        <div class="flex items-center p-6 border border-solid rounded-lg border-gray-200 mb-4">
                            <div class="flex">
                                <img src="{{ asset('assets/img/kal-visuals-square.jpg') }}" alt="kal" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl">
                            </div>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal">Sophie B.</h6>
                                <span class="text-xs leading-tight">Hi! I need more information..</span>
                            </div>
                            <div class="ml-auto">
                                <button class="inline-block px-6 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-slate-700 text-slate-700 hover:bg-transparent hover:text-slate-700 hover:opacity-75 hover:shadow-none active:bg-slate-700 active:text-white active:hover:bg-transparent active:hover:text-slate-700">Reply</button>
                            </div>
                        </div>
                    </li>
                    <li class="relative block p-0 border-0 text-inherit rounded-xl">
                        <div class="flex items-center p-6 border border-solid rounded-lg border-gray-200 mb-4">
                            <div class="flex">
                                <img src="{{ asset('assets/img/marie.jpg') }}" alt="marie" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl">
                            </div>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal">Anne Marie</h6>
                                <span class="text-xs leading-tight">Awesome work, can you..</span>
                            </div>
                            <div class="ml-auto">
                                <button class="inline-block px-6 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-slate-700 text-slate-700 hover:bg-transparent hover:text-slate-700 hover:opacity-75 hover:shadow-none active:bg-slate-700 active:text-white active:hover:bg-transparent active:hover:text-slate-700">Reply</button>
                            </div>
                        </div>
                    </li>
                    <li class="relative block p-0 border-0 text-inherit rounded-xl">
                        <div class="flex items-center p-6 border border-solid rounded-lg border-gray-200 mb-4">
                            <div class="flex">
                                <img src="{{ asset('assets/img/ivana-square.jpg') }}" alt="ivana" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl">
                            </div>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal">Ivanna</h6>
                                <span class="text-xs leading-tight">About files I can..</span>
                            </div>
                            <div class="ml-auto">
                                <button class="inline-block px-6 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-slate-700 text-slate-700 hover:bg-transparent hover:text-slate-700 hover:opacity-75 hover:shadow-none active:bg-slate-700 active:text-white active:hover:bg-transparent active:hover:text-slate-700">Reply</button>
                            </div>
                        </div>
                    </li>
                    <li class="relative block p-0 border-0 text-inherit rounded-xl">
                        <div class="flex items-center p-6 border border-solid rounded-lg border-gray-200 mb-4">
                            <div class="flex">
                                <img src="{{ asset('assets/img/team-4.jpg') }}" alt="peterson" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl">
                            </div>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal">Peterson</h6>
                                <span class="text-xs leading-tight">Have a great afternoon..</span>
                            </div>
                            <div class="ml-auto">
                                <button class="inline-block px-6 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-slate-700 text-slate-700 hover:bg-transparent hover:text-slate-700 hover:opacity-75 hover:shadow-none active:bg-slate-700 active:text-white active:hover:bg-transparent active:hover:text-slate-700">Reply</button>
                            </div>
                        </div>
                    </li>
                    <li class="relative block p-0 border-0 text-inherit rounded-xl">
                        <div class="flex items-center p-6 border border-solid rounded-lg border-gray-200">
                            <div class="flex">
                                <img src="{{ asset('assets/img/team-3.jpg') }}" alt="nick" class="inline-flex items-center justify-center mr-4 text-white transition-all duration-200 ease-soft-in-out text-sm h-9 w-9 rounded-xl">
                            </div>
                            <div class="flex flex-col">
                                <h6 class="mb-1 text-sm leading-normal">Nick Daniel</h6>
                                <span class="text-xs leading-tight">Hi! I need more information..</span>
                            </div>
                            <div class="ml-auto">
                                <button class="inline-block px-6 py-3 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro text-xs ease-soft-in bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-slate-700 text-slate-700 hover:bg-transparent hover:text-slate-700 hover:opacity-75 hover:shadow-none active:bg-slate-700 active:text-white active:hover:bg-transparent active:hover:text-slate-700">Reply</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-check {
    display: block;
    min-height: 1.5rem;
    padding-left: 1.5em;
    margin-bottom: 0.125rem;
}

.form-check .form-check-input {
    float: left;
    margin-left: -1.5em;
}

.form-check-input {
    width: 1em;
    height: 1em;
    margin-top: 0.25em;
    vertical-align: top;
    background-color: #fff;
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border: 1px solid rgba(0, 0, 0, 0.25);
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    print-color-adjust: exact;
}

.form-check-input[type="checkbox"] {
    border-radius: 0.25em;
}

.form-check-input:active {
    filter: brightness(90%);
}

.form-check-input:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.form-check-input:checked[type="checkbox"] {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
}

.form-check-input.form-check-input:focus:not(:checked) {
    border-color: #a6d2ff;
}

.form-check-input:disabled {
    pointer-events: none;
    filter: none;
    opacity: 0.5;
}

.form-check-input[disabled] ~ .form-check-label,
.form-check-input:disabled ~ .form-check-label {
    opacity: 0.5;
}

.form-switch {
    padding-left: 2.5em;
}

.form-switch .form-check-input {
    width: 2em;
    margin-left: -2.5em;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='rgba%280, 0, 0, 0.25%29'/%3e%3c/svg%3e");
    background-position: left center;
    border-radius: 2em;
    transition: background-position 0.15s ease-in-out;
}

.form-switch .form-check-input:focus {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23a6d2ff'/%3e%3c/svg%3e");
}

.form-switch .form-check-input:checked {
    background-position: right center;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
}

.form-check-label {
    color: #495057;
    cursor: pointer;
}

.horizontal.dark {
    background-color: rgba(0, 0, 0, 0.1);
    height: 1px;
    margin: 1rem 0;
    border: none;
}
</style>
@endpush
