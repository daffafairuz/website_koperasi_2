<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        // Get all cooperative members
        $members = User::where('role', 'member')->orderBy('created_at', 'desc')->get();
        $totalMembers = $members->count();

        // Get activity logs with relationships
        $logs = ActivityLog::with(['admin', 'targetUser'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate dynamic real financial stats from database
        $totalSavings = User::where('role', 'member')->sum('simpanan_pokok') +
                         User::where('role', 'member')->sum('simpanan_wajib') +
                         User::where('role', 'member')->sum('simpanan_sukarela');

        $totalLoans = User::where('role', 'member')->sum('hutang');

        return view('admin.dashboard', compact('members', 'totalMembers', 'logs', 'totalSavings', 'totalLoans'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'member_number' => ['nullable', 'string', 'max:50', 'unique:users,member_number'],
            
            // Financial initial inputs
            'simpanan_pokok' => ['nullable', 'numeric', 'min:0'],
            'simpanan_wajib' => ['nullable', 'numeric', 'min:0'],
            'simpanan_sukarela' => ['nullable', 'numeric', 'min:0'],
            'hutang' => ['nullable', 'numeric', 'min:0'],
            'pokok_pinjaman' => ['nullable', 'numeric', 'min:0'],
            'monthly_payment' => ['nullable', 'numeric', 'min:0'],
            'jatuh_tempo_pinjaman' => ['nullable', 'date'],
        ]);

        // Auto-generate member number if not provided
        $memberNumber = $request->input('member_number');
        if (empty($memberNumber)) {
            $memberNumber = 'KOP-' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'member_number' => $memberNumber,
            'phone' => $request->phone,
            'address' => $request->address,
            'simpanan_pokok' => $request->simpanan_pokok ?? 0,
            'simpanan_wajib' => $request->simpanan_wajib ?? 0,
            'simpanan_sukarela' => $request->simpanan_sukarela ?? 0,
            'hutang' => $request->hutang ?? 0,
            'pokok_pinjaman' => $request->pokok_pinjaman ?? 0,
            'monthly_payment' => $request->monthly_payment ?? 0,
            'jatuh_tempo_pinjaman' => $request->jatuh_tempo_pinjaman,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Anggota baru dengan nomor ' . $memberNumber . ' berhasil ditambahkan!');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'member_number' => ['required', 'string', 'max:50', Rule::unique('users', 'member_number')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],

            // Financial fields
            'simpanan_pokok' => ['required', 'numeric', 'min:0'],
            'simpanan_wajib' => ['required', 'numeric', 'min:0'],
            'simpanan_sukarela' => ['required', 'numeric', 'min:0'],
            'hutang' => ['required', 'numeric', 'min:0'],
            'pokok_pinjaman' => ['required', 'numeric', 'min:0'],
            'monthly_payment' => ['required', 'numeric', 'min:0'],
            'jatuh_tempo_pinjaman' => ['nullable', 'date'],

            // Log parameters
            'notes' => ['nullable', 'string'],
            'proof_file' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg,gif,svg,pdf', 'max:4096'],
        ]);

        // Capture fields
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'member_number' => $request->member_number,
            'simpanan_pokok' => $request->simpanan_pokok,
            'simpanan_wajib' => $request->simpanan_wajib,
            'simpanan_sukarela' => $request->simpanan_sukarela,
            'hutang' => $request->hutang,
            'pokok_pinjaman' => $request->pokok_pinjaman,
            'monthly_payment' => $request->monthly_payment,
            'jatuh_tempo_pinjaman' => $request->jatuh_tempo_pinjaman,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Detect dirty changes
        $dirty = $user->getDirty();

        if (empty($dirty)) {
            return redirect()->route('admin.dashboard')->with('error', 'Tidak ada perubahan data yang dilakukan.');
        }

        $oldValues = [];
        $newValues = [];
        foreach ($dirty as $key => $newValue) {
            if ($key === 'password') {
                $oldValues[$key] = '[HIDDEN]';
                $newValues[$key] = '[UPDATED]';
                continue;
            }
            $oldValues[$key] = $user->getOriginal($key);
            $newValues[$key] = $newValue;
        }

        // Upload proof file
        $proofPath = null;
        if ($request->hasFile('proof_file')) {
            $proofPath = $request->file('proof_file')->store('proofs', 'public');
        }

        // Save
        $user->save();

        // Create log record
        ActivityLog::create([
            'user_id' => auth()->id(),
            'target_user_id' => $user->id,
            'action' => 'update_user',
            'changes' => [
                'old' => $oldValues,
                'new' => $newValues
            ],
            'proof_path' => $proofPath,
            'notes' => $request->notes ?? 'Pembaruan data profil/keuangan oleh Admin.',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Data anggota ' . $user->name . ' berhasil diperbarui dan didaftarkan di log!');
    }

    public function exportCsv()
    {
        $members = User::where('role', 'member')->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=koperasi_members_evaluation_" . date('Ymd_His') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'ID', 
            'Nama', 
            'Email', 
            'No. Anggota', 
            'No. Telepon', 
            'Alamat', 
            'Simpanan Pokok', 
            'Simpanan Wajib', 
            'Simpanan Sukarela', 
            'Total Simpanan', 
            'Sisa Hutang (Pinjaman)', 
            'Pokok Pinjaman', 
            'Angsuran per Bulan', 
            'Jatuh Tempo', 
            'Terdaftar Pada'
        ];

        $callback = function() use($members, $columns) {
            $file = fopen('php://output', 'w');

            // Add BOM for Microsoft Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, $columns);

            foreach ($members as $m) {
                $totalSavings = $m->simpanan_pokok + $m->simpanan_wajib + $m->simpanan_sukarela;
                fputcsv($file, [
                    $m->id,
                    $m->name,
                    $m->email,
                    $m->member_number,
                    $m->phone ?? '-',
                    $m->address ?? '-',
                    $m->simpanan_pokok,
                    $m->simpanan_wajib,
                    $m->simpanan_sukarela,
                    $totalSavings,
                    $m->hutang,
                    $m->pokok_pinjaman,
                    $m->monthly_payment,
                    $m->jatuh_tempo_pinjaman ? $m->jatuh_tempo_pinjaman->format('Y-m-d') : '-',
                    $m->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
