<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpenjualan_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function queryDatatable($getTotal=false, $all=false){

        extract($_POST);

        $this->db->select("
            orders.*,
            coupons.name coupon,
            customers.name customer
        ")->
        join("coupons", "coupons.id = orders.coupon_id", "left")->
        join("customers", "customers.user_id = orders.user_id", "left");

        if(isset($_POST['search']['value']) && $search['value']){
            $this->db->group_start()->
                like('orders.order_number', $search['value'])->
                or_like('orders.order_date', $search['value'])->
            group_end();
        }

        $this->db->where("DATE_FORMAT(orders.order_date,'%Y-%m-%d')>=", isset($_GET['order_start_date']) && $_GET['order_start_date'] ? $_GET['order_start_date'] : date("Y-m-01"));
        $this->db->where("DATE_FORMAT(orders.order_date,'%Y-%m-%d')<=", isset($_GET['order_end_date']) && $_GET['order_end_date'] ? $_GET['order_end_date'] : date("Y-m-d"));
        
        $this->db->where("orders.order_status", 4);
        $this->db->order_by('orders.id', 'desc');

        if(!$all && isset($length) && $length>=1) $this->db->limit($length, $start);
    
        return  $getTotal ? $this->db->get('orders')->num_rows() : 
                            $this->db->get('orders')->result();
                            
    }

}