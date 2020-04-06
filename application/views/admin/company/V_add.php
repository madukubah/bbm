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
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo form_input($customer_id);?>
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Kode Customer</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($kode_customer);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Direktur</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($direktur);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Nama Perusahaan</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($name);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Alamat Perusahaan</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($address);?>
                </div>
            </div>
            <!--  -->
              <!-- - -->
              <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">NPWP</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($npwp);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">SITU</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($situ);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">SIUP</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($siup);?>
                </div>
            </div>
            <!--  -->
           <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">TDO</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($tdo);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">TDP</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($tdp);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">Bidang Usaha</label>
                </div>
                <div class="col-md-8">
                    <?php echo form_input($business_fields);?>
                </div>
            </div>
            <!--  -->
            <!-- - -->
            <div class="row">
                <div class="col-md-3">
                    <label for="" class="control-label">PPH 0.3 %</label>
                </div>
                <div class="col-md-8">
                    <?php echo ($pph);?>
                </div>
            </div>
            <!--  -->
            
      </div>
    </div>
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