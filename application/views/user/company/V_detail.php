<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $company->name ?>
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
    <?php if( isset( $company ) ):  ?>
    <?php echo form_open_multipart();?>
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Kode Customer</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control"   value="<?php echo set_value("a" , $company->username); ?>" readonly/>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Direktur</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control"   value="<?php echo set_value("a" , $company->first_name." ".$company->last_name  ); ?>" readonly/>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Alamat Perusahaan</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control"   value="<?php echo set_value("a" , $company->address); ?>" readonly/>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">NPWP</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control"   value="<?php echo set_value("a" , $company->npwp); ?>" readonly/>
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">Bidang Usaha</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control"   value="<?php echo set_value("a" , $company->business_fields); ?>" readonly/>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
            <div class="col-md-3" >
                <div class="box box-primary" >
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-box" src="<?php  echo $a =  ( empty($user->image) ) ?  base_url(FAVICON_IMAGE) : base_url('uploads/users_photo/').$user->image ?>" >   
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    <?php echo form_close()?>
    <?php endif;  ?>
    <!--  -->
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-md-2">
                    <h4>Alamat Serah </h4>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Kode Alamat Serah</th>
                        <th>Nama Alamat Serah</th>
                        <th>Kode Pos</th>
                        <th>Kota</th>
                        <th>Provinsi</th>
                        <th>PBBKB</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    // $customers = array();
                    foreach( $delivery_addresses as $delivery_address ):
                    ?>
                    <tr >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $delivery_address->code?>
                        </td>
                        <td>
                            <?php echo $delivery_address->name  ?>
                        </td>
                        
                        <td>
                            <?php echo $delivery_address->postal_code?>
                        </td>
                        <td>
                            <?php echo $delivery_address->city?>
                        </td>
                        <td>
                            <?php echo $delivery_address->province?>
                        </td>
                        <td>
                            <?php 
                                $pbbkb = array(
                                    '1.29' => 17.17 , 
                                    '6' => 80 , 
                                    '6.75' => 90, 
                                    '7.5' => 100
                                );

                                $delivery_address->pbbkb = $delivery_address->pbbkb *100;
                                echo  $pbbkb[ "".$delivery_address->pbbkb ] ." %"
                            ?>
                        </td>
                    </tr>
                    <?php 
                    $no++;
                    endforeach;?>
                    </tbody>
                </table>
            </div>    
      </div>
    </div>
    <!--  -->
  </section>
</div>



