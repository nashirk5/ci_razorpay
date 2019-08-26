<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller
{
    public function index()
    {
        $this->load->view('payment_view');
    }

    function capture_razorpay_payment()
    {
        try {
            $this->load->library('razorpay_payment');
            $razorpay_data = array(
                'razorpay_payment_id' => $this->input->post('rzpPaymentId'),
                'amount' => $this->input->post('rzpAmount'),
            );
            $response = $this->razorpay_payment->capture_razorpay_payment($razorpay_data);
            echo json_encode($response);
        } catch (Exception $ex) {
            echo json_encode($ex->getMessage());
        }
    }

    function razorpay_order_id()
    {
        $this->load->library('razorpay_payment');
        $razorpay_data = array(
            'invoice_id' => 1221,
            'amount' => 200,
        );
        $response = $this->razorpay_payment->get_razorpay_order_id($razorpay_data);
        $response['invoice_id'] = $razorpay_data['invoice_id'];
        $response['invoice_amount'] = $razorpay_data['amount'];
        echo json_encode($response);
        $this->load->view('order_view', $response);
    }
}
