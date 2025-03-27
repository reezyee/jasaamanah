@extends('layouts.auth')

@section('content')
<div class="flex items-center justify-center p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 w-full max-w-4xl bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        
        {{-- Image Column --}}
        <div class="hidden md:block relative">
            <img src="{{ asset('storage/building.webp') }}" alt="Login Background" class="absolute inset-0 w-full h-full object-cover opacity-70">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-900/50 to-blue-900/50"></div>
            <div class="relative left-5 top-5 bg-slate-50/50 w-fit rounded-full px-2 pb-1 flex items-center text-2xl text-white">
                <a href="{{ route('home')}}">
                    &leftarrow;
                </a>
            </div>
        </div>
        {{-- Login Form Column --}}
        <div class="flex items-center justify-center px-6 md:px-12 py-12">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Login to Your Account</h2>
                    <p class="text-gray-400">Welcome back! Please enter your details</p>
                </div>

                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="group">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('Email Address') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="pl-10 w-full px-3 py-3 border border-gray-700 rounded-lg bg-gray-700/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('email') border-red-500 @enderror"
                                value="{{ old('email') }}" autofocus placeholder="Enter your email">
                            
                            @error('email')
                            <p class="mt-2 text-sm text-red-400">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                    </div>

                    <div class="group">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('Password') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="pl-10 w-full px-3 py-3 border border-gray-700 rounded-lg bg-gray-700/50 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('password') border-red-500 @enderror"
                                placeholder="Enter your password">
                            
                            @error('password')
                            <p class="mt-2 text-sm text-red-400">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror

                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <button type="button" onclick="togglePassword()" class="text-gray-500 hover:text-gray-300 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" id="passwordEye" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 818 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
                                class="h-4 w-4 text-blue-600/50 focus:ring-blue-500 border-gray-500 rounded bg-gray-700 transition-colors duration-200"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 block text-sm text-gray-300">
                                {{ __('Remember Me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-blue-400 hover:text-blue-300 transition-colors duration-200">
                                {{ __('Forgot Password?') }}
                            </a>
                        </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="w-full py-3 px-4 rounded-lg text-white font-semibold bg-gradient-to-r from-blue-600/50 to-orange-600/50 hover:from-blue-700 hover:to-orange-700 transition-all duration-300 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            {{ __('Sign In') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordEye = document.getElementById('passwordEye');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordEye.innerHTML = '<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 00-2.79.588l.77.771A5.944 5.944 0 018 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0114.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" /><path d="M11.297 9.176a3.5 3.5 0 00-4.474-4.474l.823.823a2.5 2.5 0 012.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 01-4.474-4.474l.823.823a2.5 2.5 0 002.829 2.829z" /><path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 001.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 018 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709z" /><path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z" clip-rule="evenodd" />';
    } else {
        passwordInput.type = 'password';
        passwordEye.innerHTML = '<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 818 0z" clip-rule="evenodd" />';
    }
}
</script>
@endsection