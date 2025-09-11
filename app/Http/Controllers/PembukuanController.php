<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembukuanController extends Controller
{
    public function index(Request $request)
    {
        // Saldo (IN - OUT). jika null buat 0
        $saldo = DB::table('pembukuans')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'IN' THEN nominal ELSE 0 END),0) -
                COALESCE(SUM(CASE WHEN type = 'OUT' THEN nominal ELSE 0 END),0)
                as saldo
            ")
            ->value('saldo') ?? 0;

        // Ambil riwayat transaksi
        $riwayat = DB::table('pembukuans as p')
            ->leftJoin('category_pembukuans as c', 'p.category_pembukuan_id', '=', 'c.id')
            ->select(
                'p.id',
                'p.type',
                'p.nominal',
                'p.user_id',
                'p.deskripsi',
                'p.created_at',
                'c.category_pembukuan',
                // hitung saldo kumulatif sampai transaksi ini
                DB::raw("(SELECT COALESCE(SUM(CASE WHEN type='IN' THEN nominal ELSE -nominal END),0)
                        FROM pembukuans
                        WHERE created_at <= p.created_at) as saldo_saat_ini")
            )
            ->orderBy('p.created_at', 'asc') // urut dari paling lama ke baru
            ->get();


        // Ambil daftar unik tahun+bulan
        $bulanTahunRaw = DB::table('pembukuans')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        $monthsByYear = $bulanTahunRaw
            ->groupBy('year')
            ->map(function ($items) {
                return $items->pluck('month')->unique()->values();
            });

        // Ambil transaksi terakhir (untuk last updated saldo)
        $lastUpdated = DB::table('pembukuans')
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        return view('pembukuan', compact('saldo', 'riwayat', 'monthsByYear', 'lastUpdated'));
    }
}
