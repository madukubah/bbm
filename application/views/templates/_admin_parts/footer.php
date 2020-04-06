
  </div>  

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url();?>assets/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url();?>assets/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url();?>assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url();?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url();?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url();?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url();?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url();?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url();?>assets/dist/js/demo.js"></script>

<input type="hidden" id="site_url"  name="name" value="<?php echo site_url(); ?>"  />
<!-- <script src="<?php echo base_url();?>assets/jquery.js"></script> -->
<script type="text/javascript">
  $(document).ready(function(){
    function get_purchase_order(){
        url = $("#site_url").val()+"api/purchase_order/count_unprocess/";
          // console.log( url );
        $.get(url, function(data, status){
          console.log( data );
          label = ( data > 0 ) ? "<small class='label pull-right bg-red'>"+data+"</small>" : "";
          $("#notif_purchase_order").html( label );
          setTimeout(function(){ 
            get_purchase_order(  );
           }, 10000);

        });
    }
      get_purchase_order(  );
  });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("form").keypress(function(e) {
      //Enter key
      if (e.which == 13) {
        return false;
      }
    });
  });
</script>
<script src="<?php echo base_url();?>assets/cropie/croppie.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/cropie/croppie.css">

<script type="text/javascript">
    var $uploadCrop,
    tempFilename,
    rawImg,
    imageId;
    function readFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                rawImg = e.target.result;
                $('.upload-demo').addClass('ready');
                $('#cropImagePop').modal('show');
                $uploadCrop.croppie('bind', {
                    url: e.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
        else {
            swal("Sorry - you're browser doesn't support the FileReader API");
        }
    }
    
    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 360/1.8,height: 360/1.8
        },
        boundary: {
                width: 460/1.8,height: 460/1.8
        },
    });
    

    $('.item-img').on('change', function () {
        imageId = $(this).data('id'); tempFilename = $(this).val(); 

        $('#cancelCropBtn').data('id', imageId); 

        readFile(this); 
    });

    $('#cropImageBtn').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'base64',
            format: 'jpg',
            size: {width: 360/1.7,height: 360/1.7}
        }).then(function (resp) {
            $('#item-img-output').attr('src', resp);
            $('#image').val(resp);
            $('#cropImagePop').modal('hide');
        });
    });
    // End upload preview image
    
</script>


<script>
  $(function () {

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
    //Date picker
    $('#datepicker2').datepicker({
      autoclose: true
    })


    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<!--  -->


</body>
</html>
