<?php include_once('includes/crud.php');
    $db = new Database();
    $db->connect();
    $db->sql("SET NAMES 'utf8'");
    
    include('includes/variables.php');
    include_once('includes/custom-functions.php');
    $fn = new custom_functions;
    $permissions = $fn->get_permissions($_SESSION['id']);
    
    $config = $fn->get_configurations();
    if(isset($config['system_timezone']) && isset($config['system_timezone_gmt'])){
        date_default_timezone_set($config['system_timezone']);
        $db->sql("SET `time_zone` = '".$config['system_timezone_gmt']."'");
    }else{
        date_default_timezone_set('Asia/Kolkata');
        $db->sql("SET `time_zone` = '+05:30'");
    }
    
    $settings['app_name'] = $config['app_name'];
    $words = explode(" ", $settings['app_name']);
    $acronym = "";
    foreach ($words as $w) {
        $acronym .= $w[0];
    }
    
    $currency = $fn->get_settings('currency');
    $settings['currency'] = $currency;
    $role = $fn->get_role($_SESSION['id']);
    
    $sql_logo="select value from `settings` where variable='Logo' OR variable='logo'";
    $db->sql($sql_logo);
    $res_logo=$db->getResult();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/ico" href="<?='dist/img/'.$res_logo[0]['value']?>">
  
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
       
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        
        
        
        <link rel="stylesheet" href="dist/css/AdminLTE.mins.css">
        <link href="dist/css/multiple-select.css" rel="stylesheet"/>
      
        <link rel="stylesheet" href="dist/css/print.css" type="text/css" media="print">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.mins.css">
       
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
       
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css" integrity="sha256-2kJr1Z0C1y5z0jnhr/mCu46J3R6Uud+qCQHA39i1eYo=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js" integrity="sha256-CgrKEb54KXipsoTitWV+7z/CVYrQ0ZagFB3JOvq2yjo=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
               var date = new Date();
               var currentMonth = date.getMonth()-10;
               var currentDate = date.getDate();
               var currentYear = date.getFullYear()-10;
            
               $('.datepicker').datepicker({
                   minDate: new Date(currentYear, currentMonth, currentDate),
                   dateFormat: 'yy-mm-dd',
               });
            });
        </script>
        <script language="javascript">
            function printpage()
             {
              window.print();
             }
        </script>
        <link rel="stylesheet" href="plugins/morris/morris.css">
      
        <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
       
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
        
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
        
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/bootstrap-table.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.1/extensions/filter-control/bootstrap-table-filter-control.css" />
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
        
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/css/lightbox.min.css" integrity="sha256-tBxlolRHP9uMsEFKVk+hk//ekOlXOixLKvye5W2WR5c=" crossorigin="anonymous" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.1/js/lightbox.min.js" integrity="sha256-CtKylYan+AJuoH8jrMht1+1PMhMqrKnB8K5g012WN5I=" crossorigin="anonymous"></script>
    </head>
    <body class="hold-transition skin-blue fixed sidebar-mini sidebar-collapse">
        <div class="wrapper">
        <header class="main-header">
          
            <a href="home.php" class="logo">
                
                <span class="logo-mini">
                    <h2><?=$acronym?></h2>
                </span>
                
                <span class="logo-lg">
                    <h3><?=$settings['app_name']?></h3>
                </span>
            </a>
            
            <nav class="navbar navbar-static-top" role="navigation">
               
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                       
                        <?php 
                
                            $sql_query = "SELECT * FROM admin where id=".$_SESSION['id'];
                            
                            $db->sql($sql_query);
                            $result=$db->getResult();
                            foreach($result as $row)
                            {
                                $user=$row['username'];
                                $email=$row['email'];    
                            ?>  					
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="images/avatar.png" class="user-image" alt="User Image">
                            <span class="hidden-xs"><?=$user;?></span>
                            </a>
                            <ul class="dropdown-menu">
                         
                                <li class="user-header">
                                    <img src="images/avatar.png" class="img-circle" alt="User Image">
                                    <p>
                                        <?=$user;?>
                                        <small><?=$email;?></small>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="perfil-administrador.php" class="btn btn-default btn-flat"> Editar perfil</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="logout.php" class="btn btn-default btn-flat">Cerrar sesi¨®n</a>
                                    </div>
                                </li>
                             
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
       
        <aside class="main-sidebar">
            
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <!-- <div class="user-panel">
                    <div class="pull-left image">
                      <img src="images/avatar.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                      <p><?//=$user;?></p>
                    <?php }?>
                      <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                    </div>-->
             
                <ul class="sidebar-menu">
                    <li class="treeview">
                        <a  href="home.php">
                        <i class="fa fa-home" class="active"></i> <span>Home</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="pedidos.php">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Pedidos</span>
                        </a>
                    </li>
                    <li>
                        <a href="categorias.php">
                        <i class="fa fa-bullseye"></i> <span>Categorias</span>
                        </a>
                    </li>
                    <li>
                        <a href="subcategorias.php">
                        <i class="fa fa-bullseye"></i> <span>Sub Categorias</span>
                        </a>
                    </li>

                    <li class="treeview">
                        <a href="#">
                        <i class="fa fa-cubes"></i>
                        <span>Productos</span>
                        <i class="fa fa-angle-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="agregar-productos.php"><i class="fa fa-plus"></i> Agregar Producto</a></li>
                            <li><a href="productos.php"><i class="fa fa-sliders"></i> administrar productos</a></li>
                        
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="imagen-slider.php">
                        <i class="fa fa-picture-o"></i>
                        <span>Imagenes Eslider</span>
                        </a>
                    </li>
                    
                 
                 
                   <li class="treeview">
                        <a href="#">
                        <i class="fa fa-male"></i>
                        <span>Clientes</span>
                        <i class="fa fa-angle-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="clientes.php"><i class="fa fa-users"></i> Clientes </a></li>
                           
                           
                        </ul>
                    </li>
                   
                 

                    <li class="treeview">
                        <a href="#">
                        <i class="fa fa-male"></i>
                        <span>Repartidors</span>
                        <i class="fa fa-angle-right pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="repartidores.php"><i class="fa fa-line-chart"></i> Administrar repartidores </a></li>
                       
                           
                        </ul>
                    </li>

                   
                  
                   
                 
                    
                  
                  
                   
                    <?php
                    if($role == 'admin' || $role == 'super admin' ){
                    ?>
                    
                    <?php } ?>
                </ul>
            </section>
           
        </aside>
    </body>
</html>