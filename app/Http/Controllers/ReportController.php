<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Cashout;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;

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

    public function getData($start, $end, $escape = false)
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

            $separate = '';
            if ($escape) $separate = ',-';

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['tanggal'] = tanggal_indonesia($start);
            $row['pemasukan'] = format_uang($donation + $cashout_fee) . $separate;
            $row['pengeluaran'] = format_uang($cashout_received) . $separate;
            $row['sisa'] = format_uang($sisa_kas) . $separate;
            
            array_push($data, $row);

            $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'pemasukan' => '',
            'pengeluaran' => ! $escape ? '<strong>Total Kas</strong>' : 'Total Kas',
            'sisa' => ! $escape ? '<strong>'. format_uang($total_sisa_kas) .'</strong>' : format_uang($total_sisa_kas) . $separate
        ];

        return $data;
    }

    public function data($start, $end)
    {
        $data = $this->getData($start, $end);

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }

    public function exportPDF($start, $end)
    {
        $data = $this->getData($start, $end);
        $pdf = PDF::loadView('report.pdf', compact('start', 'end', 'data'));
        
        return $pdf->stream('Laporan-penggalangan-dana-'. date('Y-m-d-his'). '.pdf');
    }

    public function exportExcel($start, $end)
    {
        $data = $this->getData($start, $end, true);
        $excel = new ReportExport($start, $end, $data);

        return Excel::download($excel, 'Laporan-penggalangan-dana-'. date('Y-m-d-his'). '.xlsx');
    }
}
