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
    <div class="box">
        <div class="box-header">
            <div class="col-md-6">
                <h4>Customers</h4>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>no HP</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;

                    foreach( $customers as $user ):
                        if(  $user->id == 1 ) continue;
                    ?>
                    <tr <?php if($user->active == 0) echo "style='background-color: #f7c8c8 !important'" ?>>
                        <td>
                            <?php echo $no?>
                        </td>
                    <td>
                            <?php echo $user->username?>
                        </td>
                        <td>
                            <?php echo $user->first_name." ".$user->last_name  ?>
                        </td>
                        
                        <td>
                            <?php echo $user->email?>
                        </td>
                        <td>
                            <?php echo $user->phone?>
                        </td>
                        <td>
                            <a href="<?php echo site_url('admin/user_management/edit/').$user->id ?>" class="btn-sm btn-primary">Edit Data</a>
                            <a href="<?php echo site_url('admin/user_management/index/').$user->id;?>" class="btn-sm btn-primary">Detail</a>
                            <button class="btn btn-white btn-danger btn-bold btn-xs" data-toggle="modal" data-target="#deleteModal<?php echo $user->id?>">
                                <i class="ace-icon fa fa-trash bigger-120 red"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- user -->
                        <!-- Modal Delete-->
                        <div class="modal fade" id="deleteModal<?php echo  $user->id;?>" role="dialog">
                            <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <?php echo form_open("admin/user_management/delete_user");?>
                                <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">#Delete User</h4>
                                </div>
                                <div class="modal-body">
                                <div class="alert alert-danger">Are you sure want delete "<b><?php echo $user->username?></b>?" ?</div>
                                </div>
                                <div class="modal-footer">
                                <input type="hidden" class="form-control" value="<?php echo  $user->id ?>" name="id" required="required">
                                <input type="hidden" class="form-control" value="<?php echo  $user->username?>" name="username" required="required">
                                <button type="submit" class="btn btn-danger">Ya</button>
                                <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                            </div>
                        </div>
                        <!--  -->
                    <?php 
                    $no++;
                    endforeach;?>
                    </tbody>
                </table>
            </div>    
      </div>
    </div>
  </section>
</div>