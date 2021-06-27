<?php 
    
session_start();
    
    
    $currentTime = time() + 25200;
    $expired = 3600;
    
    
    if(!isset($_SESSION['user'])){
        header("location:index.php");
    }
    
    
    if($currentTime > $_SESSION['timeout']){
        session_destroy();
        header("location:index.php");
    }
    
 
    unset($_SESSION['timeout']);
    $_SESSION['timeout'] = $currentTime + $expired;
    include 'header.php';
    ?>
    <head>
        <title>Subcategoría Productos| <?=$settings['app_name']?> - Dashboard</title>
    </head>
    <?php
	
    if(isset($_GET['id'])){
    	$ID = $_GET['id'];

    }else{
    	$ID = "";
    }
    $sql = "SELECT p.*,v.*,v.id as variant_id,(SELECT short_code FROM unit u where u.id=v.measurement_unit_id)as mesurement_unit_name,(SELECT short_code FROM unit u where u.id=v.stock_unit_id)as stock_unit_name FROM products p JOIN product_variant v ON v.product_id=p.id where p.id=".$ID;
     $db->sql($sql);
    $res=$db->getResult();
    ?>
<?php
    if($db->numRows($result)==0)
    {?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        No hay variantes disponibles
            <small><a  href='productos.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Productos</a></small>
        </h1>
    </section>
</div>
<?php }
    else{
    ?>
<div class="content-wrapper">
    <?php
    if($permissions['products']['read']==1) { ?>
    <section class="content">
       
        <div class="row">
            
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php
                         
                        $sql="SELECT name FROM products WHERE id=".$ID;
                        $db->sql($sql);

                            $product_name = $db->getResult();
                        ?>
                        <h3 class="box-title">Producto : <?php echo $product_name[0]['name'];?><small><a  href='productos.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;ver productos</a></small></h3>
                        <div class="box-tools">
                        </div>
                    </div>
                   
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                

                                  <th> N°</th>
                                 <th> Nombre </th>
                                 <th> Imagen </th>
                                 <th> Medición </th>
                                 <th> Estado </th>
                                 <th> Stock </th>
                                 <th> Precio (<?=$settings['currency']?>) </th>
                                 <th> Precio con descuento (<?=$settings['currency']?>) </th>
                                 <th> Acción </th>
                            </tr>
                            <?php 

                               
                                $count=1;
                                	
                                	foreach($res as $row){
                                    
                                 ?>
                            <tr>
                                <td><?php echo $count; ?></td>
                                <td><?php echo $row['name'];?></td>
                                <td width="10%"><img src="<?php echo $row['image']; ?>" width="60" height="40"/></td>
                                <td><?php echo $row['measurement']." ".$row['mesurement_unit_name'];?></td>
                                <td><?php echo $row['serve_for'];?></td>
                                <td><?php echo $row['stock']." ".$row['stock_unit_name'];?></td>
                                <td><?php echo $row['price'];?></td>
                                <td><?php echo $row['discounted_price'];?></td>
                                <td><a href="detalle-producto.php?id=<?php echo $row['variant_id'];?>"><i class="fa fa-folder-open"></i>Ver</a> <a href="editar-producto.php?id=<?php echo $row['product_id'];?>"><i class="fa fa-edit"></i>Editar</a></td>


                            </tr>
                            <?php $count++; } ?>
                        </table>
                    </div>
                
                </div>
               
            </div>
           
        </div>
       
    </section>
    <?php } else {?>
        <div class="alert alert-danger topmargin-sm">No tiene permiso para ver la variante del producto.</div>
    <a  href='productos.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Volver a productos</a>
    <?php } ?>
   
</div>
<?php }?>
<?php $db->disconnect(); ?>
<?php include 'footer.php'; ?>