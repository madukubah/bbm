<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_title ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- alert  -->
<?php
    if($this->session->flashdata('alert')){
      echo $this->session->flashdata('alert');
    }
  ?>
  <section class="content">
    <div class="invoice">
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Tujuan
          <address>
            <strong><?php echo $company->name ?></strong><br>
            Alamat Serah : <?php echo $delivery_address->name." ( ".$delivery_address->code." ) "; ?> <br>
            Material : <?php echo $material->name; ?> <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Asal Pemesanan
          <address>
          <strong><?php echo $vendor->name ?></strong><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <address>
              <b>PO ID #<?php echo $purchase_order->code ?></b><br>
          </address>
        </div>
      </div>
      <!-- /.row -->
      <!--  -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>DO ID</th>
              <th>Driver</th>
              <th>Nomor Plat kendaraan</th>
              <th>Kuantitas awal</th>
              <th>Kuantitas akhir</th>
              <th>Selisih</th>
            </tr>
            </thead>
            <tbody>
              <?php 
              $total_difference = 0;
              $total_a = 0;
              $total_b = 0;
              foreach( $delivery_orders as $delivery_order ): 
                  $total_a += $delivery_order->quantity;
                  $total_b += $delivery_order->do_report_quantity;
              ?>
              <tr>
                <td><?php echo $delivery_order->code ?></td>
                <td><?php echo $delivery_order->driver_name ?></td>
                <td><?php echo $delivery_order->plat_number ?></td>
                <td><?php echo $delivery_order->quantity." ".$material->unit ?></td>
                <td><?php echo $delivery_order->do_report_quantity." ".$material->unit ?></td>
                <td><?php 
                          $total_difference += $delivery_order->quantity - $delivery_order->do_report_quantity;
                          echo ($delivery_order->quantity - $delivery_order->do_report_quantity)." ".$material->unit;
                    ?>
                </td>
              </tr>
              <?php endforeach; ?>
              <tr>
                <td></td>
                <td></td>
                <td><?php echo "Total" ?></td>
                <td><?php echo $total_a." ".$material->unit ?></td>
                <td><?php echo $total_b." ".$material->unit ?></td>
                <td><?php echo $total_difference." ".$material->unit ?></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!--  -->
    </div>
    <!--  -->
    <div class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-bookmark"></i> Invoice
            <small class="pull-right">Date: <?php echo $date ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Material</th>
              <th>Satuan</th>
              <th>Jumlah</th>
              <th>Harga Satuan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><?php echo $material->name ?></td>
              <td><?php echo $material->unit ?></td>
              <td><?php echo  number_format($quantity) ?></td>
              <td><?php echo "Rp. ".number_format(  $price );  ?></td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <!--  -->
          <div class="row" >
              <div class="col-xs-5" >
                <b> Net Price </b>
              </div>
              <div class="col-xs-5" >
                  <!--  -->
                  <div class="row" >
                        <div class="col-xs-3" >
                          Rp.
                        </div>
                        <div class="col-xs-5" >
                            <div class="pull-right" >
                                <?php echo  number_format(  $subtotal );  ?>
                            </div>
                        </div>
                    </div>
                  <!--  -->
                  <!-- <hr> -->
              </div>
          </div>
          <!--  -->
          <!--  -->
          <div class="row" >
              <div class="col-xs-5" >
                <b> PPN ( 10% ) </b>
              </div>
              <div class="col-xs-5" >
                  <!--  -->
                  <div class="row" >
                        <div class="col-xs-3" >
                          Rp.
                        </div>
                        <div class="col-xs-5" >
                            <div class="pull-right" >
                                <?php echo  number_format(  $ppn );  ?>
                            </div>
                        </div>
                    </div>
                  <!--  -->
              </div>
          </div>
          <!--  -->
          <!--  -->
          <div class="row" >
              <div class="col-xs-5" >
                <b> PPH ( <?php echo ( $company->pph * 100 )." % "  ?> ) </b>
              </div>
              <div class="col-xs-5" >
                  <!--  -->
                  <div class="row" >
                        <div class="col-xs-3" >
                          Rp.
                        </div>
                        <div class="col-xs-5" >
                            <div class="pull-right" >
                                <?php echo  number_format(  $pph );  ?>
                            </div>
                        </div>
                    </div>
                  <!--  -->
              </div>
          </div>
          <!--  -->
          <!--  -->
          <?php 
              $_pbbkb = array(
                1.29 => 17.17 , 
                6.75 => 90, 
                7.5 => 100
            );
          ?>
          <div class="row" >
              <div class="col-xs-5" >
                <b> PBBKB ( <?php echo $_pbbkb[ $delivery_address->pbbkb * 100 ]  ?> % ) </b>
              </div>
              <div class="col-xs-5" >
                  <!--  -->
                  <div class="row" >
                        <div class="col-xs-3" >
                          Rp.
                        </div>
                        <div class="col-xs-5" >
                            <div class="pull-right" >
                                <?php echo  number_format(  $pbbkb );  ?>
                            </div>
                        </div>
                    </div>
                  <!--  -->
              </div>
          </div>
          <!--  -->
          <hr style="margin:0 ;">
          <!--  -->
          <div class="row" >
              <div class="col-xs-5" >
                <b> Total</b>
              </div>
              <div class="col-xs-5" >
                  <!--  -->
                  <div class="row" >
                        <div class="col-xs-3" >
                          Rp.
                        </div>
                        <div class="col-xs-5" >
                            <div class="pull-right" >
                                <?php echo  number_format(  $total );  ?>
                            </div>
                        </div>
                    </div>
                  <!--  -->
              </div>
          </div>
          <!--  -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!--  -->
      <div class="row">
            <div class="col-xs-12">   
              <a target="_blank" href="<?php echo site_url('user/invoice/generate_invoice_pdf/').$invoice->id ?>" class="btn btn-md btn-violet pull-right">Cetak Invoice</a>
            </div>
      </div>
      <!--  -->
    </div>
    <!--  -->
  </section>
</div>