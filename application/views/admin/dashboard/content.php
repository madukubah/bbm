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

  <div class="row"> 
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $customers_count ?></h3>

          <p>Customer</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="<?php echo site_url('admin/company')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-primary">
        <div class="inner">
          <h3><?php echo $drivers_count ?><sup style="font-size: 20px"></sup></h3>

          <p>Driver</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="<?php echo site_url('admin/user_management/driver/')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-purple">
        <div class="inner">
          <h3><?php echo $car_count ?></h3>

          <p>Kendaraan</p>
        </div>
        <div class="icon">
          <i class="fa fa-truck"></i>
        </div>
        <a href="<?php echo site_url('admin/car/')?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
</section>
<!-- /.content -->
</div>