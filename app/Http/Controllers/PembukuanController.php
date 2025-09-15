<?php

namespace App\Http\Controllers;

use App\Models\Pembukuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CategoryPembukuan;

class PembukuanController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Saldo (IN - OUT). jika null buat 0
        $saldo = DB::table('pembukuans')
            ->where('user_id', $userId)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'IN' THEN nominal ELSE 0 END),0) -
                COALESCE(SUM(CASE WHEN type = 'OUT' THEN nominal ELSE 0 END),0)
                as saldo
            ")
            ->value('saldo') ?? 0;

        // Ambil riwayat transaksi
        $riwayat = DB::table('pembukuans as p')
            ->where('p.user_id', $userId)
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
                        WHERE created_at <= p.created_at AND user_id = $userId) as saldo_saat_ini")
            )
            ->orderBy('p.created_at', 'asc') // urut dari paling lama ke baru
            ->get();

        // Ambil daftar unik tahun+bulan
        $bulanTahunRaw = DB::table('pembukuans')
            ->where('user_id', $userId)
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
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->value('created_at');

        $categoryPembukuans = CategoryPembukuan::all();

        return view('pembukuan', compact('saldo', 'riwayat', 'monthsByYear', 'lastUpdated','categoryPembukuans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'deskripsi' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'category_pembukuan_id' => 'required|exists:category_pembukuans,id',
            'type' => 'required|in:IN,OUT',
        ]);

        $validated['user_id'] = Auth::id();

        $pembukuan = Pembukuan::create($validated);

        // ambil relasi categoryPembukuan
        $pembukuan->load('categoryPembukuan');

        // kembalikan data baru untuk update front-end
        return response()->json([
            'success' => true,
            'message' => 'Pembukuan berhasil ditambahkan.',
            'transaction' => [
                'id' => $pembukuan->id,
                'deskripsi' => $pembukuan->deskripsi,
                'nominal' => $pembukuan->nominal,
                'type' => $pembukuan->type,
                'created_at' => $pembukuan->created_at,
                'saldo_saat_ini' => 0, // nanti dihitung di JS
                'category_pembukuan' => $pembukuan->categoryPembukuan->category_pembukuan ?? ''
            ]
        ]);
    }

    public function destroy($id)
    {
        $pembukuan = Pembukuan::find($id);

        if (!$pembukuan) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        $pembukuan->delete();

        $saldo = DB::table('pembukuans')
            ->selectRaw("
                COALESCE(SUM(CASE WHEN type = 'IN' THEN nominal ELSE 0 END),0) -
                COALESCE(SUM(CASE WHEN type = 'OUT' THEN nominal ELSE 0 END),0)
                as saldo
            ")
            ->value('saldo') ?? 0;

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus.',
            'saldo' => $saldo
        ]);
    }
}
