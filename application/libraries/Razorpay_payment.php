<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: nashiruddin.k
 * Date: 11/09/2017
 * Time: 11:54 AM
 */

require APPPATH . 'third_party/razorpay_payment/Razorpay.php';

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class Razorpay_payment
{
    function get_razorpay_order_id($razorpay_data = array())
    {
        $receipt = (isset($razorpay_data['invoice_id']) ? $razorpay_data['invoice_id'] : '');
        $amount = (isset($razorpay_data['amount']) ? $razorpay_data['amount'] : '');

        $orderData = [
            'receipt'         => $receipt,
            'amount'          => $amount, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRETE);

        $razorpayOrder = $api->order->create($orderData);
            //echo '<pre>'; print_r($razorpayOrder); die();
        return $razorpayOrder->toArray();
    }

    function capture_razorpay_payment($razorpay_data = array())
    {
        $razorpay_data_id = (isset($razorpay_data['razorpay_payment_id']) ? $razorpay_data['razorpay_payment_id'] : '');
        $amount = (isset($razorpay_data['amount']) ? $razorpay_data['amount'] : '');

        $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRETE);

        $payment = $api->payment->fetch($razorpay_data_id)->capture(array('amount' => $amount));
        $data = $payment->toArray();
        return $data;
    }

}