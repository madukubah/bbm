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
        <!--  -->
        <div class="box-header">
          <div class="row">
            <div class="col-xs-9">
            </div>
            <div class="col-xs-3">
                <!--  -->
                  <form action="<?php echo base_url("user/delivery_order/")?>">
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
            <!--  -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th>Kode </th>
                        <th>Kuantitas</th>
                        <th>kendaraan</th>
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
                                <a href="<?php echo site_url('user/delivery_order/detail/').$delivery_order->id ?>" class="btn btn-sm btn-primary">Lihat</a>
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
