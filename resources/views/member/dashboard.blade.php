@extends('layouts.app')

@section('title', 'Portal Anggota Koperasi')

@section('content')
<div class="space-y-8">
    <!-- Top Member Header Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-teal-500 to-emerald-600 rounded-3xl text-white p-8 sm:p-10 shadow-xl shadow-emerald-500/10">
        <!-- Decorative glowing circles -->
        <div class="absolute top-0 right-0 w-72 h-72 bg-white/5 rounded-full blur-2xl -mr-16 -mt-16"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full blur-2xl -ml-16 -mb-16"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-100 bg-white/10 px-3 py-1 rounded-full border border-white/10">Portal Anggota</span>
                <h2 class="text-3xl font-extrabold tracking-tight mt-3">Halo, {{ $member->name }}!</h2>
                <p class="text-emerald-50 mt-1.5 text-sm font-medium tracking-wide">Selamat datang di sistem koperasi digital Anda. Semua data transaksi Anda tercatat dengan transparan.</p>
            </div>
            
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10 self-start md:self-auto text-right">
                <span class="text-[10px] text-emerald-200 font-bold uppercase tracking-wider block">Nomor Keanggotaan</span>
                <span class="text-lg font-mono font-bold tracking-widest mt-0.5 block">{{ $member->member_number }}</span>
            </div>
        </div>
    </div>

    <!-- Savings & Loans Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Savings Card (Col-span 2) -->
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Buku Simpanan Anda</h3>
                    <p class="text-xs text-slate-400 font-medium">Rincian saldo tabungan koperasi Anda</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Total Savings Banner -->
                <div class="bg-gradient-to-tr from-slate-900 to-slate-800 rounded-2xl p-6 text-white flex justify-between items-center shadow-lg shadow-slate-900/5">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Simpanan Terkumpul</p>
                        <h4 class="text-3xl font-black mt-1">Rp {{ number_format($savings['total'], 0, ',', '.') }}</h4>
                    </div>
                    <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Savings Breakdown -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Simpanan Pokok -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition-all duration-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Simpanan Pokok</span>
                        <span class="text-lg font-bold text-slate-800 mt-1 block">Rp {{ number_format($savings['pokok'], 0, ',', '.') }}</span>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Disetor sekali saat mendaftar</p>
                    </div>

                    <!-- Simpanan Wajib -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition-all duration-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Simpanan Wajib</span>
                        <span class="text-lg font-bold text-slate-800 mt-1 block">Rp {{ number_format($savings['wajib'], 0, ',', '.') }}</span>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Disetor setiap bulan</p>
                    </div>

                    <!-- Simpanan Sukarela -->
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-emerald-200 transition-all duration-200">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Simpanan Sukarela</span>
                        <span class="text-lg font-bold text-slate-800 mt-1 block">Rp {{ number_format($savings['sukarela'], 0, ',', '.') }}</span>
                        <p class="text-[10px] text-slate-400 mt-2 font-medium">Disetor bebas kapan saja</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loans Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Pinjaman Aktif</h3>
                    <p class="text-xs text-slate-400 font-medium">Pemantauan cicilan pinjaman Anda</p>
                </div>

                <!-- Loan details -->
                <div class="space-y-4">
                    <div class="p-4 rounded-2xl bg-rose-50/50 border border-rose-100">
                        <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-rose-500 mb-1">
                            <span>Sisa Pinjaman</span>
                            <span>Jatuh Tempo</span>
                        </div>
                        <div class="flex justify-between items-end">
                            <span class="text-xl font-bold text-slate-800">Rp {{ number_format($loan['remaining'], 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-600 bg-white border border-slate-200 px-2 py-0.5 rounded-lg">{{ date('d M Y', strtotime($loan['due_date'])) }}</span>
                        </div>
                    </div>

                    <!-- Details list -->
                    <div class="divide-y divide-slate-100 text-xs font-semibold text-slate-600">
                        <div class="py-2.5 flex justify-between">
                            <span class="text-slate-400">Total Pokok Pinjaman</span>
                            <span class="text-slate-700">Rp {{ number_format($loan['amount'], 0, ',', '.') }}</span>
                        </div>
                        <div class="py-2.5 flex justify-between">
                            <span class="text-slate-400">Angsuran Per Bulan</span>
                            <span class="text-slate-700">Rp {{ number_format($loan['monthly_payment'], 0, ',', '.') }} / bln</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pay helper btn -->
            <button onclick="alert('Fitur pembayaran online saat ini sedang terintegrasi dengan Payment Gateway bank.')"
                class="w-full mt-6 py-3.5 px-6 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-xs font-bold transition-colors cursor-pointer">
                Bayar Angsuran Sekarang
            </button>
        </div>
    </div>

    <!-- Personal Info Profile Grid -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-800">Informasi Pribadi & Kontak</h3>
            <p class="text-xs text-slate-400 font-medium">Data diri Anda yang terdaftar pada sistem pengurus</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Email -->
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Email Resmi</span>
                <p class="text-sm font-semibold text-slate-700">{{ $member->email }}</p>
            </div>

            <!-- Phone -->
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Nomor Telepon</span>
                <p class="text-sm font-semibold text-slate-700">{{ $member->phone ?? 'Belum dilengkapi' }}</p>
            </div>

            <!-- Address -->
            <div class="space-y-1">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Alamat Rumah</span>
                <p class="text-sm font-semibold text-slate-700">{{ $member->address ?? 'Belum dilengkapi' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
