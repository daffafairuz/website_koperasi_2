@extends('layouts.app')

@section('title', 'Dashboard Pengurus Koperasi')

@section('content')
<div class="space-y-8" x-data="{ openAddModal: false, openEditModal: false, activeUser: {} }">
    <!-- Global Validation Errors Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm transition-all duration-300">
            <div class="flex items-center space-x-3 mb-2">
                <div class="p-1 rounded-lg bg-rose-500 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <span class="text-sm font-bold">Gagal Menyimpan! Harap periksa beberapa kesalahan berikut:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 ml-9 font-medium text-rose-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Top Dashboard Banner / Stats -->
    <div class="relative overflow-hidden bg-slate-900 rounded-3xl text-white p-8 sm:p-10 shadow-xl shadow-slate-900/10">
        <!-- Background decorative elements -->
        <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-60 h-60 bg-teal-500/10 rounded-full blur-3xl -ml-20 -mb-20"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-emerald-400">Portal Pengurus (Admin)</span>
                <h2 class="text-3xl font-extrabold tracking-tight mt-2 sm:text-4xl">Selamat datang di Panel Koperasi</h2>
                <p class="text-slate-400 mt-2 text-sm sm:text-base max-w-xl">Kelola data profil anggota, edit simpanan & pinjaman secara offline, pantau log aktivitas perubahan, dan unduh laporan untuk evaluasi.</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <!-- Export CSV Button -->
                <a href="{{ route('admin.users.export-csv') }}" class="inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-700 text-slate-100 border border-slate-700 px-5 py-3 rounded-2xl text-sm font-bold shadow-md transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <span>Unduh Laporan CSV</span>
                </a>

                <!-- Add Member Button -->
                <button @click="openAddModal = true" class="inline-flex items-center space-x-2 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 px-5 py-3 rounded-2xl text-sm font-bold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-600/30 transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Anggota Baru</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Dynamic Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat 1 -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center space-x-5">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Anggota Aktif</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">{{ $totalMembers }} Orang</h3>
            </div>
        </div>

        <!-- Stat 2 -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center space-x-5">
            <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Simpanan Anggota</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">Rp {{ number_format($totalSavings, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Stat 3 -->
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center space-x-5">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-600 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Sisa Pinjaman Aktif</p>
                <h3 class="text-2xl font-black text-slate-800 mt-1">Rp {{ number_format($totalLoans, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Table View of Members -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Daftar Keuangan & Profil Anggota</h3>
                <p class="text-xs text-slate-400 font-medium">Klik aksi Kelola / Edit untuk merubah saldo keuangan offline atau detail profil</p>
            </div>
        </div>

        <!-- Responsive Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100">
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-400">Profil Anggota</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-400">Kontak & Alamat</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Total Simpanan</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-400 text-right">Sisa Hutang</th>
                        <th class="py-4 px-6 text-xs font-bold uppercase tracking-wider text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($members as $m)
                        @php
                            $mTotalSavings = $m->simpanan_pokok + $m->simpanan_wajib + $m->simpanan_sukarela;
                        @endphp
                        <tr class="hover:bg-slate-50/40 transition-colors duration-250">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-100 to-teal-50 flex items-center justify-center text-emerald-600 font-semibold text-sm">
                                        {{ substr($m->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $m->name }}</p>
                                        <p class="text-xs font-medium text-emerald-600 mt-0.5 tracking-wider">{{ $m->member_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-semibold text-slate-700">{{ $m->email }}</p>
                                <div class="flex items-center space-x-2 text-xs text-slate-400 mt-0.5">
                                    <span>{{ $m->phone ?? '-' }}</span>
                                    <span>•</span>
                                    <span class="max-w-[150px] truncate" title="{{ $m->address }}">{{ $m->address ?? '-' }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right font-semibold text-slate-800">
                                <div>Rp {{ number_format($mTotalSavings, 0, ',', '.') }}</div>
                                <div class="text-[10px] text-slate-400 font-normal">
                                    P: {{ number_format($m->simpanan_pokok/1000, 0) }}k | 
                                    W: {{ number_format($m->simpanan_wajib/1000, 0) }}k | 
                                    S: {{ number_format($m->simpanan_sukarela/1000, 0) }}k
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right font-semibold">
                                @if($m->hutang > 0)
                                    <span class="text-rose-600">Rp {{ number_format($m->hutang, 0, ',', '.') }}</span>
                                    <div class="text-[10px] text-slate-400 font-normal">Pokok: Rp {{ number_format($m->pokok_pinjaman/1000, 0) }}k</div>
                                @else
                                    <span class="text-slate-400 font-normal italic">Lunas</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center">
                                <button 
                                    @click="
                                        activeUser = {
                                            id: {{ $m->id }},
                                            name: '{{ addslashes($m->name) }}',
                                            email: '{{ $m->email }}',
                                            phone: '{{ $m->phone }}',
                                            address: '{{ addslashes($m->address) }}',
                                            member_number: '{{ $m->member_number }}',
                                            simpanan_pokok: {{ $m->simpanan_pokok }},
                                            simpanan_wajib: {{ $m->simpanan_wajib }},
                                            simpanan_sukarela: {{ $m->simpanan_sukarela }},
                                            hutang: {{ $m->hutang }},
                                            pokok_pinjaman: {{ $m->pokok_pinjaman }},
                                            monthly_payment: {{ $m->monthly_payment }},
                                            jatuh_tempo_pinjaman: '{{ $m->jatuh_tempo_pinjaman ? $m->jatuh_tempo_pinjaman->format('Y-m-d') : '' }}'
                                        };
                                        openEditModal = true;
                                    " 
                                    class="inline-flex items-center space-x-1.5 bg-slate-50 hover:bg-slate-100 text-slate-700 px-3 py-2 rounded-xl text-xs font-bold border border-slate-200 transition-all cursor-pointer"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>Kelola Keuangan</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center space-y-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="font-semibold text-sm">Belum ada anggota terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Audit Trail / Activity Logs Section -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-800">Log Aktivitas Admin & Riwayat Perubahan Keuangan</h3>
            <p class="text-xs text-slate-400 font-medium">Setiap perubahan saldo (misal: pembayaran cicilan, tambah simpanan) dicatat secara transparan dengan bukti transfer/bayar</p>
        </div>

        <div class="p-6">
            <div class="flow-root">
                <ul role="list" class="-mb-8">
                    @forelse($logs as $log)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-5 -ml-px h-full w-0.5 bg-slate-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-10 w-10 rounded-full flex items-center justify-center ring-8 ring-white bg-slate-100 text-slate-600 font-bold">
                                            @if($log->proof_path)
                                                💸
                                            @else
                                                ⚙️
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex-1 min-w-0 pt-1.5">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">
                                                    {{ $log->admin->name }} 
                                                    <span class="font-normal text-slate-500">merubah data</span> 
                                                    {{ $log->targetUser->name }}
                                                </p>
                                                <p class="text-xs text-slate-400 font-semibold mt-0.5">
                                                    {{ $log->created_at->format('d M Y, H:i') }} ({{ $log->created_at->diffForHumans() }})
                                                </p>
                                            </div>
                                            
                                            <!-- Download Proof Badge -->
                                            @if($log->proof_path)
                                                <a href="{{ asset('storage/' . $log->proof_path) }}" target="_blank" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-100 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    <span>Lihat Bukti Bayar</span>
                                                </a>
                                            @else
                                                <span class="text-xs font-bold text-slate-400 bg-slate-50 border border-slate-100 px-2 py-0.5 rounded-lg">Tanpa Bukti</span>
                                            @endif
                                        </div>

                                        <!-- Notes -->
                                        @if($log->notes)
                                            <div class="mt-2 text-xs text-slate-500 bg-slate-50/50 p-2.5 rounded-xl border border-slate-100">
                                                <span class="font-bold text-slate-700 block mb-0.5">Catatan Admin:</span>
                                                {{ $log->notes }}
                                            </div>
                                        @endif

                                        <!-- Changes Breakdown -->
                                        @if($log->changes)
                                            <div class="mt-3 overflow-x-auto">
                                                <table class="w-full text-xs text-left border border-slate-100 rounded-xl overflow-hidden">
                                                    <thead>
                                                        <tr class="bg-slate-50 text-slate-500 font-bold border-b border-slate-100">
                                                            <th class="py-1.5 px-3">Kolom</th>
                                                            <th class="py-1.5 px-3 text-right">Nilai Lama</th>
                                                            <th class="py-1.5 px-3 text-right">Nilai Baru</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-slate-100 font-mono text-[11px] text-slate-600">
                                                        @foreach($log->changes['new'] as $field => $newVal)
                                                            @php 
                                                                $oldVal = $log->changes['old'][$field] ?? '-';
                                                                
                                                                // Format nicely if it is currency
                                                                $currencyFields = ['simpanan_pokok', 'simpanan_wajib', 'simpanan_sukarela', 'hutang', 'pokok_pinjaman', 'monthly_payment'];
                                                                if(in_array($field, $currencyFields)) {
                                                                    $oldVal = 'Rp ' . number_format((float)$oldVal, 0, ',', '.');
                                                                    $newVal = 'Rp ' . number_format((float)$newVal, 0, ',', '.');
                                                                }
                                                                
                                                                // Replace field keys with pretty labels
                                                                $fieldLabels = [
                                                                    'name' => 'Nama',
                                                                    'email' => 'Email',
                                                                    'phone' => 'No. Telepon',
                                                                    'address' => 'Alamat',
                                                                    'member_number' => 'No. Anggota',
                                                                    'simpanan_pokok' => 'Simpanan Pokok',
                                                                    'simpanan_wajib' => 'Simpanan Wajib',
                                                                    'simpanan_sukarela' => 'Simpanan Sukarela',
                                                                    'hutang' => 'Sisa Hutang',
                                                                    'pokok_pinjaman' => 'Pokok Pinjaman',
                                                                    'monthly_payment' => 'Angsuran bulanan',
                                                                    'jatuh_tempo_pinjaman' => 'Jatuh Tempo',
                                                                ];
                                                                $fieldLabel = $fieldLabels[$field] ?? $field;
                                                            @endphp
                                                            <tr class="hover:bg-slate-50/50">
                                                                <td class="py-1.5 px-3 font-semibold text-slate-700">{{ $fieldLabel }}</td>
                                                                <td class="py-1.5 px-3 text-right text-rose-500">{{ $oldVal }}</td>
                                                                <td class="py-1.5 px-3 text-right text-emerald-600 font-bold">{{ $newVal }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-6 text-center text-slate-400 font-medium text-sm">
                            Belum ada riwayat aktivitas perubahan data.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Edit User & Finances Modal -->
    <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-3xl max-w-2xl w-full p-8 border border-slate-100 shadow-2xl relative max-h-[90vh] overflow-y-auto" @click.away="openEditModal = false">
            <button @click="openEditModal = false" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="mb-6">
                <span class="text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full border border-emerald-100">Keuangan & Profil</span>
                <h3 class="text-xl font-extrabold text-slate-800 mt-2">Kelola Data & Buku Keuangan</h3>
                <p class="text-xs text-slate-400 mt-1 font-medium">Formulir di bawah dapat merubah profil anggota dan saldo simpanan atau pinjaman.</p>
            </div>

            <!-- Dynamic Laravel Form -->
            <form :action="'{{ url('/admin/users') }}/' + activeUser.id" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Section 1: User Profile Details -->
                <div>
                    <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-3 flex items-center">
                        <span class="w-1.5 h-3 bg-emerald-500 rounded-full mr-2"></span>Profil Pribadi
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" required x-model="activeUser.name" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Alamat Email</label>
                            <input type="email" name="email" required x-model="activeUser.email" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">No. WhatsApp</label>
                            <input type="text" name="phone" x-model="activeUser.phone" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Nomor Anggota</label>
                            <input type="text" name="member_number" required x-model="activeUser.member_number" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Ganti Password <span class="text-[9px] text-slate-400 lowercase font-medium">(kosongkan jika tidak diganti)</span></label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                    <div class="mt-3">
                        <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Alamat Lengkap</label>
                        <textarea name="address" x-model="activeUser.address" rows="2" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500"></textarea>
                    </div>
                </div>

                <!-- Section 2: Savings (Simpanan) -->
                <div class="border-t border-slate-100 pt-5">
                    <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-3 flex items-center">
                        <span class="w-1.5 h-3 bg-teal-500 rounded-full mr-2"></span>Buku Tabungan / Simpanan (Rp)
                    </h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Simpanan Pokok</label>
                            <input type="number" name="simpanan_pokok" required x-model="activeUser.simpanan_pokok" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Simpanan Wajib</label>
                            <input type="number" name="simpanan_wajib" required x-model="activeUser.simpanan_wajib" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Simpanan Sukarela</label>
                            <input type="number" name="simpanan_sukarela" required x-model="activeUser.simpanan_sukarela" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Loans & Debts (Pinjaman & Hutang) -->
                <div class="border-t border-slate-100 pt-5">
                    <h4 class="text-xs font-black uppercase text-slate-400 tracking-wider mb-3 flex items-center">
                        <span class="w-1.5 h-3 bg-rose-500 rounded-full mr-2"></span>Buku Hutang / Pinjaman (Rp)
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-rose-500 mb-1">Sisa Hutang (Kurangi jika bayar)</label>
                            <input type="number" name="hutang" required x-model="activeUser.hutang" class="block w-full px-4 py-2.5 bg-rose-50 border border-rose-200 text-rose-700 font-bold rounded-xl text-sm focus:outline-none focus:bg-white focus:border-rose-500">
                            <span class="text-[9px] text-slate-400 font-medium mt-1 block">Kurangi nominal di atas jika anggota membayar angsuran.</span>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Pokok Pinjaman Awal</label>
                            <input type="number" name="pokok_pinjaman" required x-model="activeUser.pokok_pinjaman" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Angsuran per Bulan</label>
                            <input type="number" name="monthly_payment" required x-model="activeUser.monthly_payment" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Jatuh Tempo</label>
                            <input type="date" name="jatuh_tempo_pinjaman" x-model="activeUser.jatuh_tempo_pinjaman" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- Section 4: Log documentation & Upload Proof -->
                <div class="border-t border-slate-100 pt-5 bg-slate-50 -mx-8 px-8 py-5 rounded-b-3xl">
                    <h4 class="text-xs font-black uppercase text-slate-700 tracking-wider mb-3 flex items-center">
                        <span class="w-1.5 h-3 bg-amber-500 rounded-full mr-2"></span>Bukti Transaksi & Catatan Audit (Wajib / Sangat Disarankan)
                    </h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Proof File upload -->
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Upload Bukti Bayar / Transfer</label>
                            <input type="file" name="proof_file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-200 rounded-xl p-1.5 bg-white">
                            <span class="text-[9px] text-slate-400 font-medium mt-1 block">Mendukung gambar (JPG, PNG) atau file PDF. Maksimal 4 MB.</span>
                        </div>

                        <!-- Admin note -->
                        <div>
                            <label class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Catatan Log / Keterangan</label>
                            <textarea name="notes" placeholder="Contoh: Mengurangi hutang Rp 500.000 karena cicilan ke-2 dibayar via bank Mandiri." rows="2" class="block w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs placeholder-slate-400 focus:outline-none focus:border-emerald-500"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 pt-2">
                    <button type="button" @click="openEditModal = false" class="w-1/2 py-3 border border-slate-200 hover:bg-slate-50 rounded-xl text-sm font-bold text-slate-500 transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="w-1/2 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 transition-all cursor-pointer">Simpan Perubahan & Catat Log</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form: Add Anggota Koperasi -->
    <div x-show="openAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div class="bg-white rounded-3xl max-w-lg w-full p-8 border border-slate-100 shadow-2xl relative max-h-[90vh] overflow-y-auto" @click.away="openAddModal = false">
            <button @click="openAddModal = false" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="mb-6">
                <h3 class="text-xl font-extrabold text-slate-800">Tambah Anggota Koperasi Baru</h3>
                <p class="text-sm text-slate-400 mt-1 font-medium">Buat akun untuk didaftarkan sebagai anggota resmi koperasi</p>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Alamat Email</label>
                        <input type="email" name="email" required class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">No. HP / WA</label>
                        <input type="text" name="phone" placeholder="08xxxxxxxxxx" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">No. Anggota (Opsional)</label>
                        <input type="text" name="member_number" placeholder="KOP-XXXX" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Simpanan Pokok (Rp)</label>
                        <input type="number" name="simpanan_pokok" value="0" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Simpanan Wajib (Rp)</label>
                        <input type="number" name="simpanan_wajib" value="0" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Simpanan Sukarela (Rp)</label>
                        <input type="number" name="simpanan_sukarela" value="0" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Kata Sandi Akun</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-1">Alamat Lengkap</label>
                    <textarea name="address" rows="2" class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500"></textarea>
                </div>

                <div class="flex items-center space-x-3 pt-4">
                    <button type="button" @click="openAddModal = false" class="w-1/2 py-3 border border-slate-200 hover:bg-slate-50 rounded-xl text-sm font-bold text-slate-500 transition-colors cursor-pointer">Batal</button>
                    <button type="submit" class="w-1/2 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 transition-all cursor-pointer">Daftarkan Anggota</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
