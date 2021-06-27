
<?php include"header.php";?>
<html>
<head>
<title>Términos y condiciones | <?=$settings['app_name']?> - Dashboard</title>
</head>
</body>
    
      <div class="content-wrapper">
        <?php 
            	$sql = "SELECT * FROM settings";
                $db->sql($sql);
                $res = $db->getResult();
            	$message = '';
            	if(isset($_POST['btn_update'])){
            		if(!empty($_POST['terms_conditions'])){
            			
            			$terms_conditions = $db->escapeString($_POST['terms_conditions']);			
            			
            			$sql = "UPDATE `settings` SET `value`='".$terms_conditions."' WHERE `id` = 10";
            			$db->sql($sql);

            			$sql = "SELECT * FROM settings";
            			$db->sql($sql);
            			$res = $db->getResult();
            			$message .= "Términos Condiciones Actualizadas exitosamente";
            			
            		}
            	}
            ?>
            <section class="content-header">
                <h1>Términos y condiciones</h1>
            	<h4><?=$message?></h4>
                <ol class="breadcrumb">
                    <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
                </ol>
                <hr />
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                     
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Actualizar Términos Condiciones</h3>
                            </div>
                          
                            <form  method="post">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="app_name">Términos y condiciones:</label>
                                        <textarea rows="10" cols="10" class="form-control" name="terms_conditions" id="terms_conditions" required><?=$res[9]['value']?></textarea>
                                    </div>
                                </div>
                          
                                <div class="box-footer">
                                    <input type="submit" class="btn-primary btn" value="Actualizar" name="btn_update"/>
                                </div>
                            </form>
                        </div>
                     
                    </div>
                </div>
            </section>
            <div class="separator"> </div>
      </div>
  </body>
</html>
<?php include"footer.php";?>
<script type="text/javascript" src="css/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">CKEDITOR.replace('terms_conditions');</script>
