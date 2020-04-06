<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom">
        <tr >
            <th style="width:50px">No</th>
            <?php foreach( $header as $key => $value ):?>
                <th><?php echo $value ?></th>
            <?php endforeach;?>
            <?php if( isset( $action ) ):?>
                <th><?php echo "Aksi" ?></th>
            <?php endif;?>
        </tr>
        </thead>
        <tbody>
        <?php 
            foreach( $rows as $ind => $row ):
        ?>
        <tr >
            <td> <?php echo $ind+1 ?> </td>
            <?php foreach( $header as $key => $value ):?>
                <td  >
                    <?php 
                        $attr = "";
                        if( is_numeric( $row->$key ) && ( $key != 'phone' && $key != 'username' ) )
                            $attr = number_format( $row->$key );
                        else
                            $attr = $row->$key ;
                        if( $key == 'date' || $key == 'create_date' )
                            $attr =  date("d/m/Y", $row->$key ) ;

                        echo $attr;
                    ?>
                </td>
            <?php endforeach;?>
            <?php if( isset( $action ) ):?>
                <td>
                    <!--  -->
                    <?php 
                        foreach ( $action as $ind => $value) {
                            switch( $value['type'] ){
                                case "link" :
                                        $value["data"] = $row;
                                        $this->load->view('templates/actions/link', $value ); 
                                    break;
                                case "modal_delete" :
                                        $value["data"] = $row;
                                        $this->load->view('templates/actions/modal_delete', $value ); 
                                    break;
                                case "modal_form" :
                                        $value["data"] = $row;
                                        $this->load->view('templates/actions/modal_form', $value ); 
                                    break;
                            }
                        }
                    ?>
                    <!--  -->
                </td>
            <?php endif;?>
        </tr>
        <?php 
            endforeach;
        ?>
        </tbody>
    </table>
</div>  
