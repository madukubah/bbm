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
            <?php echo form_open("admin/report");?>
                <!-- - -->
                <div class="row">
                    <div class="col-md-2">
                        <!-- <input type="radio" checked name="option" value="0" id="umum" >
                        <label for="umum" class="control-label">Umum</label> 
                        <br>
                        <input type="radio" name="option" value="1" id="detail" >
                        <label for="detail" class="control-label">Detail</label> <br> -->
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dari Tanggal:</label>

                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                                <input type="text" name="start_date" value="<?php echo $start_date ?>" class="form-control pull-right" id="datepicker">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sampai Tanggal:</label>

                            <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                                <input type="text" name="end_date" value="<?php echo $end_date ?>" class="form-control pull-right" id="datepicker2">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn  btn-success">Tampilkan</button>
                    </div>
                    <!--  -->
                </div>
                <!--  -->
            <?php echo form_close(); ?>
        </div>
    </div>
    <!--  -->
    <!--  -->
    <div class="box">
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo $table ?>
      </div>
    </div>
<!--  -->
</section>
</div>

