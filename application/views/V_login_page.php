
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
            <h4><i class='icon fa fa-globe'></i> Information!</h4>
            login
          </div>
          ";
        }
      ?>

      <?php echo form_open("");?>
        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="Username" name="identity"/>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="user_password" />
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8">
            <div class="checkbox icheck">
              <label class="">
                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;"></div>  <a href="<?php echo base_url("auth/register");?>">Register</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-box-body -->
  </div>

 