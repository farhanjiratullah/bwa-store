<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Cart;
use App\Transaction;
use App\TransactionDetail;

use Exception;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request) {
        // Save user data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Process checkout
        $code = 'STORE-' . mt_rand(000000, 999999);
        $carts = Cart::with(['product', 'user'])->where('users_id', Auth::user()->id)->get();

        // Transaction create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => (int) $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(000000, 999999);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }

        // Delete cart data
        Cart::where('users_id', Auth::user()->id)->delete();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => [
                'gopay', 'permata_va', 'bank_transfer'
            ],
            'vtweb' => []
        ];

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch( Exception $e ) {
            $e->getMessage();
        }
    }

    public function callback(Request $request) {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Instance midtrans notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::find($order_id);

        // Handle notification status
        if( $status == 'capture' ) {
            if( $type == 'credit_card' ) {
                if( $fraud == 'challenge' ) {
                    $transaction->transaction_status = 'PENDING';
                } else {
                    $transaction->transaction_status = 'SUCCESS';
                }
            }
        } else if( $status == 'settlement' ) {
            $transaction->transaction_status = 'SUCCESS';
        } else if( $status == 'pending' ) {
            $transaction->transaction_status = 'PENDING';
        } else if( $status == 'deny' ) {
            $transaction->transaction_status = 'FAILED';
        } else if( $status == 'expire' ) {
            $transaction->transaction_status = 'FAILED';
        } else if( $status == 'cancel' ) {
            $transaction->transaction_status = 'FAILED';
        }

        // Simpan transaksi
        $transaction->save();
    }
}
