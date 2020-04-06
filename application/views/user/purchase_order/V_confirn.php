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
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-bookmark"></i> Purchase Order
          <small class="pull-right">Date: <?php echo date( "d/m/Y" ) ?></small>
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
              <b> PBBKB ( <?php echo $_pbbkb[ "".($delivery_address->pbbkb * 100) ]  ?> % ) </b>
            </div>
            <div class="col-xs-5" >
                <!--  -->
                <div class="row" >
                      <div class="col-xs-3" >
                        Rp.
                      </div>
                      <div class="col-xs-5" >
                          <div class="pull-right" >
                              <?php echo  (  $pbbkb );  ?>
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
          <br><br>
    <!-- this row will not appear when printing -->
    <div class="row no-print">
      <div class="col-xs-8">
      </div>
      <div class="col-xs-2">
              <a href="<?php echo site_url('user/purchase_order/') ?>" class="btn btn-danger pull-right ">Batal</a>
      </div>
      <div class="col-xs-2">
          <?php echo form_open("user/purchase_order/order");?>
              <input type="hidden" value="<?php echo $this->input->post( 'vendor_id' ); ?>" name="vendor_id" >
              <input type="hidden" value="<?php echo $this->input->post( 'product_id' ); ?>" name="product_id" >
              <input type="hidden" value="<?php echo $this->input->post( 'material_id' ); ?>" name="material_id" >
              <input type="hidden" value="<?php echo $this->input->post( 'quantity' ); ?>" name="quantity" >
              <input type="hidden" value="<?php echo $this->input->post( 'delivery_address_id' ); ?>" name="delivery_address_id" >
              <button type="submit" class="btn btn-success " style="margin-right: 5px;">
                Konfirmasi
              </button>
          <?php echo form_close(); ?>
      </div>
     
    </div>
  </section>
</div>