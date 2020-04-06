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
  <?php echo form_open("");?>
    <div class="box">
        <div class="box-header">
          <h3 class="box-title">informasi dasar</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
             <!-- - -->
             <!-- <div class="row">
                  <div class="col-md-3">
                      <label for="" class="control-label">Username</label>
                  </div>
                  <div class="col-md-8">
                      <?php echo form_input($identity);?>
                  </div>
            </div>   -->
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Nama Depan</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($first_name);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Nama Belakang</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($last_name);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Email</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($email);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">No Telepon</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($phone);?>
                </div>
            </div>
            <!--  -->
           <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Alamat</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($address);?>
                </div>
            </div>
            <!--  -->
      </div>
    </div>

    <!--  -->
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Group User</label>
                </div>
                <div class="col-md-8">
                    <?php echo ($groups);?>
                </div>
            </div>
            <!--  -->
            <br>
        </div>
    </div>
    <!--  -->
    <!--  -->
    <!-- <div class="box">
        <div class="box-header">
          <h3 class="box-title">Autentikasi</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Password</label>
                </div>
                <div class="col-md-8">
                <?php echo form_input($password);?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Konfirmasi Password</label>
                </div>
                <div class="col-md-8">
                <?php echo form_input($password_confirm);?>
                </div>
            </div>
        </div>
    </div> -->
    <!--  -->
    <!--  -->
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_submit($submit);?>
        </div>
    </div>
    <!--  -->
  <?php echo form_close();?>
</section>
</div>