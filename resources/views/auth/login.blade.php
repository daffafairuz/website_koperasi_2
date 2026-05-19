@extends('layouts.app')

@section('title', 'Masuk ke Koperasi Digital')

@section('content')
<div class="min-h-[75vh] flex flex-col justify-center items-center py-6 px-4">
    <!-- Main Card -->
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden relative">
        <!-- Glowing Top Bar -->
        <div class="h-2 bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-500"></div>

        <div class="p-8 sm:p-10">
            <!-- Header Logo and Text -->
            <div class="text-center mb-8">
                <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-400 items-center justify-center shadow-lg shadow-emerald-500/20 text-white font-black text-2xl mb-4">
                    K
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Koperasi Digital</h2>
                <p class="text-sm text-slate-400 mt-1.5 font-medium">Selamat datang kembali! Silakan masuk ke akun Anda</p>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                        </span>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@email.com"
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-sm placeholder-slate-400 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-300">
                    </div>
                    @error('email')
                        <p class="text-rose-500 text-xs font-semibold mt-1.5 flex items-center space-x-1">
                            <span>* {{ $message }}</span>
                        </p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200/80 rounded-2xl text-sm placeholder-slate-400 focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all duration-300">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center space-x-2 text-slate-500 select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-emerald-500 border-slate-300 focus:ring-emerald-500">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-2xl text-sm font-bold shadow-lg shadow-emerald-500/25 hover:shadow-emerald-600/30 transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                    Masuk Sekarang
                </button>
            </form>
        </div>

        <!-- Quick Login Demo Panel -->
        <!-- <div class="bg-slate-50 border-t border-slate-100 p-6 flex flex-col space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 text-center">Akun Demo (Klik untuk mengisi)</span>
            <div class="grid grid-cols-2 gap-3" x-data="{}"> -->
                <!-- Admin Demo Btn -->
                <!-- <button @click="document.getElementById('email').value='admin@koperasi.com'; document.getElementById('password').value='admin123';"
                    class="py-2.5 px-3 bg-white hover:bg-emerald-50/50 border border-slate-200 hover:border-emerald-200 rounded-xl text-left text-xs font-medium transition-all duration-200 cursor-pointer">
                    <p class="font-bold text-slate-700">Admin/Pengurus</p>
                    <p class="text-slate-400 mt-0.5">admin@koperasi.com</p>
                </button> -->

                <!-- Member Demo Btn -->
                <!-- <button @click="document.getElementById('email').value='anggota@koperasi.com'; document.getElementById('password').value='anggota123';"
                    class="py-2.5 px-3 bg-white hover:bg-teal-50/50 border border-slate-200 hover:border-teal-200 rounded-xl text-left text-xs font-medium transition-all duration-200 cursor-pointer">
                    <p class="font-bold text-slate-700">Anggota</p>
                    <p class="text-slate-400 mt-0.5">anggota@koperasi.com</p>
                </button>
            </div>
        </div> -->
    </div>
</div>
@endsection
