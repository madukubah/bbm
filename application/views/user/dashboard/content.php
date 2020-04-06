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



<!-- Main content -->

<section class="content">

<?php
  if( $this->ion_auth->in_group("customers" ) ):
?>
  <!--  -->
  <div class="row"> 
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $po_process ?></h3>

          <p>PO Di Proses</p>
        </div>
        <div class="icon">
          <i class="fa fa-file"></i>
        </div>
        <a href="<?php echo site_url('user/purchase_order')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3><?php echo $po_complete ?><sup style="font-size: 20px"></sup></h3>

          <p>PO Selesai</p>
        </div>
        <div class="icon">
          <i class="fa fa-file"></i>
        </div>
        <a href="<?php echo site_url('user/purchase_order/')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3><?php echo $invioce_bill ?></h3>

          <p>Invoice Belum Dibayar</p>
        </div>
        <div class="icon">
          <i class="fa fa-file"></i>
        </div>
        <a href="<?php echo site_url('user/invoice/')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!--  -->
<?php
  elseif( $this->ion_auth->in_group("driver" ) ):
?>
    <!--  -->
    <div class="row"> 
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?php echo $do_unprocess ?></h3>

            <p>DO Belum Diproses</p>
          </div>
          <div class="icon">
            <i class="fa fa-truck"></i>
          </div>
          <a href="<?php echo site_url('user/invoice/')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!--  -->
<?php
  endif;
?>

  

</section>

</div>