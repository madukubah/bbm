<?php
  $menus    = array();
  $customer = array(
    array(
      'menuId' => "home",
      'notifId' => "notif_home",
      'menuName' => "Beranda",
      'menuPath' => site_url("user/"),
      'menuIcon' => "fa fa-file-archive-o",
      'child' => array(),
    ),
    array(
      'menuId' => "company",
      'notifId' => "notif_company",
      'menuName' => "Perusahaan Saya",
      'menuPath' => site_url("user/company"),
      'menuIcon' => "fa fa-building",
      'child' => array(),
    ),
    array(
      'menuId' => "purchase_order",
      'notifId' => "notif_purchase_order",
      'menuName' => "Purchase Order",
      'menuPath' => site_url("user/purchase_order"),
      'menuIcon' => "fa fa-bookmark",
      'child' => array(),
    ),
    array(
      'menuId' => "invoice",
      'notifId' => "notif_invoice",
      'menuName' => "Invoice",
      'menuPath' => site_url("user/invoice"),
      'menuIcon' => "fa fa-bookmark",
    ),
  );
  $driver = array(
    array(
      'menuId' => "home",
      'notifId' => "notif_home",
      'menuName' => "Beranda",
      'menuPath' => site_url("user/"),
      'menuIcon' => "fa fa-file-archive-o",
      'child' => array(),
    ),
    array(
      'menuId' => "delivery_order",
      'notifId' => "notif_delivery_order",
      'menuName' => "Delivery Order",
      'menuPath' => site_url("user/delivery_order"),
      'menuIcon' => "fa fa-building",
      'child' => array(),
    ),
  );

  if( $this->ion_auth->in_group("customers" ) )
  {
    $menus = $customer;
  }
  else if( $this->ion_auth->in_group("driver" ) )
  {
    $menus = $driver;
  }

?>
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
          <img class="img-circle" src="<?php  echo $a =  ( !($this->session->userdata('user_image')) ) ?  base_url(FAVICON_IMAGE)  : base_url('uploads/users_photo/').$this->session->userdata('user_image') ?>" />
      </div>
      <div class="pull-left info">
        <?php echo $this->session->userdata('user_profile_name')?>
      </div>
    </div>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->

    <?php 
        function print_tree( $_datas ) {
          $have_child = array(
            '',
            '<i class="fa fa-angle-left pull-right"></i>',
            '',
            'treeview'
          );
    ?>
          <?php
            foreach($_datas as $_data):
          ?>
            <li id="<?php echo $_data['menuId'] ?>" class="<?php  echo $have_child[ ( !empty( $_data['child'] ) ) + 2 ]  ?>  " >
              <a href="<?php echo $_data['menuPath'] ?>">
                <i class="<?php echo $_data['menuIcon'] ?>"></i> <span><?php echo $_data['menuName'] ?></span>
                <span id="<?php echo $_data['notifId'] ?>" class="pull-right-container">
                  <small class="label pull-right bg-green"></small>
                </span>
                <span class="pull-right-container">
                  <?php echo $have_child[ ( !empty( $_data['child'] ) ) + 0 ] ?>
                </span>
              </a>
              <ul class="treeview-menu" style="display: none;" >
                  <?php print_tree( $_data['child'] ) ; ?>
              </ul>
            </li>
          <?php
              endforeach;
          ?>
    <?php 
        }
    ?>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        <?php print_tree( $menus ) ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
<script type="text/javascript">
    function menuActive( id ){
        // return false;
        // var a =document.getElementById("menu").children[num-1].className="active";
        if( id == "" )
          var a =document.getElementById("home").className="active";
        else
          var a =document.getElementById(id).className="active";
        console.log(a);
    }
</script>




