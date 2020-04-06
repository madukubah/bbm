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
        if( isset( $product ) ):
    ?>
    <div class="box">
        <div class="box-header">
            <div class="row">
                <div class="col-md-2">
                    <h4>Nama Produk </h4>
                </div>
                <div class="col-md-6">
                    <h4> : <?php echo $product->name;?></h4>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn  pull-right btn-primary" data-toggle="modal" data-target="#add_material<?php echo $product->id; ?>" >Tambah Material </button>
                    <!-- edit_category-->
                    <div class="modal fade" id="add_material<?php echo $product->id; ?>" role="dialog">
                        <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <?php echo form_open("admin/product/add_material");?>
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">#Tambah Material</h4>
                            </div>
                            <div class="modal-body">
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Nama Material</label>
                                   
                                        <input type="text" class="form-control"  name="name" value="<?php echo set_value("name"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Satuan</label>
                                   
                                        <input type="text" class="form-control"  name="unit" value="<?php echo set_value("unit"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Harga 1 ( tgl 1-15 )</label>
                                    
                                        <input type="number" min="0" class="form-control"  name="price_1" value="<?php echo set_value("price_1"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Harga 2 ( tgl 16-30 )</label>
                                   
                                        <input type="number" min="0" class="form-control"  name="price_2" value="<?php echo set_value("price_2" ); ?>" />
                                        
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control" value="<?php echo  $product->id ?>" name="product_id" required="required">
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
                        <th>Nama Material</th>
                        <th>Satuan</th>
                        <th>Harga 1 ( tgl 1-14 )</th>
                        <th>Harga 2 ( tgl 15-Akhir bulan )</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    foreach( $product->materials as $material ):
                    ?>
                    <tr >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $material->name?>
                        </td>
                        <td>
                            <?php echo $material->unit  ?>
                        </td>
                        
                        <td>
                            Rp <?php echo $material->price_1?>
                        </td>
                        <td>
                            Rp <?php echo $material->price_2?>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#edit_material<?php echo $material->id; ?>" >Edit </button>
                            <!-- edit_category-->
                            <div class="modal fade" id="edit_material<?php echo $material->id; ?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/product/edit_material");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Edit Produk</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Nama Material</label>
                                           
                                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name" , $material->name); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Satuan</label>
                                            
                                                <input type="text" class="form-control"  name="unit" value="<?php echo set_value("unit", $material->unit); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Harga 1 ( tgl 1-14 )</label>
                                            
                                                <input type="number" min="0" class="form-control"  name="price_1" value="<?php echo set_value("price_1", $material->price_1); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Harga 2 ( tgl 15-Akhir Bulan )</label>
                                            
                                                <input type="number" min="0" class="form-control"  name="price_2" value="<?php echo set_value("price_2" , $material->price_2); ?>" />
                                                
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control" value="<?php echo  $material->id ?>" name="id" required="required">
                                        <input type="hidden" class="form-control" value="<?php echo  $material->product_id ?>" name="product_id" required="required">
                                    <button type="submit" class="btn  btn-success">Edit</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                </div>
                            </div>
                            <!--  -->
                            <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#delete_material<?php echo $material->id?>">
                                <i class="ace-icon fa fa-trash bigger-120 red"></i>
                            </button>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="delete_material<?php echo $material->id;?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/product/delete_material");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Delete </h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="alert alert-danger">Anda yakin ingin menghapus <b><?php echo $material->name?></b>?</div>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $material->id ?>" name="id" required="required">
                                    <input type="hidden" class="form-control" value="<?php echo  $material->product_id ?>" name="product_id" required="required">
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
    <?php endif ;?>
</section>
</div>