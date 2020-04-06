
    <div class="login-box">
    <div class="login-logo">
        <a href="<?php echo base_url() ?>">
          <img src="<?php echo base_url().FAVICON_IMAGE;?>" height="75px">
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <?php
        if($this->session->flashdata('alert')){
          echo $this->session->flashdata('alert');
        }else{
          echo"
          <div class='alert alert-info alert-dismissible'>
            <h4><i class='icon fa fa-globe'></i> Register </h4>
          </div>
          ";
        }
      ?>

      <?php echo form_open("");?>
        <div class="form-group has-feedback">
            <?php echo form_input($first_name);?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <?php echo form_input($last_name);?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <?php echo form_input($email);?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <?php echo form_input($phone);?>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <?php echo form_input($password);?>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <?php echo form_input($password_confirm);?>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>

