<?php
  $menus = array(
    array(
      'menuId' => "home",
      'notifId' => "notif_home",
      'menuName' => "Beranda",
      'menuPath' => site_url("admin/"),
      'menuIcon' => "fa fa-file-archive-o",
      'child' => array(),
    ),
    array(
      'menuId' => "vendor",
      'notifId' => "notif_vendor",
      'menuName' => "Suplier",
      'menuPath' => site_url("admin/vendor"),
      'menuIcon' => "fa fa-home",
      'child' => array(),
    ),
    array(
      'menuId' => "user_management",
      'notifId' => "notif_user_management",
      'menuName' => "Kelola User",
      'menuPath' => site_url("admin/user_management"),
      'menuIcon' => 'fa fa-users',
      'child' => array(
                    array(
                      'menuId' => "user_management_add",
                      'notifId' => "notif_user_management_add",
                      'menuName' => "Tambah User",
                      'menuPath' => site_url("admin/user_management/add"),
                      'menuIcon' => "fa fa-plus",
                      'child' => array(),
                    ),
                    array(
                      'menuId' => "user_management_admin",
                      'notifId' => "notif_user_management_admin",
                      'menuName' => "Admin",
                      'menuPath' => site_url("admin/user_management/admin/"),
                      'menuIcon' => "fa fa-users",
                      'child' => array(),
                    ),
                    array(
                      'menuId' => "user_management_customer",
                      'notifId' => "notif_user_management_customer",
                      'menuName' => "Customers",
                      'menuPath' => site_url("admin/user_management/customer/"),
                      'menuIcon' => "fa fa-users",
                      'child' => array(),
                    ),
                    array(
                      'menuId' => "user_management_driver",
                      'notifId' => "notif_user_management_driver",
                      'menuName' => "Driver",
                      'menuPath' => site_url("admin/user_management/driver/"),
                      'menuIcon' => "fa fa-users",
                      'child' => array(),
                    ),
      ),
    ),
    array(
      'menuId' => "company",
      'notifId' => "notif_company",
      'menuName' => "Perusahaan",
      'menuPath' => site_url("admin/company"),
      'menuIcon' => 'fa fa-location-arrow',
      'child' => array(),
    ),
    array(
      'menuId' => "product",
      'notifId' => "notif_product",
      'menuName' => "Produk",
      'menuPath' => site_url("admin/product"),
      'menuIcon' => 'fa fa-sun-o',
      'child' => array(),
    ),
    array(
      'menuId' => "car",
      'notifId' => "notif_car",
      'menuName' => "Kendaraan",
      'menuPath' => site_url("admin/car"),
      'menuIcon' => "fa fa-truck",
      'child' => array(),
    ),
    array(
      'menuId' => "purchase_order",
      'notifId' => "notif_purchase_order",
      'menuName' => "Purchase Order",
      'menuPath' => site_url("admin/purchase_order"),
      'menuIcon' => "fa fa-bookmark",
      'child' => array(),
    ),
    array(
      'menuId' => "invoice",
      'notifId' => "notif_invoice",
      'menuName' => "Invoice",
      'menuPath' => site_url("admin/invoice"),
      'menuIcon' => "fa fa-bookmark",
      'child' => array(),
    ),
    array(
      'menuId' => "report",
      'notifId' => "notif_report",
      'menuName' => "Rekapan",
      'menuPath' => site_url("admin/report"),
      'menuIcon' => "fa fa-bookmark",
      'child' => array(),
    ),
   
  );

  foreach($menus as $menu){
    // echo count( $menu['child'] ) > 0;
  }

  // return;

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
    function menuActive( id, method = null ){
        // return false;
        // var a =document.getElementById("menu").children[num-1].className="active";
        if( id == "" )
          var a =document.getElementById("home").classList.add("active");
        else
        {
          if( method == "index" )
          {
            menu_active = id;
          }
          else
          {
            menu_active =    id + "_" + method;      
          }
          
            document.getElementById( id ).classList.add("active");
            var a = document.getElementById( id ).classList.add("active");
            var a = document.getElementById( id ).getElementsByClassName( 'treeview-menu' )[0].style.display = "block";
            console.log( a );
            document.getElementById( menu_active ).classList.add("active");
        }
          
        console.log(id+" "+method );
    }
</script>




