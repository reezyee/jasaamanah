@extends('layouts.user')

@section('content')
    <div class="container mx-auto px-4 py-8 text-gray-200">
        @if (session('success'))
            <div id="toast-success"
                class="flex items-center w-full p-4 mb-6 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#toast-success" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="settings-tabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 cursor-pointer border-b-2 rounded-t-lg tab-button active" id="profile-tab-btn"
                        data-tab-target="profile-tab" type="button" role="tab" aria-selected="true">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile Settings
                    </button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 cursor-pointer border-b-2 border-transparent rounded-t-lg tab-button"
                        id="password-tab-btn" data-tab-target="password-tab" type="button" role="tab"
                        aria-selected="false">
                        <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Password Settings
                    </button>
                </li>
                @if ($user->role === 'admin')
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 cursor-pointer border-b-2 border-transparent rounded-t-lg tab-button"
                            id="website-tab-btn" data-tab-target="website-tab" type="button" role="tab"
                            aria-selected="false">
                            <svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                </path>
                            </svg>
                            Website Settings
                        </button>
                    </li>
                @endif
            </ul>
        </div>

        <!-- Content Panels -->
        <div class="tab-content-container">
            <!-- Profile Settings -->
            <div id="profile-tab" class="tab-content block">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Profile Settings</h3>


                    <form action="{{ route('settings.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex items-center space-x-4 mb-6">
                            <div class="relative">
                                <img id="avatar-preview"
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('storage/default-avatar.jpg') }}"
                                    class="w-24 h-24 object-cover rounded-full border-2 border-blue-500 dark:border-blue-400"
                                    alt="Profile picture">

                                <label for="avatar-upload"
                                    class="absolute bottom-0 right-0 bg-blue-500 dark:bg-blue-400 text-white rounded-full p-1 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </label>
                                <input id="avatar-upload" type="file" name="avatar" accept="image/*"
                                    class="hidden">
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800 dark:text-white">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="bg-gray-700 border border-gray-500 text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('name')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $user->email) }}"
                                    class="bg-gray-700 border border-gray-500 text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('email')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                <input type="text" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="bg-gray-700 border border-gray-500 text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('phone')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                <textarea id="address" name="address" rows="3"
                                    class="bg-gray-700 border border-gray-500 text-gray-200 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="text-sm text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <!-- Password Settings -->
            <div id="password-tab" class="tab-content hidden">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Change Password</h3>
                    <form action="{{ route('settings.updatePassword') }}" method="POST" id="password-form">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label for="current_password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <button type="button"
                                        class="password-toggle absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400"
                                        data-target="current_password">
                                        <svg class="w-5 h-5 password-toggle-hide" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 password-toggle-show hidden" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                @error('current_password')
                                    <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="new_password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <button type="button"
                                        class="password-toggle absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400"
                                        data-target="new_password">
                                        <svg class="w-5 h-5 password-toggle-hide" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 password-toggle-show hidden" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                @error('new_password')
                                    <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror

                                <!-- Password strength meter -->
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-1">
                                        <div id="password-strength-meter" class="h-2.5 rounded-full" style="width: 0%">
                                        </div>
                                    </div>
                                    <p id="password-strength-text" class="text-xs text-gray-500 dark:text-gray-400">
                                        Password strength: Enter a password</p>
                                </div>

                                <!-- Password requirements -->
                                <ul class="mt-2 text-xs space-y-1 text-gray-500 dark:text-gray-400">
                                    <li id="min-length" class="flex items-center">
                                        <span id="min-length-icon" class="mr-1">○</span>
                                        At least 8 characters
                                    </li>
                                    <li id="uppercase" class="flex items-center">
                                        <span id="uppercase-icon" class="mr-1">○</span>
                                        Contains uppercase letter
                                    </li>
                                    <li id="lowercase" class="flex items-center">
                                        <span id="lowercase-icon" class="mr-1">○</span>
                                        Contains lowercase letter
                                    </li>
                                    <li id="number" class="flex items-center">
                                        <span id="number-icon" class="mr-1">○</span>
                                        Contains number
                                    </li>
                                    <li id="special" class="flex items-center">
                                        <span id="special-icon" class="mr-1">○</span>
                                        Contains special character
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <label for="new_password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm New
                                    Password</label>
                                <div class="relative">
                                    <input type="password" id="new_password_confirmation"
                                        name="new_password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <button type="button"
                                        class="password-toggle absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 dark:text-gray-400"
                                        data-target="new_password_confirmation">
                                        <svg class="w-5 h-5 password-toggle-hide" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <svg class="w-5 h-5 password-toggle-show hidden" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                                <div id="password-match-message" class="mt-2 text-xs hidden"></div>
                            </div>
                        </div>

                        <button type="submit" id="submit-password"
                            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Change Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Website Settings (Admin Only) -->
            @if ($user->role === 'admin')
                <div id="website-tab" class="tab-content hidden">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                        <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Website Settings</h3>
                        <form action="{{ route('settings.updateWebsite') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="site_name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Website
                                        Name</label>
                                    <input type="text" id="site_name" name="site_name"
                                        value="{{ old('site_name', $settings['site_name'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @error('site_name')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact_email"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact
                                        Email</label>
                                    <input type="email" id="contact_email" name="contact_email"
                                        value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @error('contact_email')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact_phone"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact
                                        Phone</label>
                                    <input type="text" id="contact_phone" name="contact_phone"
                                        value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @error('contact_phone')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="contact_address"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact
                                        Address</label>
                                    <input type="text" id="contact_address" name="contact_address"
                                        value="{{ old('contact_address', $settings['contact_address'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @error('contact_address')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="about_us"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">About
                                        Us</label>
                                    <textarea id="about_us" name="about_us" rows="4"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('about_us', $settings['about_us'] ?? '') }}</textarea>
                                    @error('about_us')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="social_facebook"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Facebook</label>
                                    <input type="url" id="social_facebook" name="social_facebook"
                                        value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="social_instagram"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instagram</label>
                                    <input type="url" id="social_instagram" name="social_instagram"
                                        value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="social_twitter"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Twitter</label>
                                    <input type="url" id="social_twitter" name="social_twitter"
                                        value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Website
                                        Logo</label>
                                    <div class="flex items-center">
                                        @if (isset($settings['site_logo']))
                                            <img id="preview-image"
                                                src="{{ asset('storage/' . $settings['site_logo']) }}"
                                                class="w-16 h-16 mr-4 object-contain" alt="Website Logo">
                                        @else
                                            <img id="preview-image" class="w-16 h-16 mr-4 object-contain hidden"
                                                alt="Preview">
                                        @endif

                                        <div id="drop-area"
                                            class="flex items-center justify-center w-full p-2.5 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF
                                                </p>
                                            </div>
                                            <input id="site_logo" name="site_logo" type="file" class="hidden">
                                        </div>
                                    </div>
                                    @error('site_logo')
                                        <span class="text-sm text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Save
                                Website Settings</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab navigation functionality
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const target = this.dataset.tabTarget;

                    // Deactivate all tabs
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'border-blue-600', 'text-blue-600');
                        btn.classList.add('border-transparent', 'hover:text-gray-600',
                            'hover:border-gray-300');
                        btn.setAttribute('aria-selected', 'false');
                    });

                    // Hide all tab contents
                    tabContents.forEach(content => content.classList.add('hidden'));

                    // Activate clicked tab
                    this.classList.add('active', 'border-blue-600', 'text-blue-600');
                    this.classList.remove('border-transparent', 'hover:text-gray-600',
                        'hover:border-gray-300');
                    this.setAttribute('aria-selected', 'true');

                    // Show corresponding content
                    const targetContent = document.getElementById(target);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            // Avatar upload preview
            const avatarUpload = document.getElementById('avatar-upload');
            const avatarPreview = document.getElementById('avatar-preview');

            if (avatarUpload && avatarPreview) {
                avatarUpload.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Toast notification auto-dismiss
            const toast = document.getElementById('toast-success');
            if (toast) {
                setTimeout(() => toast.remove(), 5000);

                const closeButton = toast.querySelector('button');
                if (closeButton) {
                    closeButton.addEventListener('click', () => toast.remove());
                }
            }

            // Password visibility toggle
            const passwordToggles = document.querySelectorAll('.password-toggle');
            passwordToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const showIcon = this.querySelector('.password-toggle-show');
                    const hideIcon = this.querySelector('.password-toggle-hide');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        showIcon.classList.remove('hidden');
                        hideIcon.classList.add('hidden');
                    } else {
                        passwordInput.type = 'password';
                        showIcon.classList.add('hidden');
                        hideIcon.classList.remove('hidden');
                    }
                });
            });

            // Password strength meter
            const newPassword = document.getElementById('new_password');
            const strengthMeter = document.getElementById('password-strength-meter');
            const strengthText = document.getElementById('password-strength-text');
            const submitButton = document.getElementById('submit-password');

            // Password requirements elements
            const minLength = document.getElementById('min-length');
            const uppercase = document.getElementById('uppercase');
            const lowercase = document.getElementById('lowercase');
            const number = document.getElementById('number');
            const special = document.getElementById('special');

            // Icons
            const minLengthIcon = document.getElementById('min-length-icon');
            const uppercaseIcon = document.getElementById('uppercase-icon');
            const lowercaseIcon = document.getElementById('lowercase-icon');
            const numberIcon = document.getElementById('number-icon');
            const specialIcon = document.getElementById('special-icon');

            let requirements = {
                minLength: false,
                uppercase: false,
                lowercase: false,
                number: false,
                special: false
            };

            function updateRequirementStatus(element, icon, status) {
                if (status) {
                    element.classList.add('text-green-500');
                    element.classList.remove('text-gray-500', 'dark:text-gray-400');
                    icon.textContent = '✓';
                    icon.classList.add('text-green-500');
                } else {
                    element.classList.remove('text-green-500');
                    element.classList.add('text-gray-500', 'dark:text-gray-400');
                    icon.textContent = '○';
                    icon.classList.remove('text-green-500');
                }
            }

            function checkPasswordStrength(password) {
                // Update individual requirements
                requirements.minLength = password.length >= 8;
                requirements.uppercase = /[A-Z]/.test(password);
                requirements.lowercase = /[a-z]/.test(password);
                requirements.number = /[0-9]/.test(password);
                requirements.special = /[^A-Za-z0-9]/.test(password);

                updateRequirementStatus(minLength, minLengthIcon, requirements.minLength);
                updateRequirementStatus(uppercase, uppercaseIcon, requirements.uppercase);
                updateRequirementStatus(lowercase, lowercaseIcon, requirements.lowercase);
                updateRequirementStatus(number, numberIcon, requirements.number);
                updateRequirementStatus(special, specialIcon, requirements.special);

                // Calculate strength percentage based on requirements met
                const requirementsMet = Object.values(requirements).filter(Boolean).length;
                const strengthPercentage = (requirementsMet / 5) * 100;

                // Update meter
                strengthMeter.style.width = strengthPercentage + '%';

                // Set color based on strength
                if (strengthPercentage <= 20) {
                    strengthMeter.className = 'h-2.5 rounded-full bg-red-500';
                    strengthText.textContent = 'Password strength: Very weak';
                    strengthText.className = 'text-xs text-red-500';
                } else if (strengthPercentage <= 40) {
                    strengthMeter.className = 'h-2.5 rounded-full bg-orange-500';
                    strengthText.textContent = 'Password strength: Weak';
                    strengthText.className = 'text-xs text-orange-500';
                } else if (strengthPercentage <= 60) {
                    strengthMeter.className = 'h-2.5 rounded-full bg-yellow-500';
                    strengthText.textContent = 'Password strength: Fair';
                    strengthText.className = 'text-xs text-yellow-500';
                } else if (strengthPercentage <= 80) {
                    strengthMeter.className = 'h-2.5 rounded-full bg-blue-500';
                    strengthText.textContent = 'Password strength: Good';
                    strengthText.className = 'text-xs text-blue-500';
                } else {
                    strengthMeter.className = 'h-2.5 rounded-full bg-green-500';
                    strengthText.textContent = 'Password strength: Strong';
                    strengthText.className = 'text-xs text-green-500';
                }

                return requirementsMet >= 3; // At least 3 requirements must be met
            }

            // Check password match
            const confirmPassword = document.getElementById('new_password_confirmation');
            const matchMessage = document.getElementById('password-match-message');

            function checkPasswordMatch() {
                const password = newPassword.value;
                const confirmation = confirmPassword.value;

                if (confirmation.length === 0) {
                    matchMessage.classList.add('hidden');
                    return false;
                }

                matchMessage.classList.remove('hidden');

                if (password === confirmation) {
                    matchMessage.textContent = 'Passwords match';
                    matchMessage.className = 'mt-2 text-xs text-green-500';
                    return true;
                } else {
                    matchMessage.textContent = 'Passwords do not match';
                    matchMessage.className = 'mt-2 text-xs text-red-500';
                    return false;
                }
            }

            function updateSubmitButton() {
                const currentPassword = document.getElementById('current_password').value;
                const isStrong = checkPasswordStrength(newPassword.value);
                const isMatching = checkPasswordMatch();

                // Enable button only if all conditions are met
                submitButton.disabled = !(currentPassword.length > 0 && isStrong && isMatching);
            }

            // Event listeners
            newPassword.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                if (confirmPassword.value.length > 0) {
                    checkPasswordMatch();
                }
                updateSubmitButton();
            });

            confirmPassword.addEventListener('input', function() {
                checkPasswordMatch();
                updateSubmitButton();
            });

            document.getElementById('current_password').addEventListener('input', updateSubmitButton);

            // Form submission with animation
            const passwordForm = document.getElementById('password-form');
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;
                submitButton.disabled = true;

                // Submit the form after a short delay to show the animation
                setTimeout(() => {
                    this.submit();
                }, 800);
            });

            const dropArea = document.querySelector("#drop-area");
            const fileInput = document.querySelector("#site_logo");

            if (!dropArea || !fileInput) return;

            // Highlight drop area saat file di-drag
            dropArea.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropArea.classList.add("border-blue-500");
            });

            dropArea.addEventListener("dragleave", () => {
                dropArea.classList.remove("border-blue-500");
            });

            // Handle file drop
            dropArea.addEventListener("drop", (e) => {
                e.preventDefault();
                dropArea.classList.remove("border-blue-500");

                // Ambil file dari event drop
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files; // Masukkan file ke input
                    updatePreview(files[0]);
                }
            });

            // Update preview ketika file dipilih manual
            fileInput.addEventListener("change", function() {
                if (this.files.length > 0) {
                    updatePreview(this.files[0]);
                }
            });

            function updatePreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.querySelector("#preview-image");
                    if (previewImage) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove("hidden");
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
