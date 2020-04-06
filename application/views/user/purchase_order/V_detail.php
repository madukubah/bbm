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
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-bookmark"></i> Purchase Order
            <small class="pull-right">Tanggal: <?php echo $date ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Dari
          <address>
            <strong><?php echo $company->name ?></strong><br>
            Alamat Serah : <?php echo $delivery_address->name." (".$delivery_address->code.") "; ?> <br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          Ke
          <address>
          <strong><?php echo $vendor->name ?></strong><br>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Order ID #<?php echo $purchase_order->code ?></b><br>
        </div>
      </div>
      <!-- /.row -->

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
              '1.29' => 17.17 , 
              '6' => 80 , 
              '6.75' => 90, 
              '7.5' => 100
            );
          ?>
          <div class="row" >
              <div class="col-xs-5" >
                <!-- <b> PBBKB ( <?php echo $_pbbkb[ "".($delivery_address->pbbkb * 100) ]  ?> % ) </b> -->
                <b> PBBKB ( <?php echo $_pbbkb[ number_format( $pbbkb/$subtotal * 100, 2) ]  ?> % ) </b>
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
                <a target="_blank" href="<?php echo site_url('user/purchase_order/generate_pre_invoice_pdf/').$purchase_order->id ?>" class="btn btn-md btn-violet pull-right">Cetak Invoice PO</a>
            </div>
      </div>
      <!--  -->
    </div>
    <!--  -->
    <?php if( empty( $delivery_orders ) ): ?>
      <!--  -->
      <!--  -->
    <?php else: ?>
      <!--  -->
      <div class="invoice">
          <!--  -->
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-bookmark"></i> Delivery Order
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover">
                  <thead class="thin-border-bottom">
                  <tr >
                      <th>Kode </th>
                      <th>Kuantitas</th>
                      <th>kendaraan</th>
                      <th>Driver</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody id="do_body" >
                      <!--  -->
                      <?php 
                      foreach( $delivery_orders as $delivery_order ):
                      ?>
                      <tr  >
                          <td>
                              <?php echo $delivery_order->code?>
                              <?php
                                $status = array(
                                      "<small class='label bg-red'>belum diproses</small>",
                                      "<small class='label bg-yellow'>diproses</small>",
                                      "<small class='label bg-green'>selesai</small>"
                                );
                              ?>
                              <?php echo $status[ $delivery_order->status ]?>
                          </td>
                          <td>
                              <?php echo $delivery_order->quantity  ?>
                          </td>
                          <td>
                              <?php echo $delivery_order->plat_number  ?>
                          </td>
                          <td>
                              <?php echo $delivery_order->driver_name  ?>
                          </td>
                          <td>
                              <a href="<?php echo site_url('user/purchase_order/do_detail/').$delivery_order->id ?>" class="btn btn-sm btn-primary">Detail</a>
                          </td>
                      </tr>
                      <?php 
                      endforeach;
                      ?>
                      <!--  -->
                  </tbody>
              </table>
          </div>   
          <!--  -->
      </div>
      <!--  -->
    <?php endif; ?>
    <!--  -->
        <div class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <i class="fa fa-bookmark"></i> Faktor pajak
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!--  -->
              <!--  -->
              <?php if( isset( $tax_invoice ) && !empty( $tax_invoice ) ): ?>
                    <div class="row">
                      <div class="col-xs-12">
                            <label for=""> Faktor Pajak </label>
                            <iframe src = "<?php echo base_url()?>assets/ViewerJS/#../../uploads/news_n_tax_factor/<?php echo $tax_invoice->tax?>" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
                          <!-- <iframe src="http://docs.google.com/gview?url=<?php echo base_url() ?>uploads/news_n_tax_factor/<?php echo $do_news_and_tax->tax_factor ?>&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>                             -->
                      </div>
                    </div>
              <?php endif; ?>
              <!--  -->
        </div>
    <!--  -->
  </section>
</div>