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
  <section id="content" class="content" >
    <div class="invoice">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-bookmark"></i> SOA
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Dari
              <address>
                <strong><?php echo $company->name ?></strong><br>
                Alamat Serah : <?php echo $delivery_address->name." ( ".$delivery_address->code." ) "; ?> <br>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              Ke
              <address>
              <strong><?php echo $vendor->name ?></strong><br>
              </address>
            </div>
          </div>
          <!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Material</th>
                  <th>Jumlah</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><?php echo $material->name ?></td>
                  <td><?php echo  number_format($quantity)." ".( $material->unit ) ?></td>
                </tr>
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    </div>
    
    <div class="row">
        <div class="col-xs-12">
          <!--  -->
          <div class="invoice">
            <div class="row">
                <div class="col-xs-3">
                    <label for="" class="control-label">Jumlah Trip</label>
                </div>
                <div class="col-xs-6">
                      <div class="row">
                          <div class="col-xs-3">
                                <button id="add" class="btn btn-primary" >+</button>
                          </div>
                          <div class="col-xs-3" id="trips" value="1" >
                                1
                          </div>
                          <div class="col-xs-3">
                                <button id="subtract"  class="btn btn-danger" >-</button>
                          </div>
                      </div>
                </div>
                <div class="col-xs-3">
                      <div class="row">
                          <div class="col-xs-3">
                              <h5>
                                  <b>sisa : </b>
                              </h5>
                          </div>
                          <div class="col-xs-3"  value="1" >
                              <h5  >
                                  <b id="_quantity_leftovers" > </b>
                              </h5>
                          </div>
                      </div>
                </div>
            </div>
          </div>
          <!--  -->
        </div>
    </div>
    <!--  -->
    <div id="message" class="invoice alert alert-danger alert-dismissible " >
    </div>
    <!--  -->

    <?php echo form_open("admin/delivery_order/create");?>
    <input type="hidden"   name="purchase_order_id" value="<?php echo $purchase_order_id; ?>"  />
    <!--  -->
    <div id="delivery_order" >
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr >
                                <th>SOA Pertamina</th>
                                <th>Kuantitas</th>
                                <th>kendaraan</th>
                                <th>Kapasitas kendaraan</th>
                                <th>Driver</th>
                                <th>Uang Jalan (Rp) </th>
                            </tr>
                            </thead>
                            <tbody id="do_body" >

                            </tbody>
                        </table>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <div class="invoice">
      <div class="row">
            <div class="col-xs-12">   
                <input type="hidden"  name="base_quantity" value="<?php echo $quantity; ?>"  />
                <button id="submit_do" type="submit" class="btn btn-md btn-primary pull-right"  >Kirim</button>
            </div>
      </div>
    </div>
    <!--  -->
    <?php echo form_close(); ?>
    
  </section>
</div>
<textarea style="display:none" id="cars" >
        <?php echo json_encode($cars) ; ?>
</textarea>
<textarea style="display:none" id="drivers" >
        <?php echo json_encode($drivers) ; ?>
</textarea>
<input type="hidden" id="address_name"  name="name" value="<?php echo $delivery_address->name." ( ".$delivery_address->code." ) ";; ?>"  />
<input type="hidden" id="quantity_leftovers"  name="name" value="<?php echo $quantity; ?>"  />
<input type="hidden" id="site_url"  name="name" value="<?php echo site_url(); ?>"  />
<script src="<?php echo base_url();?>assets/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var messages = [];
  var trips = 0;
  var quantity_leftovers = $("#quantity_leftovers").val().trim();
  var cars = JSON.parse( $("#cars").val().trim() ) ;
  var drivers = JSON.parse( $("#drivers").val().trim() ) ;

  $("#trips").html( trips );
  $("#message").hide();
  $("#_quantity_leftovers").html( quantity_leftovers );
  
    $("#add").click(function(){
        if( trips + 1 > cars.length ){
            alert('tidak ada lagi kendaraan');
            return;
        } 
        trips++;
        $("#trips").html( trips );
        html = get_form();
        $('#do_body').append(html);
    });
    $("#subtract").click(function(){
        if( trips - 1 >0 ) trips--;
        length = $('#do_body').children().length;
        if( length > 1 ) $('#do_body').children().last().remove();

        $("#trips").html( trips );
    });
    $("#content").on('click','.hapus',function(){
          if( trips - 1 > 0 )
          {
            trips--;
            $("#trips").html( trips );
            $(this).parent().parent().remove() ;
          }
          return false;
    });
    $("#content").on('change','select[name="car_id[]"]',function(){
          pos = cars.map(function(e) { return e.id; }).indexOf( $(this).val()  );
          $(this).parent().parent().find( 'input[name="capacity"]' ).val( cars[pos].capacity ) ;

          quantityUpdate( $(this) );
    });
    $("#content").on('change','select[name="user_id[]"]',function(){
          quantityUpdate( $(this) );
    });
    $("#content").on('change','input[name="quantity[]"]',function(){
          quantityUpdate(  $(this) );
    });

    $("#content").on('click',function(){
        validationForm();
    });
    $("#content").on('change',function(){
        validationForm();
    });
    function validationForm()
    {
        driverCheck(  );
        quantitySync();
        clearMessage(  );
        if( ( carCheck(  ) &&  driverCheck(  ) && quantitySync() ) )
        {
          $("#message").hide();
          $("#submit_do").attr("disabled", false)
        }
        else
        {
          $("#message").show();
          $("#submit_do").attr("disabled", true)
          
          $("#message").html( getMessage(  ) );
        }
    }
    function quantityUpdate( element )
    {
      quantityElem = element.parent().parent().find( 'input[name="quantity[]"]' );
      quantity = parseInt( element.parent().parent().find( 'input[name="quantity[]"]' ).val(  )  );
      capacity = parseInt( element.parent().parent().find( 'input[name="capacity"]' ).val(  ) );
      if( quantity > capacity ) quantityElem.val( capacity ) ;
    }
    function quantitySync(  )
    {
        quantities = $( 'input[name="quantity[]"]' );
        values =0;
        
        quantities.each(function() {
            values += parseInt( $(this).val() );
        });
        console.log( values );
        

        $("#_quantity_leftovers").html( quantity_leftovers - values );

        if( quantity_leftovers - values != 0 )
        {
          $("#_quantity_leftovers").parent().parent().parent().attr("style","background-color: #f7c8c8 !important");
          setMessage( "Sisa harus Nol" );
          return false;
        }
        else
        {
          $("#_quantity_leftovers").parent().parent().parent().removeAttr( "style" );
          return true;
        }
    }
    function carCheck(  )
    {
      result = true;
        _cars = $( 'select[name="car_id[]"]' );
        // console.log( _cars );
        values =0;
        var carArray= [];

        _cars.each(function() {
            if( carArray.indexOf( $(this).val() ) != -1 )
            {
                $(this).parent().attr("style","background-color: #f7c8c8 !important");
                result = false;
            }
            else{
              $(this).parent().removeAttr("style");
              carArray.push( $(this).val() );
            }
        });
        if( result == false ) setMessage( "Kendaraan tidak boleh sama" );

        return result;
    }
    function driverCheck( )
    {
      result = true;
        _drivers = $( 'select[name="user_id[]"]' );
        // console.log( "_drivers" + _drivers );
        values =0;
        var driversArray= [];

        _drivers.each(function() {
            if( driversArray.indexOf( $(this).val() ) != -1 )
            {
                $(this).parent().attr("style","background-color: #f7c8c8 !important");
                result = false;
            }
            else{
              $(this).parent().removeAttr("style");
              driversArray.push( $(this).val() );
            }
        });

        if( result == false ) setMessage( "Driver tidak boleh sama" );

        return result;
    }

    function get_form()
    {

        var car_select  = '';
        car_select      += '<select name="car_id[]" type="text" placeholder="Material" class=" form-control">';
                                cars.forEach(function(element) {
                                  car_select += "<option value='"+element.id+"'>"+ element.plat_number+" ("+ element.capacity +" Liter )" +"</option>"
                                });
        car_select      +=  '</select>' ;

        var driver_select  = '';
        driver_select      += '<select name="user_id[]"  type="text" placeholder="Material" class="form-control">';
                                drivers.forEach(function(element) {
                                  driver_select += "<option value='"+element.id+"'>"+ element.first_name+ " "+ element.last_name+"</option>"
                                });
        driver_select      +=  '</select>' ;

        address = $("#address_name  ").val().trim();
        
        var html = '';
        html     +=  '<tr >' ;
        html     +=     '<td>' ;
        // html     +=           address ;
        html     +=          '<input  type="text" class="form-control" min="0"  name="trip[]" value=""  />' ;
        html     +=     '</td>' ;
        html     +=     '<td>' ;
        html     +=          '<input  type="number" class="form-control" min="0"  name="quantity[]" value="100"  />' ;
        html     +=     '</td>' ;
        html     +=     '<td>' ;
        html     +=          car_select;
        html     +=     '</td>' ;
        html     +=     '<td>' ;
        html     +=          '<input readonly type="number" class="form-control"  name="capacity" value="'+cars[0].capacity+'"  />' ;
        html     +=     '</td>' ;
        html     +=     '<td>' ;
        html     +=          driver_select; 
        html     +=     '</td>' ;
        html     +=     '<td>' ;
        // html     +=          '<button id="subtract"  class="hapus btn btn-danger" >Hapus</button>' ;
        html     +=          '<input  type="number" class="form-control" min="0"  name="travel_cost[]" value=""  />' ;
        html     +=     '</td>' ;
        html     +=  '</tr>' ;
        return html;
    }
    function setMessage( message )
    {
      messages.push( message );
      console.log( 'messages : '+ messages );
    }
    function getMessage(  )
    {
      var _html = '';
      messages.forEach(function(element) {
          
          _html += "<p>"+ element +"</p>";
      });

      return _html;
    }
    function clearMessage(  )
    {
      messages = [];
    }
});
</script>