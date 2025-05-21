<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // PROFESI
        $profesi = DB::table('alumni')
            ->select('profesi', DB::raw('count(*) as total'))
            ->groupBy('profesi')
            ->orderByDesc('total')
            ->get();

        $topProfesi = $profesi->take(10);
        $sisa = $profesi->skip(10)->sum('total');

        $profesiLabels = $topProfesi->pluck('profesi')->toArray();
        $profesiData = $topProfesi->pluck('total')->toArray();
        if ($sisa > 0) {
            $profesiLabels[] = 'Lainnya';
            $profesiData[] = $sisa;
        }

        // INSTANSI
        $instansi = DB::table('instansi')
            ->select('jenis_instansi', DB::raw('count(*) as total'))
            ->groupBy('jenis_instansi')
            ->get();

        $instansiLabels = $instansi->pluck('jenis_instansi')->toArray();
        $instansiData = $instansi->pluck('total')->toArray();

        return view('admin.dashboard', compact(
            'profesiLabels',
            'profesiData',
            'instansiLabels',
            'instansiData'
        ));
        
    }
}
