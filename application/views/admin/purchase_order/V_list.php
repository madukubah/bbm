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
<!-- alert  -->
<!-- Main content -->
  <section class="content">

    <!--  -->
    <div class="box">
        <!-- /.box-header -->
        <div class="box-header">
          <div class="row">
            <div class="col-xs-9">
            </div>
            <div class="col-xs-3">
                <!--  -->
                  <form action="<?php echo base_url("admin/purchase_order/")?>">
                      <div class="input-group input-group-sm">
                            <input type="text" name="search" value="<?php echo $search?>" class="form-control">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary btn-flat">Cari</button>
                            </span>
                      </div>
                  </form>
                <!--  -->
            </div>
          </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Kode</th>
                        <th>Kode Alamat Serah</th>
                        <th>Material</th>
                        <th>Jumlah</th>
                        <th>Total (Rp)</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    // $customers = array();
                    foreach( $purchase_orders as $purchase_order ):
                    ?>
                    <tr  >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $purchase_order->code?>
                            <?php
                               $status = array(
                                    "<small class='label bg-red'>belum diproses</small>",
                                    "<small class='label bg-yellow'>diproses</small>",
                                    "<small class='label bg-green'>selesai</small>"
                               );
                            ?>
                            <?php echo $status[ $purchase_order->status ]?>
                        </td>
                        <td>
                            <?php echo $purchase_order->delivery_address_code  ?>
                        </td>
                        <td>
                            <?php echo $purchase_order->material_name  ?>
                        </td>
                        <td>
                            <?php echo $purchase_order->quantity  ?>
                        </td>
                        <td>
                            <?php echo number_format($purchase_order->total ) ?>
                        </td>
                        <td>
                            <a href="<?php echo site_url('admin/purchase_order/detail/').$purchase_order->id ?>" class="btn btn-sm btn-primary">Detail</a>
                            <!--  -->
                            <button class="btn btn-white btn-danger btn-bold btn-sm" data-toggle="modal" data-target="#delete_purchase_order<?php echo $purchase_order->id?>">
                                <i class="ace-icon fa fa-trash bigger-120 red"></i>
                            </button>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="delete_purchase_order<?php echo $purchase_order->id;?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/purchase_order/delete");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Delete </h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="alert alert-danger">Anda yakin ingin menghapus <b><?php echo $purchase_order->code?></b>?</div>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $purchase_order->id ?>" name="id" required="required">
                                    <button type="submit" class="btn btn-danger">Ya</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                </div>
                            </div>
                            <!--  -->
                        </td>
                    </tr>
                    <?php 
                    $no++;
                    endforeach;?>
                    </tbody>
                </table>
            </div>    
            <!-- Tampilkan Pagging -->
            <?php echo $links;?>
      </div>
    </div>
<!--  -->
</section>
</div>

