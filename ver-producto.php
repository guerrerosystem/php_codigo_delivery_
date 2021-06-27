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
    include 'header.php';?>
<head>
<title>Subcategoría Productos | <?=$settings['app_name']?> - Dashboard</title>
</head>
<?php
    if(isset($_GET['id'])){
    	$ID = $_GET['id'];
    }else{
    	$ID = "";
    }
   
    $sql_query = "SELECT p.*,v.*,(SELECT short_code FROM unit u where v.measurement_unit_id=u.id) as measurement_name,(SELECT short_code FROM unit u where v.stock_unit_id=u.id) as stock_name FROM products p JOIN product_variant v ON  p.id=v.product_id WHERE p.subcategory_id = $ID";
    $db->sql($sql_query);
    $res = $db->getResult();
    ?>
<?php
    if(empty($res))
    {?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        No hay productos disponibles
            <small><a  href='subcategorias.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Volver a las subcategorías</a></small>
        </h1>
    </section>
</div>
<?php }
    else{
    ?>
<div class="content-wrapper">
    <section class="content">
      
        <div class="row">
           
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php
                            $db->select('subcategory','name',null,'id='.$ID);
                            $subcategory_name = $db->getResult();
                        ?>
                        <h3 class="box-title">Subcategoria : <?php echo $subcategory_name[0]['name'];?></h3>
                        <div class="box-tools">
                        </div>
                    </div>
                  
                    
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                             

                                <th> N°. </th>
                                 <th> Nombre </th>
                                 <th> Imagen </th>
                                 <th> Medición </th>
                                 <th> Estado </th>
                                 <th> Stock </th>
                                 <th> Precio (<?=$setting ['currency'];?>) </th>
                                 <th> Precio con descuento (<?=$settings ['currency'];?>) </th>
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
                                <td><?php echo $row['measurement']." ".$row['measurement_name'];?></td>
                                <td><?php echo $row['serve_for'];?></td>
                                <td><?php echo $row['stock']." ".$row['stock_name'];?></td>
                                <td><?php echo $row['price'];?></td>
                                <td><?php echo $row['discounted_price'];?></td>

                                <td><a href="ver-variantes-producto.php?id=<?php echo $row['product_id'];?>"><i class="fa fa-eye"></i>Ver</a> <a href="editar-producto.php?id=<?php echo $row['product_id'];?>"><i class="fa fa-edit"></i>Editar</a> <a href="delete-product.php?id=<?php echo $row['product_id'];?>"><i class="fa fa-trash"></i>Eliminar</a></td>
                            </tr>
                            <?php $count++; } ?>
                        </table>
                    </div>
                
                </div>
               
            </div>
           
        </div>
       
    </section>
    
</div>
<?php }?>
<?php $db->disconnect(); ?>
<?php include 'footer.php'; ?>