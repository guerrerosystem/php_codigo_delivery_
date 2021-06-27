<?php
    
    session_start();
    
    
    $currentTime = time() + 25200;
    $expired = 3600;
    
    
    if (!isset($_SESSION['user'])) {
        header("location:index.php");
    }
    
    
    if ($currentTime > $_SESSION['timeout']) {
        session_destroy();
        header("location:index.php");
    }
    
    
    unset($_SESSION['timeout']);
    $_SESSION['timeout'] = $currentTime + $expired;
    ?>
<?php include"header.php";?>
<html>
    <head>
        <title>Imágenes del control deslizante principal| <?=$settings['app_name']?> - Dashboard</title>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
            
            });
            function sendPushNotification(id) {
                var data = $('form#' + id).serialize();
                $('form#' + id).unbind('submit');
                $.ajax({
                    url: "send-message.php",
                    type: 'GET',
                    data: data,
                    beforeSend: function () {
            
                    },
                    success: function (data, textStatus, xhr) {
                        $('.txt_message').val("");
                    },
                    error: function (xhr, textStatus, errorThrown) {
            
                    }
                });
            
                return false;
            }
        </script>
        <style type="text/css">
            .container{
            width: 950px;
            margin: 0 auto;
            padding: 0;
            }
            h1{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 24px;
            color: #777;
            }
            h1 .send_btn
            {
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -moz-linear-gradient(center top, #0096FF, #005DFF);
            background: linear-gradient(#0096FF, #005DFF);
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            border-radius: 3px;
            color: #fff;
            padding: 3px;
            }
            div.clear{
            clear: both;
            }
            ul.devices{
            margin: 0;
            padding: 0;
            }
            ul.devices li{
            float: left;
            list-style: none;
            border: 1px solid #dedede;
            padding: 10px;
            margin: 0 15px 25px 0;
            border-radius: 3px;
            -webkit-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            -moz-box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.35);
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #555;
            width:100%;
            height:150px;
            background-color:#ffffff;
            }
            ul.devices li label, ul.devices li span{
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-style: normal;
            font-variant: normal;
            font-weight: bold;
            color: #393939;
            display: block;
            float: left;
            }
            ul.devices li label{
            height: 25px;
            width: 50px;                
            }
            ul.devices li textarea{
            float: left;
            resize: none;
            }
            ul.devices li .send_btn{
            background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -webkit-linear-gradient(0% 0%, 0% 100%, from(#0096FF), to(#005DFF));
            background: -moz-linear-gradient(center top, #0096FF, #005DFF);
            background: linear-gradient(#0096FF, #005DFF);
            text-shadow: 0 1px 0 rgba(0, 0, 0, 0.3);
            border-radius: 7px;
            color: #fff;
            padding: 4px 24px;
            }
            a{text-decoration:none;color:rgb(245,134,52);}
        </style>
    </head>
    <body>
        <div class="content-wrapper">
        <section class="content-header">
            <h1>Imagen del control deslizante principal para ofertas y beneficios adicionales para clientes</h1>
            <ol class="breadcrumb">
                <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
            </ol>
            <hr/>
        </section>
        <?php
            include_once('includes/functions.php');
            

            
          
            ?>
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <?php if($permissions['home_sliders']['create']==0) { ?>
                        <div class="alert alert-danger">No tienes permiso para crear el control deslizante de inicio</div>
                    <?php } ?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Agregar / Actualizar Imágenes de ofertas interesantes aquí</h3>
                        </div>
                        <form id="slider_form" method="post" action="api-firebase/slider-images.php" enctype="multipart/form-data">
                            <div class="box-body">
                                <input type='hidden' name='accesskey' id='accesskey' value='90336'/>
                                <input type='hidden' name='add-image' id='add-image' value='1'/>
                                <div class="form-group">
                                    <label for="type">Tipo :</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="defecto">Defecto</option>
                                        <option value="categoria">Categoria</option>
                                        <option value="producto">Producto</option>
                                    </select>
                                </div>
                                <div class="form-group" id="categories" style="display:none;">
                                    <label for="categoria">Categorias :</label>
                                    <select name="categoria" id="categori" class="form-control">
                                        <?php
                                            $sql = "SELECT * FROM `category` order by id DESC";
                                            $db->sql($sql);
                                            $categories_result = $db->getResult();
                                        ?>
                                        <?php if($permissions['categories']['read']==1){?>
                                        <option value="">Seleccionar categoria</option>
                                        <?php foreach($categories_result as $value){?>
                                            <option value="<?=$value['id']?>"><?=$value['name']?></option>
                                            <?php
                                        } }else {
                                        ?>
                                        <option value="">Seleccionar Categoria</option>
                                    <?php } ?>
                                    </select>
                                </div>

            
                                <div class="form-group" id="products" style="display:none;">
                                    <label for="producto">Productos :</label>
                                    <select name="producto" id="producto" class="form-control">
                                         <?php
                                            $sql = "SELECT * FROM `products` order by id DESC";
                                            $db->sql($sql);
                                            $products_result = $db->getResult();
                                            
                                        ?>
                                        <?php if($permissions['products']['read']==1){?>
                                        <option value="">seleccionar categoria</option>
                                        <?php foreach($products_result as $value){?>
                                            <option value="<?=$value['id']?>"><?=$value['name']?></option>
                                            <?php
                                        } } else {
                                        ?>
                                        <option value="">Seleccionar prodcuto</option>
                                    <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Imagen del control deslizante: <small> ( Tamaño recomendado: 1024 x 512 píxeles)</small></label>
                                    <input type='file' name="image" id="image" required/> 
                                </div>
                            </div>
                            <div class="box-footer">
                                <input type="submit" id="submit_btn" class="btn-primary btn" value="Subir"/>
                            </div>
                        </form>
                        <div id="result"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <?php if($permissions['home_sliders']['read']==1){?>
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Imagen del control deslizante principale</h3>
                        </div>
                        <table id="notifications_table" class="table table-hover" data-toggle="table" 
                            data-url="api-firebase/get-bootstrap-table-data.php?table=slider"
                            data-page-list="[5, 10, 20, 50, 100, 200]"
                            data-show-refresh="true" data-show-columns="true"
                            data-side-pagination="server" data-pagination="true"
                            data-search="true" data-trim-on-search="false"
                            data-sort-name="id" data-sort-order="desc">
                            <thead>
                            <tr>
                                <th data-field="id" data-sortable="true">ID</th>
                                <th data-field="image">Imagen</th>
                                <th data-field="type">Tipo</th>
                                <th data-field="type_id">ID</th>
                                <th data-field="operate">Accion</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                     <?php } else { ?>
                    <div class="alert alert-danger">No tiene permiso para ver las imágenes del control deslizante de inicio.</div>
                    <?php } ?>
                </div>
            </div>
        </section>
    </div>
    <script>
    $("#include_image").change(function() {
        if(this.checked) {
            $('#image').show('fast');
        }else{
            $('#image').val('');
            $('#image').hide('fast');
        }
    });
    $("#type").change(function() {
        //alert('changed');
        type = $("#type").val();
        if(type == "defecto"){
            $("#categories").hide();
            $("#products").hide();
        }
        if(type == "categoria"){
            $("#categories").show();
            $("#products").hide();
        }
        if(type == "producto"){
            $("#categories").hide();
            $("#products").show();
        }
    });
      $('#slider_form').on('submit',function(e){
        e.preventDefault();
        var formData = new FormData(this);
            $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            dataType:'json',
            beforeSend:function(){$('#submit_btn').val('espere.').attr('disabled',true);},
            cache:false,
            contentType: false,
            processData: false,
            success:function(result){
                $('#result').html(result.message);
                $('#result').show().delay(2000).fadeOut();
                $('#submit_btn').val('Subir').attr('disabled',false);
                // $('#notifications_table').bootstrapTable('refresh');
                setTimeout(function() {
                    location.reload();
                }, 2000);
            }
            });
        
    }); 
    </script>
   <script>
    $(document).on('click','.delete-slider',function(){
        if(confirm('Estas seguro')){
            id = $(this).data("id");
            image = $(this).data("image");
            $.ajax({
                url : 'api-firebase/slider-images.php',
                type: "get",
                data: 'accesskey=90336&id='+id+'&image='+image+'&type=delete-slider',
                success: function(result){
                    if(result==1){
                        $('#notifications_table').bootstrapTable('refresh');
                    }
                    if(result==2){
                        alert('No tienes permiso para eliminar el control deslizante de inicio');
                    }
                    if(result==0){
                        alert('¡Error! el control deslizante no se pudo eliminar');
                    }
                        
                }
            });
        }
    });
    </script>
</body>
</html>
<?php include"footer.php"; ?>