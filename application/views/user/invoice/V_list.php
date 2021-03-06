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
                  <form action="<?php echo base_url("user/invoice/")?>">
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
                        <th>Kode PO</th>
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
                    foreach( $invoices as $invoice ):
                    ?>
                    <tr  >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $invoice->code?>
                            <?php
                               $status = array(
                                    "<small class='label bg-red'>belum diproses</small>",
                                    "<small class='label bg-yellow'>diproses</small>",
                                    "<small class='label bg-green'>selesai</small>"
                               );
                            ?>
                            <?php echo $status[ $invoice->status ]?>
                        </td>
                        <td>
                            <?php echo $invoice->purchase_order_code  ?>
                        </td>
                        <td>
                            <?php echo $invoice->material_name  ?>
                        </td>
                        <td>
                            <?php echo $invoice->quantity  ?>
                        </td>
                        <td>
                            <?php echo number_format($invoice->total ) ?>
                        </td>
                        <td>
                            <a href="<?php echo site_url('user/invoice/detail/').$invoice->id ?>" class="btn btn-sm btn-primary">Detail</a>
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

