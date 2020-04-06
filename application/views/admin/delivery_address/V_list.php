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
    <?php 
        $no =1;
        $customers = array();
        foreach( $companies as $company ):
    ?>
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-md-2">
                    <h4>Nama Perusahaan </h4>
                </div>
                <div class="col-md-6">
                    <h4> : <?php echo $company->name." ( ".$company->user->username." ) ";?></h4>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn  pull-right btn-primary" data-toggle="modal" data-target="#add_delivery_addr<?php echo $company->id; ?>" >Tambah Alamat Serah </button>
                    <!-- edit_category-->
                    <div class="modal fade" id="add_delivery_addr<?php echo $company->id; ?>" role="dialog">
                        <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <?php echo form_open("admin/delivery_address/add");?>
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">#Tambah Alamat Serah</h4>
                            </div>
                            <div class="modal-body">
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="control-label">Nama Alamat Serah</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"  name="name" value="<?php echo set_value("name"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="control-label">Kode Pos</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"  name="postal_code" value="<?php echo set_value("postal_code"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="control-label">Kota</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"  name="city" value="<?php echo set_value("city"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="" class="control-label">Provinsi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control"  name="province" value="<?php echo set_value("province" ); ?>" />
                                        
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control" value="<?php echo  $company->id ?>" name="company_id" required="required">
                            <input type="hidden" class="form-control" value="<?php echo  $company->user_id ?>" name="user_id" required="required">
                            <button type="submit" class="btn  btn-success">Tambah</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        </div>
                    </div>
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
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    // $customers = array();
                    foreach( $company->delivery_addresses as $delivery_address ):
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
                            <button type="submit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit_delivery_addr<?php echo $delivery_address->id; ?>" >Edit </button>
                            <!-- edit_category-->
                            <div class="modal fade" id="edit_delivery_addr<?php echo $delivery_address->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/delivery_address/edit");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Edit Alamat Serah</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="" class="control-label">Nama Alamat Serah</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name", $delivery_address->name); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="" class="control-label">Kode Pos</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control"  name="postal_code" value="<?php echo set_value("postal_code", $delivery_address->postal_code); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="" class="control-label">Kota</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control"  name="city" value="<?php echo set_value("city", $delivery_address->city); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="" class="control-label">Provinsi</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control"  name="province" value="<?php echo set_value("province", $delivery_address->province ); ?>" />
                                                
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control" value="<?php echo  $delivery_address->id ?>" name="id" required="required">
                                    <button type="submit" class="btn  btn-success">Edit</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                </div>
                            </div>
                            <!--  -->
                            <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#delete_modal<?php echo $delivery_address->id?>">
                                <i class="ace-icon fa fa-trash bigger-120 red"></i>
                            </button>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="delete_modal<?php echo $delivery_address->id;?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/delivery_address/delete");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Delete </h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="alert alert-danger">Anda yakin ingin menghapus <b><?php echo $delivery_address->code?></b>?</div>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $delivery_address->id ?>" name="id" required="required">
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
      </div>
    </div>
    <?php endforeach;?>
</section>
</div>