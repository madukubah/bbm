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
        <!--  -->
        <div class="box-header">
          <div class="row">
            <div class="col-xs-9">
            </div>
            <div class="col-xs-3">
                <!--  -->
                  <form action="<?php echo base_url("admin/company/")?>">
                      <div class="input-group input-group-sm">
                            <input type="text" name="search" value="<?php echo $search?>" class="form-control">
                            <span class="input-group-btn">
                              <button type="submit" class="btn btn-primary btn-flat">Cari</button>
                            </span>
                      </div>
                  </form>
                <!--  -->
            </div>
          </div>
        </div>
        <!--  -->
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr >
                        <th style="width:50px">No</th>
                        <th>Kode Customer</th>
                        <th>Nama Perusahaan</th>
                        <th>Alamat Perusahaan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no =1;
                    // $customers = array();
                    foreach( $companies as $company ):
                    ?>
                    <tr >
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $company->username?>
                        </td>
                        <td>
                            <?php echo $company->name  ?>
                        </td>
                        
                        <td>
                            <?php echo $company->address?>
                        </td>
                        <td>
                        <a href="<?php echo site_url('admin/company/detail/').$company->id ?>" class="btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                    <?php 
                    $no++;
                    endforeach;?>
                    </tbody>
                </table>
            </div>   
            <!-- Tampilkan Pagging -->
            <?php echo $links;?>  
      </div>
    </div>
<!--  -->
</section>
</div>