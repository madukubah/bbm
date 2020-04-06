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
            <button type="submit" class="btn  pull-right btn-primary" data-toggle="modal" data-target="#add_product" >Tambah Produk</button>
            <!-- edit_category-->
            <div class="modal fade" id="add_product" role="dialog">
                <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <?php echo form_open("admin/product/add");?>
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">#Tambah Produk</h4>
                    </div>
                    <div class="modal-body">
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Nama Produk</label>
                           
                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name"); ?>"  />
                            </div>
                        </div>
                        <!--  -->
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="" class="control-label">Deskripsi</label>
                            
                                <input type="text" class="form-control"  name="description" value="<?php echo set_value("description"); ?>"  />
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
                        <th>Nama Produk</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    // $customers = array();
                    foreach( $products as $product ):
                    ?>
                    <tr >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $product->name?>
                        </td>
                        <td>
                            <?php echo $product->description  ?>
                        </td>
                        <td>
                            <a href="<?php echo site_url('admin/product/detail/').$product->id ?>" class="btn btn-sm btn-primary">Detail</a>
                            <button type="submit" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit_product<?php echo ( $product->id); ?>" >Edit Produk</button>
                            <!-- edit_category-->
                            <div class="modal fade" id="edit_product<?php echo ( $product->id); ?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/product/edit");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Edit Produk</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Nama Produk</label>
                                            
                                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name" , $product->name); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Deskripsi</label>
                                           
                                                <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" , $product->description); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control"  name="id" value="<?php echo ( $product->id); ?>"  />
                                    <button type="submit" class="btn  btn-success">Edit</button>
                                    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                                </div>
                            </div>
                            <!--  -->
                            <!--  -->
                            <button class="btn btn-white btn-danger btn-bold btn-sm" data-toggle="modal" data-target="#delete_product<?php echo $product->id?>">
                                <i class="ace-icon fa fa-trash bigger-120 red"></i>
                            </button>
                            <!-- Modal Delete-->
                            <div class="modal fade" id="delete_product<?php echo $product->id;?>" role="dialog">
                                <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <?php echo form_open("admin/product/delete");?>
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">#Delete </h4>
                                    </div>
                                    <div class="modal-body">
                                    <div class="alert alert-danger">Anda yakin ingin menghapus <b><?php echo $product->name?></b>?</div>
                                    </div>
                                    <div class="modal-footer">
                                    <input type="hidden" class="form-control" value="<?php echo  $product->id ?>" name="id" required="required">
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