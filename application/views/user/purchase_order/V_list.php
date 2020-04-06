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
        <div class="box-body">
            <button type="submit" class="btn  pull-right btn-primary" data-toggle="modal" data-target="#add_purchase_order" >Buat PO</button>
            <!-- edit_category-->
            <div class="modal fade" id="add_purchase_order" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <?php echo form_open("user/purchase_order/order_confirm");?>
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">#Buat PO</h4>
                    </div>
                    <div class="modal-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Suplier</label>
                            
                                <?php echo form_dropdown( $vendor_id ) ?>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Alamat Serah</label>
                            
                                <?php echo form_dropdown( $delivery_address_id ) ?>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Produk</label>
                            
                                <?php echo form_dropdown( $product_id ) ?>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Material</label>
                            
                            <div id="materials" >
                                <?php echo form_dropdown( $material_id ) ?>
                            </div>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Jumlah</label>
                            
                                <?php echo form_input( $quantity ) ?>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn  btn-success">Lanjutkan</button>
                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <!--  -->
    <div class="box">
        <!-- /.box-header -->
        <!--  -->
        <div class="box-header">
          <div class="row">
            <div class="col-xs-9">
            </div>
            <div class="col-xs-3">
                <!--  -->
                  <form action="<?php echo base_url("user/purchase_order/")?>">
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
        <!--  -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Kode</th>
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
                            <?php echo $purchase_order->material_name  ?>
                        </td>
                        <td>
                            <?php echo $purchase_order->quantity  ?>
                        </td>
                        <td>
                            <?php echo number_format($purchase_order->total ) ?>
                        </td>
                        <td>
                            <a href="<?php echo site_url('user/purchase_order/detail/').$purchase_order->id ?>" class="btn btn-sm btn-primary">Detail</a>
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
<input type="hidden" id="site_url"  name="name" value="<?php echo site_url(); ?>"  />
<script src="<?php echo base_url();?>assets/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#product_id").change(function(){
        console.log( $("#product_id").val() );
        url = $("#site_url").val()+"api/material/materials/"+$("#product_id").val()  ;
        console.log( url );

        $.get(url, function(data, status){
            console.log( data );
            var html = '';
            html +=   '<select name="material_id" id="material_id" type="text" placeholder="Produk" class="form-control">';
                data.forEach(function(element) {
                    html += "<option value='"+element.id+"'>"+ element.name +"</option>"
                });
            html +=   '</select>';

            $('#materials').html(html);
        });
    });
});
</script>
