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
    	<title>Ver Ciudad || Disitrito | <?=$settings['app_name']?> - Dashboard</title>
    </head>
	<?php 
		
		
			if(isset($_GET['id'])){
				$ID = $_GET['id'];
			}else{
				$ID = "";
			}
		
					$db->select('area','*',null,"city_id = $ID and name!='Elige tu área'");
					$res=$db->getResult();
		
			?>
			<?php
			if($db->numRows($result)==0)
			{?>
			<div class="content-wrapper">
				<section class="content-header">
          <h1>
		  No hay Distritos disponibles
            <small><a  href='ciudad.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Ver ciudades</a></small>
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
					<?php if($permissions['locations']['read']==1){?>
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Ciudad_ID : <?php echo $ID;?></h3>
                  <div class="box-tools">
                  </div>
                </div>
                <div class="box-body table-responsive">
                  <table class="table table-hover">
                    <tr>
					<th>N°.</th>
						<th>Nombre de distrito</th>
						<th>Accion</th>
                    </tr>
					<?php 
		$count=1;
			
			 foreach($res as $row){
		 ?>
		<tr>
			<td><?php echo $count; ?></td>
			<td><?php echo $row['name'];?></td>
			<td><a href="editar-distrito.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i>Editar</a></td>
		</tr>
					<?php $count++; } ?>
                  </table>
                </div>
              </div>
               <?php } else { ?>
          	<div class="alert alert-danger">No tienes permiso para ver áreas</div>
				<?php } ?>
				<a  href='ciudad.php'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Volver a las ciudades</a>
            </div>
		
          </div>

        </section>
			</div>
			<?php }?>
<?php include 'footer.php'; ?>