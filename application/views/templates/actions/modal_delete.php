<?php
    $data = ( isset( $data ) && $data != NULL )? $data : '';
    $data_param = ( $data != '' )? $data->$param : '';
?>
<button class="btn btn-danger btn-sm" style="margin-left: 5px;" data-toggle="modal" data-target="#<?php echo $modal_id.$data_param?>">
    <i class="ace-icon fa fa-trash bigger-120 red"></i>
</button>
<!-- Modal Delete-->
<div class="modal fade" id="<?php echo $modal_id.$data_param?>" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <?php echo form_open( $url );?>
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">#Delete <?php echo $title?></h4>
        </div>
        <div class="modal-body">
        <div class="alert alert-danger">Apa Anda Yakin menghapus <b><?php echo $data->$data_name?></b> ?</div>
        <!--  -->
        <?php 
            $_data["form_data"] = $form_data;
            $_data["data"] = $data;
            $this->load->view('templates/form/plain_form', $_data );  
            ?>
        <!--  -->
        </div>
        <div class="modal-footer">
        <!-- <input type="hidden" class="form-control" value="<?php echo  $data->$param ?>" name="<?php echo  $param ?>" required="required"> -->
        <button type="submit" class="btn btn-danger">Ya</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Batal</button>
        </div>
        <?php echo form_close(); ?>
    </div>
    </div>
</div>
<!--  -->