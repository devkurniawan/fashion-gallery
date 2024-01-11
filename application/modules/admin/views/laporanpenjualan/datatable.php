<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Laporan Penjualan</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Laporan</li>
                  <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
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

            <?php if ( count($orders) > 0) : ?>
            <div class="card-body p-0">
                <div class="table-responsive">
              <!-- Projects table -->
              <table id="datatable" class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Jumlah Item</th>
                    <th scope="col">Item</th>
                    <th scope="col">Jumlah Harga</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $total_price = 0;
                  $jumlah_item = 0;
                  foreach ($orders as $order):
                    $items_ = $this->db->
                                    select("
                                      order_item.*,
                                      products.name item
                                    ")->
                                    join("products", "products.id=order_item.product_id", "left")->
                                    where("order_item.order_id", $order->id)->
                                    get("order_item")->result();

                    $items = [];
                    foreach($items_ as $i){
                      $items[] = $i->item." (".$i->order_qty." x ".format_rupiah($i->order_price).")";
                    }
                ?>
                  <tr>
                    <th scope="col">
                      <?php echo anchor('admin/orders/view/'. $order->id, '#'. $order->order_number); ?>
                    </th>
                    <td><?php echo $order->customer; ?></td>
                    <td>
                      <?php echo get_formatted_date($order->order_date); ?>
                    </td>
                    <td>
                      <?php echo $order->total_items; ?>
                    </td>
                    <td>
                      <?=implode(", ", $items);?>
                    </td>
                    <td>
                      Rp <?php echo format_rupiah($order->total_price); ?>
                    </td>
                  </tr>
                <?php 
                  $total_price += $order->total_price;
                  $jumlah_item += $order->total_items;
                  endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th scope="col">
                      Jumlah
                    </th>
                    <td></td>
                    <td></td>
                    <td><?=$jumlah_item;?></td>
                    <td></td>
                    <td>
                      Rp <?php echo format_rupiah($total_price); ?>
                    </td>
                  </tr>

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


