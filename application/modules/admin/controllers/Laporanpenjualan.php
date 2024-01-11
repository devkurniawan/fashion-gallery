<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpenjualan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');
        $user_data = user_data();
        if($user_data->role_id != 3) redirect('admin');

        $this->load->model(array(
            'laporanpenjualan_model' => 'laporanpenjualan'
        ));
    }

    public function index()
    {
        $params['title'] = 'Laporan Penjualan';

        $orders['orders'] = $this->laporanpenjualan->queryDatatable(false, true);

        $this->load->view('header', $params);
        $this->load->view('laporanpenjualan/datatable', $orders);
        $this->load->view('footer');
    }

    public function view($id = 0)
    {
        if ( $this->order->is_order_exist($id))
        {
            $data = $this->order->order_data($id);
            $items = $this->order->order_items($id);
            $banks = json_decode(get_settings('payment_banks'));
            $banks = (Array) $banks;
 
            $params['title'] = 'Order #'. $data->order_number;

            $order['data'] = $data;
            $order['items'] = $items;
            $order['delivery_data'] = json_decode($data->delivery_data);
            $order['banks'] = $banks;
            $order['order_flash'] = $this->session->flashdata('order_flash');
            $order['payment_flash'] = $this->session->flashdata('payment_flash');

            $this->load->view('header', $params);
            $this->load->view('orders/view', $order);
            $this->load->view('footer');
        }
        else
        {
            show_404();
        }
    }

    public function status()
    {
        $status = $this->input->post('status');
        $order = $this->input->post('order');

        $this->order->set_status($status, $order);
        $this->session->set_flashdata('order_flash', 'Status berhasil diperbarui');

        redirect('admin/orders/view/'. $order);
    }
}