<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpelanggan extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');


        $this->load->model(array(
            'laporanpelanggan_model' => 'laporanpelanggan'
        ));
    }

    public function index()
    {
        $params['title'] = 'Laporan Pelanggan';

        $datas['users'] = $this->laporanpelanggan->queryDatatable(false, true);

        $this->load->view('header', $params);
        $this->load->view('laporanpelanggan/datatable', $datas);
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