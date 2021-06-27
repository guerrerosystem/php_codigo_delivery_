<?php session_start();


    include_once ('includes/custom-functions.php');
    include_once ('includes/functions.php');
    $function = new custom_functions;
    
   
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
    $function = new custom_functions;
    $permissions = $function->get_permissions($_SESSION['id']);
    
    include "header.php";?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title><?=$settings['app_name']?> - Dashboard</title>
	</head>
    <body>
       
        
        <div class="content-wrapper">
           
            <section class="content-header">
                <h1>Home</h1>
                <ol class="breadcrumb">
                    <li>
                        <a href="home.php"> <i class="fa fa-home"></i> Home</a>
                    </li>
                </ol>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3><?=$function->rows_count('orders');?></h3>
                                <p>Pedidos</p>
                            </div>
                            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                            <a href="pedidos.php" class="small-box-footer">Mas informacion <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3><?=$function->rows_count('products');?></h3>
                                <p>Productos</p>
                            </div>
                            <div class="icon"><i class="fa fa-cubes"></i></div>
                            <a href="productos.php" class="small-box-footer">Mas informacion  <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xs-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3><?=$function->rows_count('users');?></h3>
                                <p>Clientes Registrados</p>
                            </div>
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <a href="clientes.php" class="small-box-footer">Mas informacion  <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="box box-success">
                             <?php $year = date("Y");
                                $curdate = date('Y-m-d');
                              $sql = "SELECT SUM(final_total) AS total_sale,DATE(date_added) AS order_date FROM orders WHERE YEAR(date_added) = '$year' AND DATE(date_added)<'$curdate' GROUP BY DATE(date_added) ORDER BY DATE(date_added) DESC  LIMIT 0,7";
                                $db->sql($sql);
                                $result_order = $db->getResult(); ?>
                                <div class="tile-stats" style="padding:10px;">
                                    <div id="earning_chart" style="width:100%;height:350px;"></div>
                                </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="box box-danger">
                            <?php
                             $sql="SELECT `name`,(SELECT count(id) from `products` p WHERE p.category_id = c.id ) as `product_count` FROM `category` c";
                                $db->sql($sql);
                                $result_products = $db->getResult(); ?>
                                <div class="tile-stats" style="padding:10px;">
                                    <div id="piechart" style="width:100%;height:350px;"></div>
                                </div>
                        </div>
                        
                    </div>
                    
                </div>

              
                <?php if($permissions['orders']['read']==1) { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">ultimos pedidos</h3>
								<div class="box-tools pull-right">
									<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
									<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
								</div>
				<form method="POST" id="filter_form" name="filter_form">
    
                <div class="form-group pull-right">
                   
                        <select id="filter_order" name="filter_order" placeholder="Select Status" required class="form-control" style="width: 300px;">
                            <option value="">Todas las pedidos</option>
                      


                            <option value ='recibido'> Recibido </option>
                             <option value ='procesado'> Procesado </option>
                             <option value ='enviado'> Enviado </option>
                             <option value ='entregado'> Entregado </option>
                             <option value ='cancelado'> Cancelado </option>
                        </select>
                        
                 
                </div>
                </form>
							</div>
							<div class="box-body">
								<div id="toolbar">
									<form method="post">
										<select class='form-control' id="category_id" name="category_id" placeholder="Select Category" required style="display: none;">
											<?php
												$Query="select name, id from category";
												$db->sql($Query);
                                                $result=$db->getResult();
												if($result)
												{
												?>
											<option value="">Todo los Productos</option>
                                            <?php foreach($result as $row){?>
                                                 <option value='<?=$row['id']?>'><?=$row['name']?></option>
                                                <?php }} 
                                                    ?>
											
										</select>
									</form>
								</div>
								<div class="table-responsive">
									<table class="table no-margin" id='orders_table' data-toggle="table" 
										data-url="api-firebase/get-bootstrap-table-data.php?table=orders"
										data-page-list="[5, 10, 20, 50, 100, 200]"
										data-show-refresh="true" data-show-columns="true"
										data-side-pagination="server" data-pagination="true"
										data-search="true" data-trim-on-search="false"
										data-sort-name="id" data-sort-order="desc"
										data-toolbar="#toolbar" data-query-params="queryParams"
										>
										<thead>
											<tr>
												<th data-field="id" data-sortable='true'>ID</th>
												<th data-field="user_id" data-sortable='true' data-visible="false">ID usuario</th>
												 <th data-field="qty" data-sortable='true' data-visible="false">Cantidad</th>
                                                <th data-field="name" data-sortable='true'>Nombre</th>
												<th data-field="mobile" data-sortable='true' data-visible="true">Telefono.</th>
												<th data-field="items" data-sortable='true' data-visible="false">Productos</th>
												<th data-field="total" data-sortable='true' data-visible="true">Total(<?=$settings['currency']?>)</th>
												<th data-field="delivery_charge" data-sortable='true'>comision</th>
												<th data-field="tax" data-sortable='false'>IGV <?=$settings['currency']?>(%)</th>
												<th data-field="discount" data-sortable='true' data-visible="true">Dsto.<?=$settings['currency']?>(%)</th>
												<th data-field="promo_code" data-sortable='true' data-visible="false">Cod promocional</th>
												<th data-field="promo_discount" data-sortable='true' data-visible="true">Dst prom.(<?=$settings['currency']?>)</th>
												<th data-field="wallet_balance" data-sortable='true' data-visible="true">S.Utlz(<?=$settings['currency']?>)</th>
												<th data-field="final_total" data-sortable='true'>Total(<?=$settings['currency']?>)</th>
												<th data-field="deliver_by" data-sortable='true' data-visible='false'>Entregado por</th>
												<th data-field="payment_method" data-sortable='true' data-visible="true">M. Pago</th>
												<th data-field="address" data-sortable='true' data-visible="false">Direccion</th>
												<th data-field="delivery_time" data-sortable='true' data-visible='false'>tiempo</th>
												<th data-field="status" data-sortable='true' data-visible='false'>Estado</th>
												<th data-field="active_status" data-sortable='true' data-visible='true'>A. Estado</th>
												<th data-field="date_added" data-sortable='true' data-visible="false">o fecha </th>
												<th data-field="operate">Accion</th>
                                               
												
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="box-footer clearfix">
								<a href="pedidos.php" class="btn btn-sm btn-default btn-flat pull-right">Ver todos los pedidos</a>
							</div>
						</div>
					</div>
				</div>
                <?php } else { ?>
                <div class="alert alert-danger">No tienes permiso para ver pedidos.</div>
            <?php } ?>
			</section>
        </div>
<script>
	$('#filter_order').on('change',function(){
    $('#orders_table').bootstrapTable('refresh');
    });
</script>
<script>
function queryParams(p){
	return {
		"filter_order": $('#filter_order').val(),
		limit:p.limit,
		sort:p.sort,
		order:p.order,
		offset:p.offset,
		search:p.search
	};
}
</script>
<?php include "footer.php";?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {

        var data1 = google.visualization.arrayToDataTable([
            ['Product', 'Count'],
            <?php
                foreach($result_products as $row){ echo "['".$row['name']."',".$row['product_count']."],";}
            ?>
        ]);
    
        var options1 = {
          title: 'Estock de productos por categoria',
          is3D: true
        };
    
        var chart1 = new google.visualization.PieChart(document.getElementById('piechart'));
    
        chart1.draw(data1, options1);
    }
</script>

<script>
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date', 'Total en <?=$settings['currency']?>'],
            <?php foreach($result_order as $row){
                $date = date('d-M', strtotime($row['order_date']));
                echo "['".$date."',".$row['total_sale']."],"; 
            } ?>]);
        var options = {
            chart: {
                title: 'Venta semanal',
                subtitle: 'Venta total en la semana pasada(Mes: <?php echo date("M"); ?>)',
            }
        };
    var chart = new google.charts.Bar(document.getElementById('earning_chart'));
    chart.draw(data,google.charts.Bar.convertOptions(options));
    }
</script>
  </body>
</html>