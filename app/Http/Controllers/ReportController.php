<?php

namespace App\Http\Controllers;

use App\Models\Cashout;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = now()->subDays(30)->format('Y-m-d');
        $end = date('Y-m-d');

        if ($request->has('start') && $request->start != "" && $request->has('end') && $request->end != "") {
            $start = $request->start;
            $end = $request->end;
        }

        return view('report.index', compact('start', 'end'));
    }

    public function data($start, $end)
    {
        $data = [];
        $i = 1;
        $sisa_kas = 0;
        $total_sisa_kas = 0;

        while (strtotime($start) <= strtotime($end)) {
            $donation = Donation::whereHas('payment')
                ->where('status', 'confirmed')
                ->where('created_at', 'LIKE', "%$start%")
                ->sum('nominal');
            $cashout_received = Cashout::whereHas('campaign')
                ->where('status', 'success')
                ->where('created_at', 'LIKE', "%$start%")
                ->sum('amount_received');
            $cashout_fee = Cashout::whereHas('campaign')
                ->where('status', 'success')
                ->where('created_at', 'LIKE', "%$start%")
                ->sum('cashout_fee');

            $total = ($donation + $cashout_fee) - $cashout_received;
            $sisa_kas += $total;
            $total_sisa_kas += $total;

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['tanggal'] = tanggal_indonesia($start);
            $row['pemasukan'] = format_uang($donation + $cashout_fee);
            $row['pengeluaran'] = format_uang($cashout_received);
            $row['sisa'] = format_uang($sisa_kas);
            
            array_push($data, $row);

            $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'pemasukan' => '',
            'pengeluaran' => '<strong>Total Kas</strong>',
            'sisa' => '<strong>'. format_uang($total_sisa_kas) .'</strong>'
        ];

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }
}
