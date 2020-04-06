<div  class="table-responsive ">
    <table class="table table-striped table-bordered table-hover  ">
        <thead class="thin-border-bottom">
        <tr >
            <th style="width:50px">No</th>
            <?php foreach( $header as $key => $value ):?>
                <th><?php echo $value ?></th>
            <?php endforeach;?>
        </tr>
        </thead>
        <tbody>
        <?php 
            $sum = 0;
            foreach( $rows as $ind => $row ):
                $sum = $sum +  $row->total;
        ?>
        <tr >
            <td> <?php echo $ind+1 ?> </td>
            <?php foreach( $header as $key => $value ):?>
                <td  >
                    <?php
                        
                        $attr = "";
                        if( is_numeric( $row->$key ) && ( $key != 'delivery_address_code' ) )
                            $attr = number_format( $row->$key );
                        else
                            $attr = $row->$key ;
                        if( $key == 'date' || $key == 'create_date' )
                            $attr =  date("d/m/Y", $row->$key ) ;

                        echo $attr;
                    ?>
                </td>
            <?php endforeach;?>
        </tr>
        <?php 
            endforeach;
        ?>
        <tr >
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>.</td>
            <td>Total : </td>
            <td><?php echo number_format( $sum )?></td>
        </tr>
        </tbody>
    </table>
</div>  
