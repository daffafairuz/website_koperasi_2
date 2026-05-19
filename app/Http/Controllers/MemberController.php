<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        $member = Auth::user();

        // Fetch real values from the member's database columns
        $savings = [
            'pokok' => $member->simpanan_pokok,
            'wajib' => $member->simpanan_wajib,
            'sukarela' => $member->simpanan_sukarela,
            'total' => $member->simpanan_pokok + $member->simpanan_wajib + $member->simpanan_sukarela
        ];

        $loan = [
            'amount' => $member->pokok_pinjaman,
            'remaining' => $member->hutang,
            'due_date' => $member->jatuh_tempo_pinjaman ? $member->jatuh_tempo_pinjaman->format('Y-m-d') : date('Y-m-d', strtotime('+30 days')),
            'monthly_payment' => $member->monthly_payment
        ];

        return view('member.dashboard', compact('member', 'savings', 'loan'));
    }
}
