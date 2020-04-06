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
        foreach( $vendors as $vendor ):
    ?>
    <!--  -->
    <div class="invoice">
        <!--  -->
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                <i class="fa fa-bookmark"></i> <?php echo $vendor->name ?>
                </h2>
            </div>
        <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Alamat
              <address>
                <strong><?php echo $vendor->address ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Telepon
              <address>
                <strong><?php echo $vendor->phone ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                No. Rekening
              <address>
                <strong><?php echo $vendor->bank_account ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Nama Bank
              <address>
                <strong><?php echo $vendor->bank_name ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Cabang Bank
              <address>
                <strong><?php echo $vendor->bank_branch ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Swift Code
              <address>
                <strong><?php echo $vendor->swift_code ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Email
              <address>
                <strong><?php echo $vendor->email ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Contact 2
              <address>
                <strong><?php echo $vendor->phone_2 ?></strong><br>
              </address>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-sm-6 invoice-col">
                Deskripsi
              <address>
                <strong><?php echo $vendor->description ?></strong><br>
              </address>
            </div>
            <!--  -->
          </div>
          <!-- /.row -->
        <!--  -->
        <!--  -->
        <div class="row">
                <div class="col-xs-12">   
                    <button type="submit" class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#edit_vendor<?php echo ( $vendor->id); ?>" >Edit Suplier</button>
                    <!-- edit_category-->
                    <div class="modal fade" id="edit_vendor<?php echo ( $vendor->id); ?>" role="dialog">
                        <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <?php echo form_open("admin/vendor/edit");?>
                            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">#Edit Suplier</h4>
                            </div>
                            <div class="modal-body">
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Nama Suplier</label>
                                    
                                        <input type="text" class="form-control"  name="name" value="<?php echo set_value("name" , $vendor->name); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Deskripsi</label>
                                    
                                        <input type="text" class="form-control"  name="description" value="<?php echo set_value("description" , $vendor->description); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Alamat</label>
                                    
                                        <input type="text" class="form-control"  name="address" value="<?php echo set_value("address" , $vendor->address); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Telepon</label>
                                    
                                        <input type="text" class="form-control"  name="phone" value="<?php echo set_value("phone" , $vendor->phone); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Email</label>
                                    
                                        <input type="text" class="form-control"  name="email" value="<?php echo set_value("email" , $vendor->email); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Contact 2</label>
                                    
                                        <input type="text" class="form-control"  name="phone_2" value="<?php echo set_value("phone_2" , $vendor->phone_2); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">No. Rekening</label>
                                    
                                        <input type="text" class="form-control"  name="bank_account" value="<?php echo set_value("bank_account" , $vendor->bank_account); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Nama Bank</label>
                                    
                                        <input type="text" class="form-control"  name="bank_name" value="<?php echo set_value("bank_name" , $vendor->bank_name); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Cabang Bank</label>
                                    
                                        <input type="text" class="form-control"  name="bank_branch" value="<?php echo set_value("bank_branch" , $vendor->bank_branch); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Swift Code</label>
                                    
                                        <input type="text" class="form-control"  name="swift_code" value="<?php echo set_value("swift_code" , $vendor->swift_code); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" class="form-control"  name="id" value="<?php echo ( $vendor->id); ?>"  />
                            <button type="submit" class="btn  btn-success">Edit</button>
                            <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
          </div>
          <!--  -->
    </div>
    <!--  -->
    <?php
        endforeach;
    ?>
</section>
</div>

