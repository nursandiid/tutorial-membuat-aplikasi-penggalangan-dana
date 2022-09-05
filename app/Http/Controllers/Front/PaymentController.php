<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\PaymentSuccess;
use App\Models\Bank;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index($id, $order_number)
    {
        $campaign = Campaign::findOrFail($id);
        $donation = Donation::where('order_number', $order_number)->first();
        $bank = Bank::all();
        
        if (! $donation) {
            abort(404);
        }

        return view('front.donation.payment', compact('campaign', 'donation', 'bank'));
    }

    public function paymentConfirmation($id, $order_number)
    {
        $campaign = Campaign::findOrFail($id);
        $donation = Donation::where('order_number', $order_number)->first();
        $payment  = Payment::where('order_number', $order_number)->first() ?? new Payment();
        $bank = Bank::all()->pluck('name', 'id');
        $mainAccount = $donation->user->mainAccount() ?? new Bank();

        if (! $donation || $donation->user_id != auth()->id()) {
            abort(404);
        }

        return view('front.donation.payment_confirmation', compact('campaign', 'donation', 'payment', 'bank', 'mainAccount'));
    }

    public function store(Request $request, $id, $order_number)
    {
        $payment  = Payment::where('order_number', $order_number)->first() ?? new Payment();

        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'nominal' => 'required|regex:/^[0-9.]+$/|min:4',
            'bank_id' => 'required|exists:bank,id',
            'path_image' => $payment ? 'nullable|mimes:png,jpg,jpeg,pdf|max:2048' : 'required|mimes:png,jpg,jpeg,pdf|max:2048',
            'note' => 'nullable'
        ], [
            'nominal.min' => 'Nominal minimal 1.000'
        ]);

        if ($validated->fails()) {
            return back()
                ->withInput()
                ->withErrors($validated->errors());
        }

        $campaign = Campaign::findOrFail($id);
        $donation = Donation::where('order_number', $order_number)->first();
        if (! $donation) {
            abort(404);
        }

        if ($donation->status == 'confirmed') {
            return back()
                ->with([
                    'message' => 'Pembayaran sudah dikonfirmasi',
                    'error_msg' => true,
                ]);
        }

        $data = $request->except('path_image', 'nominal');
        $data['user_id'] = $donation->user_id;
        $data['order_number'] = $donation->order_number;
        $data['nominal'] = str_replace('.', '', $request->nominal);
        
        if ($request->has('path_image')) {
            if (Storage::disk('public')->exists($payment->path_image)) {
                Storage::disk('public')->delete($payment->path_image);
            }

            $data['path_image'] = upload('payment', $request->file('path_image'), 'payment');
        }

        Payment::updateOrCreate(
            ['order_number' => $donation->order_number],
            $data
        );

        Mail::to($donation->user)->send(new PaymentSuccess($donation));

        return back()
            ->with([
                'message' => 'Konfirmasi pembayaran berhasil disimpan',
                'success' => true,
            ]);
    }
}
