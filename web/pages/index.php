<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    




    <meta name="description" content="">
    <meta name="author" content="">

    <title>LivingLab</title>
    
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
	<link rel="shortcut icon" href="../img/logo.png">
    <?php
		include "BDD.php";
	?>
    

<body>

<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    	
                    	<li> <button type="submit" class="btn btn-default" name="deconnexion" value="deconnexion" onClick="{window.open('deconnexion.php','_parent');}">Se deconnecter</button> </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Accueil</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Graphes<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#ici">CO2</a>
                                </li>
                                <li>
                                    <a href="#ici1">Humidité</a>
                                </li>
                                <li>
                                    <a href="#ici2">Temperature</a>
                                </li>
                                <li>
                                    <a href="#ici3">Chute</a>
                                </li>
                                <li>
                                    <a href="#ici4">Four</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="utilisateur.php"><i class="fa fa-table fa-fw"></i> Données utilsateurs </a>
                        </li>
                        
					</ul>
				</div>
</div>


        <div id="page-wrapper">
        <div id="donne">
        <div class="row">
                <div class="col-lg-12 panel panel-red ">
                    <?php
					session_start();
						Alerte($_SESSION['login']);
					?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Taux actuels</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 col-lg-3">
                    <div class="panel panel-primary"  onClick="{window.open('chute.php','_parent');}">
                        <div class="panel-heading">
                              <img src="../img/chute.png" style="width:80%; padding-left:10%" ><br><br>
                              <div>Chute<br><br><br><?php
							  
								donneeChute();
							
							?>
							  </div>
                              
                                
                        </div>
                        
                    </div>
                </div>
				<div class="col-lg-3 col-md-5">
                    <div class="panel panel-green" onClick="{window.open('humi.php','_parent');}">
                        <div class="panel-heading">
                            <img src="../img/humidity.png" class="photo" style="width:80%; padding-left:10%"><br><br>
                            <div class="taille" >Taux d'Humidite<br><br><br><?php
								Humidity();
							
							?></div>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-5">
                    <div class="panel panel-primary" onClick="{window.open('temp.php','_parent');}">
                        <div class="panel-heading">
                            <img src="../img/temp.png" class="photo"  style="width:80%; padding-left:10%"><br><br>
                            <div class="taille">Température dans la pièce<br><br><br><?php
								donneeTemp();
							
							?></div>						
							
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-5">
                    <div class="panel panel-green" onClick="{window.open('CO2.php','_parent');}">
                        <div class="panel-heading">
                            <img src="../img/CO2.png" class="photo" style="width:80%; padding-left:10%"><br><br>
                            <div class="taille" >Taux de CO2<br><br><br><?php
								donneeCO2();
							
							?></div>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-5">
                    <div class="panel panel-green" onClick="{window.open('four.php','_parent');}">
                        <div class="panel-heading">
                            <img src="../img/Four.png" class="photo" style="width:80%; padding-left:10%"><br><br>
                            <div class="taille">Four
							<br><br><br><?php
								donneeFour();
							
							?></div>
                            
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 ">
                    <div class="panel panel-primary" onClick="{window.open('pas.php','_parent');}">
                        <div class="panel-heading">
                            <img src="../img/pied.png" class="photo" style="width:80%; padding-left:10%"><br><br>
                            <div>Nombre de pas </div>
                            <?php
								pas();
							?>
                        </div>
                        
                    </div>
                </div>
                
        </div>
                
            </div>
            <div class="col-lg-12">
                    <h1 class="page-header">Les graphes</h1>
                </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="ici">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Graphes du CO2
                            <div class="pull-right">
                            </div>
                            <div id="curve_chart" style="height:500px;"></div>
        					</div>
                            
                        </div>
                    </div>
                    <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="ici1">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Graphes de l'humidité
                            <div class="pull-right">
                            </div>
                            <div id="curve_chart1" style="height:500px;"></div>
        					</div>
                            
                        </div>
                    </div>
                    <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="ici2">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Graphes de la temperature
                            <div class="pull-right">
                            </div>
                            <div id="curve_chart2" style="height:500px;"></div>
        					</div>
                            
                        </div>
                    </div>
                    <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="ici3">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Graphes des chutes
                            <div class="pull-right">
                            </div>
                            <div id="curve_chart3" style="height:500px;"></div>
        					</div>
                            
                        </div>
                    </div>
                    <div class="col-lg-8 col-lg-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="ici4">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Graphes du Four
                            <div class="pull-right">
                            </div>
                            <div id="curve_chart4" style="height:500px;"></div>
        					</div>
                            
                        </div>
                    </div>
                    
                
            </div>
        </div>


    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../js/index.js"></script>
    <script>
  	$(document).ready(function() {
  // Appliquer un rafrachissement toute les 10 sec
  setInterval(function() {
    // On GET la div situer dans le php et on applique le refresh sur la div en question sur la page loader
    $('#donne').load('index.php #donne');
  }, 10000);
});
	</script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'CO2'],
          <?php
		  $result = data(1,$time,$room);
		  foreach($result as $row){
		  	echo "['".$row['DTIME']."',".$row['NUM']."],";
		  }
		  ?>
        ]);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
	  google.charts.setOnLoadCallback(drawChart1);
	  function drawChart1() {
        var data1 = google.visualization.arrayToDataTable([
          ['Date', 'humidite'],
          <?php
		  $result = data(3,$time,$room);
		  foreach($result as $row){
		  	echo "['".$row['DTIME']."',".$row['NUM']."],";
		  }
		  ?>
        ]);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart1 = new google.visualization.LineChart(document.getElementById('curve_chart1'));

        chart1.draw(data1, options);
      }
	  google.charts.setOnLoadCallback(drawChart2);
	  function drawChart2() {
        var data2 = google.visualization.arrayToDataTable([
          ['Date', 'temperature'],
          <?php
		  $result = data(2,$time,$room);
		  foreach($result as $row){
		  	echo "['".$row['DTIME']."',".$row['NUM']."],";
		  }
		  ?>
        ]);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart2 = new google.visualization.LineChart(document.getElementById('curve_chart2'));

        chart2.draw(data2, options);
      }
	  google.charts.setOnLoadCallback(drawChart3);
	  function drawChart3() {
        var data3 = google.visualization.arrayToDataTable([
          ['Date', 'chute'],
          <?php
		  $result = data(4,$time,$room);
		  foreach($result as $row){
		  	echo "['".$row['DTIME']."',".$row['NUM']."],";
		  }
		  ?>
        ]);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart3 = new google.visualization.LineChart(document.getElementById('curve_chart3'));

        chart3.draw(data3, options);
      }
	  google.charts.setOnLoadCallback(drawChart4);
	  function drawChart4() {
        var data4 = google.visualization.arrayToDataTable([
          ['Date', 'four'],
          <?php
		  $result = data(5,$time,$room);
		  foreach($result as $row){
		  	echo "['".$row['DTIME']."',".$row['NUM']."],";
		  }
		  ?>
        ]);

        var options = {
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart4 = new google.visualization.LineChart(document.getElementById('curve_chart4'));

        chart4.draw(data4, options);
      }
	  
    </script>
	

</body>

</html>