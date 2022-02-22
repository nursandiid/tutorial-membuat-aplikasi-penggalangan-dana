<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function data()
    {
        $query = [];

        for ($i = 1; $i <= (int) 31; $i++) { 
            $row = [];
            $row['DT_RowIndex'] = $i;
            $row['tanggal'] = tanggal_indonesia(date('Y-m-'. $i));
            $row['keterangan'] = Str::random(10);
            $row['pemasukan'] = format_uang(mt_rand(11111, 999999));
            $row['pengeluaran'] = format_uang(mt_rand(11111, 999999));
            $row['sisa'] = format_uang(mt_rand(11111, 999999));

            array_push($query, $row);
        }

        $query[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'keterangan' => '',
            'pemasukan' => '',
            'pengeluaran' => '<strong>Total Kas</strong>',
            'sisa' => '<strong>'. format_uang(mt_rand(11111, 99999999)) .'</strong>'
        ];

        return datatables($query)
            ->escapeColumns([])
            ->make(true);
    }
}
