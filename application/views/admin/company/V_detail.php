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
                        <!-- - -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="" class="control-label">PPH 0.3 %</label>
                            </div>
                            <div class="col-md-8">
                            <input type="text" class="form-control"   value="<?php echo ( $company->pph * 100 )  ?> %" readonly/>
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
                <div class="col-md-10">
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
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Nama Alamat Serah</label>
                                   
                                        <input type="text" class="form-control"  name="name" value="<?php echo set_value("name"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Kode Pos</label>
                                    
                                        <input type="text" class="form-control"  name="postal_code" value="<?php echo set_value("postal_code"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Kota</label>
                                   
                                        <input type="text" class="form-control"  name="city" value="<?php echo set_value("city"); ?>"  />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Provinsi</label>
                                    
                                        <input type="text" class="form-control"  name="province" value="<?php echo set_value("province" ); ?>" />
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">PBBKB ( % )</label>
                                    
                                        <?php 
                                            $pbbkb_options= array(
                                                'name' => 'pbbkb',
                                                'id' => 'pbbkb',
                                                'type' => 'float',
                                                'placeholder' => 'pbbkb',
                                                'class' => 'form-control',
                                                'options' => array( 
                                                    ( 0)=>"17.17 %",  
                                                    ( 1 )=>"80 %",  
                                                    ( 2 )=>"90 %",  
                                                    ( 3 )=>"100 %",  
                                                ),
                                            );
                                        ?>
                                        <?php echo form_dropdown( $pbbkb_options )  ?>
                                    </div>
                                </div>
                                <!--  -->
                                <!-- - -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Diskon ( % ) </label>
                                    
                                        <input type="float" class="form-control"  name="discount" value="<?php echo set_value("discount" ); ?>" />
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
                        <th>PBBKB</th>
                        <th>Diskon</th>
                        <th>Action</th>
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
                                // echo $delivery_address->pbbkb;
                                echo  $pbbkb[ "".$delivery_address->pbbkb  ] ." %";
                            ?>
                        </td>
                        <td>
                            <?php 
                                $delivery_address->discount = $delivery_address->discount *100;
                                echo $delivery_address->discount." %"
                            ?>
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
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Nama Alamat Serah</label>
                                            
                                                <input type="text" class="form-control"  name="name" value="<?php echo set_value("name", $delivery_address->name); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Kode Pos</label>
                                            
                                                <input type="text" class="form-control"  name="postal_code" value="<?php echo set_value("postal_code", $delivery_address->postal_code); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Kota</label>
                                            
                                                <input type="text" class="form-control"  name="city" value="<?php echo set_value("city", $delivery_address->city); ?>"  />
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Provinsi</label>
                                            
                                                <input type="text" class="form-control"  name="province" value="<?php echo set_value("province", $delivery_address->province ); ?>" />
                                                
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">PBBKB ( % )</label>
                                            
                                                <?php 
                                                    $pbbkb_options= array(
                                                        'name' => 'pbbkb',
                                                        'id' => 'pbbkb',
                                                        'type' => 'text',
                                                        'placeholder' => 'pbbkb',
                                                        'class' => 'form-control',
                                                        'options' => array( 
                                                            ( 0)=>"17.17 %",  
                                                            ( 1 )=>"80 %",  
                                                            ( 2 )=>"90 %",  
                                                            ( 3 )=>"100 %",  
                                                        ),
                                                        // 'selected' => $delivery_address->pbbkb
                                                    );
                                                ?>
                                                <?php echo form_dropdown( $pbbkb_options )  ?>
                                            </div>
                                        </div>
                                        <!--  -->
                                        <!-- - -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="" class="control-label">Diskon ( % ) </label>
                                            
                                                <input type="float" class="form-control"  name="discount" value="<?php echo set_value("discount", $delivery_address->discount ); ?>" />
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control" value="<?php echo  $delivery_address->id ?>" name="id" required="required">
                                        <input type="hidden" class="form-control" value="<?php echo  $delivery_address->company_id ?>" name="company_id" required="required">
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
                                    <input type="hidden" class="form-control" value="<?php echo  $delivery_address->company_id ?>" name="company_id" required="required">
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



