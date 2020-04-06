
 <?php  $this->load->library( array( 'form_validation' ) );  ?>
 <!-- - -->
 <?php foreach( $form_data as $form_name => $attr ): ?>
    <div class="row">
        <div class="col-md-12">
                <?php
                    $value = ( ( $data != NULL)? $data->$form_name : ''  );

                    $form = array(
                        'name' => $form_name,
                        'type' => $attr['type'],
                        'placeholder' => $attr['label'],
                        'class' => 'form-control',  
                        'value' => ( isset( $attr['value'] )  ) ? $attr['value'] : $value,
                    );
                    switch(  $attr['type'] )
                    {
                        case 'text':
                        case 'number':
                            echo '<label for="" class="control-label">'.$attr["label"].'</label>'.form_input( $form );
                            break;
                        case 'hidden':
                            echo form_input( $form );
                            break;
                    }
                ?>
        </div>
    </div>
<?php endforeach; ?>

<!--  -->