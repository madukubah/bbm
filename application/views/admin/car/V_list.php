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
            <button type="submit" class="btn  pull-right btn-primary" data-toggle="modal" data-target="#add_car" >Tambah Kendaraan</button>
            <!-- edit_category-->
            <div class="modal fade" id="add_car" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <?php echo form_open("admin/car/add");?>
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">#Tambah Kendaraan</h4>
                    </div>
                    <div class="modal-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Transportir</label>
                           
                                <input type="text" class="form-control"  name="brand" value="<?php echo set_value("brand"); ?>"  />
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Nomor Plat</label>
                            
                                <input type="text" class="form-control"  name="plat_number" value="<?php echo set_value("plat_number"); ?>"  />
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Kapasitas</label>
                           
                                <input type="number" class="form-control"  name="capacity" value="<?php echo set_value("capacity"); ?>"  />
                            </div>
                        </div>
                        <!--  -->
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn  btn-success">Tambah</button>
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
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Transportir</th>
                        <th>Nomor Plat</th>
                        <th>Kapasitas ( Liter ) </th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    // $cars = array();
                    foreach( $cars as $car ):
                    ?>
                    <tr  >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $car->brand  ?>
                        </td>
                        <td>
                            <?php echo $car->plat_number  ?>
                        </td>
                        <td>
                            <?php echo $car->capacity  ?>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit_car<?php echo $car->id; ?>" >Edit </button>
                            <!-- edit_category-->
                            <div class="modal fade" id="edit_car<?php echo $car->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/car/edit");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Edit Kendaraan</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Merk Kendaraan</label>
                                            
                                                <input type="text" class="form-control"  name="brand" value="<?php echo set_value("brand" ,$car->brand); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Nomor Plat</label>
                                            
                                                <input type="text" class="form-control"  name="plat_number" value="<?php echo set_value("plat_number",$car->plat_number); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Kapasitas</label>
                                            
                                                <input type="number" class="form-control"  name="capacity" value="<?php echo set_value("capacity",$car->capacity); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control" value="<?php echo  $car->id ?>" name="id" required="required">
                                    <button type="submit" class="btn  btn-success">Edit</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                </div>
                            </div>
                            <!--  -->
                            <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#delete_car<?php echo $car->id?>">
                                <i class="ace-icon fa fa-trash bigger-120 red"></i>
                            </button>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="delete_car<?php echo $car->id;?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/car/delete");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Delete </h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="alert alert-danger">Anda yakin ingin menghapus <b><?php echo $car->plat_number?></b>?</div>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $car->id ?>" name="id" required="required">
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
<!--  -->
</section>
</div>

