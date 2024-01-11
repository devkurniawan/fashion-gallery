<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Laporan Pelanggan</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                  <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <form method="get" id="formFilter">
                <div class="row">
                  <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                      <label>Filter Mulai</label>
                      <input type="date" class="form-control" onchange="$('#formFilter').submit()" name="order_start_date" value="<?=isset($_GET['order_start_date']) ? $_GET['order_start_date'] : date("Y-m-01");?>">
                    </div>
  
                  </div>
                  <div class="col-md-4 col-lg-3">
                    <div class="form-group">
                      <label>Filter Sampai</label>
                      <input type="date" class="form-control" onchange="$('#formFilter').submit()" name="order_end_date" value="<?=isset($_GET['order_end_date']) ? $_GET['order_end_date'] : date("Y-m-d");?>">
                    </div>
  
                  </div>
                </div>
              </form>

            </div>

            <?php if ( count($users) > 0) : ?>
            <div class="card-body p-0">
                <div class="table-responsive">
              <!-- Projects table -->
              <table id="datatable" class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Nomor Telepon</th>
                    <th scope="col">E-Mail</th>
                    <th class="text-center" scope="col">Jumlah Order</th>
                    <th scope="col"  class="text-right">Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                <?php 

                  $_total_orders = 0;
                  $_jumlah_harga = 0;

                  foreach ($users as $user):
                    $this->db->where("DATE_FORMAT(orders.order_date,'%Y-%m-%d')>=", isset($_GET['order_start_date']) && $_GET['order_start_date'] ? $_GET['order_start_date'] : date("Y-m-01"));
                    $this->db->where("DATE_FORMAT(orders.order_date,'%Y-%m-%d')<=", isset($_GET['order_end_date']) && $_GET['order_end_date'] ? $_GET['order_end_date'] : date("Y-m-d"));

                    $orders_ = $this->db->
                                    select("orders.*")->
                                    where("orders.user_id", $user->id)->
                                    where("orders.order_status", 4)->
                                    get("orders")->result();

                    $total_orders = count($orders_);
                    $jumlah_harga = 0;
                    if(!$total_orders) continue;

                    foreach($orders_ as $i){
                      $jumlah_harga += $i->total_price;
                    }

                    $_total_orders += $total_orders;
                    $_jumlah_harga += $jumlah_harga;

                ?>
                  <tr>
                    <th scope="col">
                      <?=$user->id;?>
                    </th>
                    <td><?=$user->nama; ?></td>
                    <td><?=$user->nomor_telepon; ?></td>
                    <td><?=$user->email; ?></td>
                    <td class="text-center">
                      <?=$total_orders;?>
                    </td>
                    <td class="text-right">
                      Rp <?php echo format_rupiah($jumlah_harga); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <th scope="col">Jumlah</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">
                      <?=$_total_orders;?>
                    </td>
                    <td class="text-right">
                      Rp <?php echo format_rupiah($_jumlah_harga); ?>
                    </td>

                </tfoot>
              </table>
            </div>
                </div>
            
            <?php else : ?>
             <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="alert alert-primary">
                            Tidak ada laporan.
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
          </div>
        </div>
      </div>


