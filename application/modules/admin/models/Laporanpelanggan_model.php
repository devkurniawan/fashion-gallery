<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporanpelanggan_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function queryDatatable($getTotal=false, $all=false){

        extract($_POST);

        $this->db->select("
            users.*,
            customers.name nama,
            customers.phone_number nomor_telepon,
            customers.address alamat
        ")->
        join("customers", "customers.user_id=users.id", "left")->
        where('users.role_id', 2);

        if(isset($_POST['search']['value']) && $search['value']){
            $this->db->group_start()->
                like('users.name', $search['value'])->
                or_like('users.email', $search['value'])->
                or_like('customers.name', $search['value'])->
            group_end();
        }
        
        $this->db->order_by('users.id', 'desc');

        if(!$all && isset($length) && $length>=1) $this->db->limit($length, $start);
    
        return  $getTotal ? $this->db->get('users')->num_rows() : 
                            $this->db->get('users')->result();
                            
    }

}