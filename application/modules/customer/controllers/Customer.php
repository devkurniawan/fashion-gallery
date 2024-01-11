<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('customer');

        $this->load->model(array(
            'payment_model' => 'payment',
            'order_model' => 'order',
            'review_model' => 'review'
        ));
    }

    public function index()
    {
        $params['title'] = get_settings('store_tagline');

        $home = ['total_order' => $this->order->count_all_orders(),
        'total_payment' => $this->payment->count_all_payments(),
       'total_process_order' => $this->order->count_process_order(),
        'total_review' => $this->review->count_all_reviews(),
        'flash' => $this->session->flashdata('store_flash')];

        $this->load->view('header', $params);
        $this->load->view('home', $home);
        $this->load->view('footer');
    }
}