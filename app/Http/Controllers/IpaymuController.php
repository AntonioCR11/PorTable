<?php

namespace App\Http\Controllers;

use App\Models\Migrasi\reservationMigrasi;
use App\Models\Migrasi\restaurantMigrasi;
use App\Models\Migrasi\transactionMigrasi;
use Illuminate\Http\Request;

class IpaymuController extends Controller
{
    public function notify(Request $request)
    {
        // $id = $request->trx_id;
        $reservation = reservationMigrasi::where('session_id','=',$request->sid)->first();
        $restaurant = restaurantMigrasi::find($reservation->restaurant_id);
        // return json_encode($reservation);
        if($reservation->payment_status == 0){
            if($request->status_code == 1){

                $reservation->payment_status = $request->status_code;
                $reservation->save();
                $transaction = new transactionMigrasi();
                $transaction->user_id = $reservation->user_id;
                $transaction->restaurant_id = $reservation->restaurant_id;
                $transaction->reservation_id = $reservation->id;
                $transaction->payment_amount = $restaurant->price;
                $transaction->payment_date_at = now();
                $transaction->save();
                return 'Payment Success and noted at Transaction';
            }
            else{
                $reservation->payment_status = $request->status_code;
                $reservation->save();
                return 'Payment Not Success and not noted at Transaction';
            }
        }
        else{
            return "Already paid off can't pay again";
        }

    }
    private function generateSignature($body = [], $method = 'POST')
    {
        $va = env('IPAYMU_VA');
        $secret = env('IPAYMU_KEY');
        $method = strtoupper($method);

        $jsonBody = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody = strtolower(hash('sha256', $jsonBody));
        $stringToSign = "$method:$va:$requestBody:$secret";
        return hash_hmac('sha256', $stringToSign, $secret);
    }
    public function serveTable(Request $request)
    {
        $request->validate([
            'table_number'=>'required',
            'reservation_date'=>'required',
            'reservation_time'=>'required'
        ]);
        // BOOK TABLE
        $user = activeUser();
        $id = $request->restaurant_id;

        $restaurant = restaurantMigrasi::find($id);
        // dd($restaurant->full_name);
        $table_number = $request->table_number;
        $reservation_date = $request->reservation_date;
        $reservation_time = $request->reservation_time;
        //Request Body//
        $body['product']    = array($restaurant->full_name);
        $body['qty']        = array('1');
        $body['price']      = array($restaurant->price);
        $body['returnUrl']  = 'http://localhost:8000/customer/explore';
        $body['cancelUrl']  = 'http://localhost:8000/customer/explore';
        $body['notifyUrl']  = 'https://9909-158-140-167-57.ap.ngrok.io/api/customer/successPayment';
        $body['buyerName'] = $user->full_name;
        $body['buyerPhone'] = $user->phone;
        $body['buyerEmail'] = $user->email;
        $body['referenceId'] = '1234'; //your reference id
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.ipaymu.com/api/v2/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $jsonBody,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'signature:' . $this->generateSignature($body),
                'va:' . env('IPAYMU_VA'),
                'timestamp:' . Date('YmdHis')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);
        $dateTime = $reservation_date." ".$reservation_time.":00:00";
        $reservation = new reservationMigrasi();
        $reservation->reservation_date_time = $dateTime;
        $reservation->restaurant_id = $restaurant->id;
        $reservation->table_id = $table_number;
        $reservation->payment_status = 0;
        $reservation->user_id = $user->id;
        $reservation->session_id = $response->Data->SessionID;
        $reservation->save();
        // dd($response);
        return redirect($response->Data->Url);
    }
}
