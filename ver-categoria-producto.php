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
        <title>Categoría de productos | <?=$settings['app_name']?> - Dashboard</title>
    </head>
    <?php
	
    if(isset($_GET['id'])){
    	$ID = $_GET['id'];
    }else{
    	$ID = "";
    }
   
    $db->select('subcategory','*',null,'category_id='.$ID);
    $res=$db->getResult();
    
    ?>
<?php
     if($db->numRows($result)==0)
    {?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        No hay productos disponibles
            <small><a  href='categorias.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Regresar a las categorías</a></small>
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
                           
                            $db->select('category','name',null,'id='.$ID);
                            $category_name=$db->getResult();
                           
                        ?>
                        <h3 class="box-title">Categoria : <?php echo $category_name[0]['name'];?></h3>
                        <div class="box-tools">
                        </div>
                    </div>
                    
                    <div class="box-body table-responsive">
                        <table class="table table-hover">
                            <tr>
                                
                                <th> No. </th>
                                 <th> Nombre </th>
                                 <th> Imagen </th>
    
                                 <th> Productos </th>
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
                             
                                <td><a href="ver-subcategoria-producto.php?id=<?php echo $res[0]['id'];?>"><i class="fa fa-edit"></i>Ver</a></td>
                                <td><a href="editar-producto.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i>Editar</a></td>
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