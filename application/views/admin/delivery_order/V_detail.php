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
            <i class="fa fa-bookmark"></i> Delivery Order
            <small class="pull-right">Tanggal: <?php echo date( "Y/m/d" , $delivery_order->create_date ) ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Tujuan
          <address>
            <strong><?php echo $company->name ?></strong><br>
            Alamat Serah : <?php echo $delivery_address->name." ( ".$delivery_address->code." ) "; ?> <br>
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
              <b>DO ID #<?php echo $delivery_order->code ?></b><br>
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
              <th>Kendaraan</th>
              <th>Uang Jalan ( Rp ) </th>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td><?php echo $material->name ?></td>
              <td><?php echo $material->unit ?></td>
              <td><?php echo  number_format($delivery_order->quantity) ?></td>
              <td><?php echo  (  $delivery_order->plat_number );  ?></td>
              <td><?php echo  number_format($delivery_order->travel_cost) ?></td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!--  -->
    <div class="invoice">
        <!--  -->
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <i class="fa fa-bookmark"></i> Log Perjalanan 
            </h2>
            <b> <?php echo 'Driver : '.$delivery_order->driver_name  ?> </b>
          </div>
          <!-- /.col -->
        </div>
        <!--  -->
        <!-- /.row -->
        <div class="row">
            <div class="col-xs-12">   
                <!--  -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thin-border-bottom">
                        <tr >
                            <th>Status </th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                        </tr>
                        </thead>
                        <tbody id="do_body" >
                            <!--  -->
                            <?php 
                            foreach( $do_logs as $do_log ):
                            ?>
                            <tr  >
                                <td>
                                    <?php
                                      $status = array(
                                            '',
                                            "<small class='label bg-yellow'>Pengisian</small>",
                                            "<small class='label bg-blue'>Jalan</small>",
                                            "<small class='label bg-green'>Selesai</small>"
                                      );
                                    ?>
                                    <?php echo $status[ $do_log->flag ]?>
                                </td>
                                <td>
                                    <?php echo date( "Y/m/d" , $do_log->date );  ?>
                                </td>
                                <td>
                                    <?php echo date( "H:i" , $do_log->date );  ?>
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
        </div>
    </div>
    <!--  -->
    <!--  -->
    <?php if( isset( $do_report ) ): ?>
        <div class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <i class="fa fa-bookmark"></i> Laporan
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!--  -->
              <!--  -->
              <div class="row">
                  <div class="col-xs-3">   
                        Kuantitas bahan yang di terima
                  </div>
                  <div class="col-xs-9">   
                        : <?php echo $do_report->quantity." ".$material->unit ?>
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-xs-3">   
                        SG/Temperatur
                  </div>
                  <div class="col-xs-9">   
                        : <?php echo $do_report->sg." / ".$do_report->temperature.( is_numeric( $do_report->temperature )? ' `C':'' ) ?>
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-xs-3">   
                        Kondisi Tanki
                  </div>
                  <div class="col-xs-9">   
                        : <?php echo $do_report->tank_condition ?>
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-xs-3">   
                        Kualitas
                  </div>
                  <div class="col-xs-9">   
                        : <?php echo $do_report->quality ?>
                  </div>
              </div>
              <hr>
              <div class="row">
                  <div class="col-xs-3">   
                        Keterangan
                  </div>
                  <div class="col-xs-9">   
                        : <?php echo $do_report->information ?>
                  </div>
              </div>
              <!--  -->
        </div>
    <?php endif; ?>
    <!--  -->
    <!--  -->
    <?php if( isset( $do_news_and_tax ) && !empty( $do_news_and_tax ) ): ?>
        <div class="invoice">
              <!-- title row -->
              <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">
                    <i class="fa fa-bookmark"></i> Berita Acara
                  </h2>
                </div>
                <!-- /.col -->
              </div>
              <!--  -->
              <!--  -->
              <div class="row">
                <div class="col-xs-12">
                    <label for=""> Berita Acara </label>
                    <!-- <iframe src="http://docs.google.com/gview?url=<?php echo base_url() ?>uploads/news_n_tax_factor/<?php echo $do_news_and_tax->news ?>&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>                             -->
                    <iframe src = "<?php echo base_url()?>assets/ViewerJS/#../../uploads/news_n_tax_factor/<?php echo $do_news_and_tax->news?>" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe>
                </div>
              </div>
              <!--  -->
              <!--  -->
              <!-- <div class="row"> -->
                <!-- <div class="col-xs-12"> -->
                      <!-- <label for=""> Faktor Pajak </label> -->
                      <!-- <iframe src = "<?php echo base_url()?>assets/ViewerJS/#../../uploads/news_n_tax_factor/<?php echo $do_news_and_tax->tax_factor?>" width='100%' height='600' allowfullscreen webkitallowfullscreen></iframe> -->
                    <!-- <iframe src="http://docs.google.com/gview?url=<?php echo base_url() ?>uploads/news_n_tax_factor/<?php echo $do_news_and_tax->tax_factor ?>&embedded=true" style="width:100%; height:500px;" frameborder="0"></iframe>                             -->
                <!-- </div>
              </div> -->
              <!--  -->
              
        </div>
    <?php else : ?>
        <?php if( $this->ion_auth->is_admin() ) : ?>
            <!--  -->
            <div class="invoice">
                  <!-- title row -->
                  <div class="row">
                    <div class="col-xs-12">
                      <h2 class="page-header">
                        <i class="fa fa-bookmark"></i> Upload Berita Acara
                      </h2>
                    </div>
                    <!-- /.col -->
                  </div>
                  <!--  -->
                  <!--  -->
                  <?php echo form_open_multipart("admin/do_news_and_tax/add");?>
                  <div class="row">
                      <div class="col-xs-3">   
                            berita Acara ( PDF )
                      </div>
                      <div class="col-xs-9">   
                          <input type="file" name="do_news" />
                      </div>
                  </div>
                  <hr>
                  <!-- <div class="row"> -->
                      <!-- <div class="col-xs-3">    -->
                            <!-- Faktor Pajak ( PDF ) -->
                      <!-- </div> -->
                      <!-- <div class="col-xs-9">    -->
                          <!-- <input type="file" name="do_tax" /> -->
                      <!-- </div> -->
                  <!-- </div> -->
                  <hr>
                  <div class="row">
                      <div class="col-xs-12">   
                          <input type="hidden" name="delivery_order_code" value="<?php echo $delivery_order->code?>"/>
                          <input type="hidden" name="delivery_order_id" value="<?php echo $delivery_order->id?>"/>
                          <button type="submit" class="btn pull-right  btn-success">Upload</button>
                      </div>
                  </div>
                  
                  <?php echo form_close(); ?>
                  <!--  -->
            </div>
            <!--  -->
        <?php endif; ?>
    <?php endif; ?>
    <!--  -->
  </section>
</div>