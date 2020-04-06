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
            Alamat Serah : <?php echo $delivery_address->name." (".$delivery_address->code.") "; ?> <br>
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
          </div>
          <!-- /.col -->
        </div>
        <!--  -->
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col " style="padding:10px !important">
            <center>
                <?php echo form_open("user/do_log/add");?>
                <input type="hidden" class="form-control"  name="flag" value="1"  />
                <input type="hidden" class="form-control"  name="delivery_order_id" value="<?php echo $delivery_order->id ?>"  />
                <button type="submit" class="btn btn-warning" <?php echo ( count( $do_logs ) >= 1 )?'disabled':'' ?>  ><i class="ace-icon fa fa-flag bigger-120 red"></i> Pengisian</button>
                <?php echo form_close(); ?>
            </center>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col" style="padding:10px !important" >
            <center>
                <?php if( count( $do_logs ) >= 1 ) : ?>
                    <?php echo form_open("user/do_log/add");?>
                    <input type="hidden" class="form-control"  name="flag" value="2"  />
                    <input type="hidden" class="form-control"  name="delivery_order_id" value="<?php echo $delivery_order->id ?>"  />
                    <button type="submit" class="btn btn-primary" <?php echo ( count( $do_logs ) >= 2 )?'disabled':'' ?>  ><i class="ace-icon fa fa-flag bigger-120 red"></i> Jalan</button>
                    <?php echo form_close(); ?>
                <?php else :?>
                    <button class="btn btn-primary"  ><i class="ace-icon fa fa-flag bigger-120 red"></i> Jalan</button>
                <?php endif ;?>
            </center>          
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col" style="padding:10px !important" >
            <center>
                <?php if( count( $do_logs ) >= 2 ) : ?>
                    <!--  -->
                    <button type="submit" <?php echo ( count( $do_logs ) == 3 )?'disabled':'' ?> class="btn btn-success" data-toggle="modal" data-target="#do_report" ><i class="ace-icon fa fa-flag bigger-120 red"></i> Selesai</button>
                    <!-- edit_category-->
                    <div class="modal fade" id="do_report" role="dialog">
                        <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <?php echo form_open("user/do_log/add");?>
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">DO Report</h4>
                            </div>
                            <div class="modal-body">
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                      <label for="" class="pull-left">Kuantitas bahan yang di terima</label>
                                          <?php echo form_input( $quantity ) ?>
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-6">
                                      <label for="" class="pull-left">SG</label>
                                      <?php echo form_input( $sg ) ?>
                                    </div>
                                    <div class="col-md-6">
                                      <label for="" class="pull-left">Temperatur</label>
                                      <?php echo form_input( $temperature ) ?>
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                      <label for="" class="pull-left">Kondisi Tanki</label>
                                      <?php echo form_dropdown( $tank_condition ) ?>
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                      <label for="" class="pull-left">Kualitas</label>
                                      <?php echo form_dropdown( $quality ) ?>
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                      <label for="" class="pull-left">Keterangan</label>
                                      <?php echo form_dropdown( $information ) ?>
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control"  name="flag" value="3"  />
                            <?php echo form_input( $delivery_order_id ) ?>
                            <button type="submit" class="btn  btn-success">Ok</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        </div>
                    </div>
                    <!--  -->
                <?php else :?>
                    <button class="btn btn-success" ><i class="ace-icon fa fa-flag bigger-120 red"></i> Selesai</button>
                <?php endif ;?>
            </center>           
          </div>
        </div>
        <br><br>
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
  </section>
</div>