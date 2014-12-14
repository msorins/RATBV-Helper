<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RATBV Helper </title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	  <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans:400,300" />
	<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
  </head>
  <body>
  <?php 
	require "/var/zpanel/hostdata/zadmin/public_html/ironcoders_com/scripts/config.php";
	require "/var/zpanel/hostdata/zadmin/public_html/ironcoders_com/scripts/secure.php";
	if(isset($_GET["type"]))
	{
		$type=$_GET["type"];
		$type=secure($type);
	}
	else
		$type=NULL;
	

	class main //clasa
	{
	  public function principal() // metoda 
		{
		?>
		
		  <form class="center-block" style=" width:25%;" action="/ratbv/scripts/redirect.php" method="post" enctype="multipart/form-data" role="form">
		  <div class="row">
		  
		  <div class="col-md-12">
			  <div class="form-group">
					<label for="exampleInputEmail1">Statie plecare:</label>
					<input style="max-width:280px;" id="nume_statie" name="nume_statie" type="text" class="form-control" placeholder="">
			  </div><br>
		  </div>
		  
		  <div class="col-md-12">
			  <div class="form-group">
					<label for="exampleInputEmail1">Destinatie:</label>
					<input style="max-width:280px;"  id="nume_destinatie" name="nume_destinatie" type="text" class="form-control" placeholder="">
			  </div><br>
		  </div>
		 
		  <div  class="col-md-12">
			<p style="margin-left:12%;" text-align:center"><input type="image" src="img/buton_trimitere.png" alt="Submit" width="170" height="100"></p>
		  </div>
		  
		  </div>
		  </form>
	
		<?php
		}
		
	   public function traseu()
	   {
	   ?><div style="float:right; margin-top:20px;"> 
	     <span style="color:#737373;" > <img style="height:80px; width:80px;" src="img/butoane/0.png"> Autobuze </span>
		 <span style="color:#737373;"> <img style="height:80px; width:80px;" src="img/butoane/00.png"> Autobuze Midi</span> 
		 <span style="color:#737373;"> <img style="height:80px; width:80px;" src="img/butoane/000.png"> Troleibuze </span> 
		 </div>
		 <hr><br><br>
		 <?php
			$nume_statie=secure($_GET["nume_statie"]); $nume_statie=trim ($nume_statie);
			$nume_destinatie=secure($_GET["nume_destinatie"]); $nume_destinatie=trim($nume_destinatie);
			mysql_select_db("zadmin_ratbv");
			$query=mysql_query("SELECT * FROM `linii`");
			
			$ok=false;
			?>
			<h3> Linii viabile: </h3>
			<?php
			$contor=0;
			while($k=mysql_fetch_array($query))
			{
				$contor++;
				$a=$k["linii_statii_dus"];
				//echo strpos($a,$nume_statie)."  -  ".strpos($a,$nume_destinatie)."#  ";
				if(( strpos($a,$nume_statie) != NULL && strpos($a,$nume_destinatie) != NULL) && (strpos($a,$nume_statie) < strpos($a,$nume_destinatie)))
				{
					$nr=0;
					for($i=0; $i<strlen($a); $i++)
					{
						if($a[$i]=='#')
							$nr++;
						if($i== strpos($a,$nume_statie))
							break;
						
					}
					$nr_linie=$k["linii_nume"];
					
					$nr2=0;
						for($i=0; $i<strlen($a); $i++)
						{
							if($a[$i]=='#')
								$nr2++;
							if($i== strpos($a,$nume_destinatie))
								break;
						}
						// am luat distanta dintre fiecare 2 statii din brasov, am facut o medie intre aceste distante care am combinat-o cu 
						// viteza medie a unui autobuz si a rezultat formula de mai jos 
						// TO DO -> facut script care calculeaza in mod dinamic timpul dintre statii ( individual )
				?><img style="height:80px; width:80px;" src="img/butoane/<?php echo $k["linii_nume"];?>.png">
				<div style="float:right; margin-top:26px;"><h5 style="color:#737373;"><img src="img/timer.png" style="width:30px; height:30px; margin-right:10px;">Durata aproximativa a traseului: <?php echo round($nr2*1.6); ?> minute </h5></div>
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $contor;?>" aria-expanded="false" aria-controls="<?php echo $contor;?>">
						  Vezi programul
						</a>
					  </h4>
					</div>
					<div id="<?php echo $contor;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
						 <?php echo "<iframe style=\"width:100%; height:550px;\" src=\"http://www.ratbv.ro/afisaje/".$nr_linie."-dus/line_".$nr_linie."_".$nr."_cl2_ro.html\"></iframe>"; ?>
					  </div>
					</div>
				  </div>
				</div>
				<hr>
				<?php
					$ok=true;
				}
			
			}
			
			?>
			
			
			<?php
			$contor=0;
			$query=mysql_query("SELECT * FROM `linii`");
			while($k=mysql_fetch_array($query))
			{
				$contor++;
				$b=$k["linii_statii_intors"];
					
					if(( strpos($b,$nume_statie) != NULL && strpos($b,$nume_destinatie) != NULL) && (strpos($b,$nume_statie) < strpos($b,$nume_destinatie)))
					{
						$nr=0;
						for($i=0; $i<strlen($b); $i++)
						{
							if($b[$i]=='#')
								$nr++;
							if($i== strpos($b,$nume_statie))
								break;
						}
						$nr_linie=$k["linii_nume"];
						
						$nr2=0;
						for($i=0; $i<strlen($b); $i++)
						{
							if($b[$i]=='#')
								$nr2++;
							if($i== strpos($b,$nume_destinatie))
								break;
						}
						// am luat distanta dintre fiecare 2 statii din brasov, am facut o medie intre aceste distante care am combinat-o cu 
						// viteza medie a unui autobuz si a rezultat formula de mai jos 
						// TO DO -> facut script care calculeaza in mod dinamic timpul dintre statii
						?><img style="height:80px; width:80px;" src="img/butoane/<?php echo $k["linii_nume"];?>.png">
						<div style="float:right; margin-top:26px;"><h5 style="color:#737373;"><img src="img/timer.png" style="width:30px; height:30px; margin-right:10px;">Durata aproximativa a traseului: <?php echo round($nr2*1.6); ?> minute </h5></div>
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				  <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $contor;?>" aria-expanded="false" aria-controls="<?php echo $contor;?>">
						  Vezi programul
						</a>
					  </h4>
					</div>
					<div id="<?php echo $contor;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body">
						 <?php echo "<iframe style=\"width:100%; height:400px;\" src=\"http://www.ratbv.ro/afisaje/".$nr_linie."-intors/line_".$nr_linie."_".$nr."_cl1_ro.html\"></iframe>"; ?>
					  </div>
					</div>
				  </div>
				</div>
				<hr>
						<?php
						$ok=true;
					}
			}
			
			if($ok==false)
			{
				$a=$nume_statie;
				$b=$nume_destinatie;
				$query=mysql_query("SELECT * FROM `linii`");
				while($k=mysql_fetch_array($query))
				{
					$dus=$k["linii_statii_dus"];
					$intors=$k["linii_statii_intors"];
					
					$rasp="#";
					if( strpos($a,$dus) != NULL) // verifica ce autobuze trec prin statia mea DUS
					{
						$statii=explode("#",$dus);
						$i=0; 
						while(1)
						{
							if(trim($statii[$i])==trim($a))
								break;
							$i++;
						}
						$i++;
						for($i; $i<count($statii); $i++) 
						{
							$st=$statii[$i]; // statie auxiliara din care pot lua alt autobuz direct spre destinatie
							{
								$query2=mysql_query("SELECT * FROM `linii`");
								while($k2=mysql_fetch_array($query2))
								{
									$dus2=$k2["linii_statii_dus"];
									$intors2=$k2["linii_statii_intors"];

									//verific daca traseele astea contin statia de final
									
									if(strpos($dus2,$b) != NULL || strpos($intors2,$b))
									{
									   if(strpos($rasp,$k2["linii_nume"])==NULL)
										{
											?><img style="height:80px; width:80px;" src="img/butoane/<?php echo $k["linii_nume"];?>.png"> schimbare cu linia
											<img style="height:80px; width:80px;" src="img/butoane/<?php echo $k2["linii_nume"];?>.png"> 
											<hr>
											<?php
										}
										 $rasp=$rasp.$k2["linii_nume"]."#";
									}
								}
							}
							
						}
					}
					
					$rasp="#";
					if( strpos($intors,$a) != NULL) // verifica ce autobuze trec prin statia mea INTORS
					{
						$statii=explode("#",$intors);
						$i=0; 
						while(1)
						{
							if(trim($statii[$i])==trim($a))
								break;
							$i++;
						}
						$i++;
						for($i; $i<count($statii); $i++) 
						{
							$st=$statii[$i]; // statie auxiliara din care pot lua alt autobuz direct spre destinatie
							{
								$query2=mysql_query("SELECT * FROM `linii`");
								while($k2=mysql_fetch_array($query2))
								{
									$dus2=$k2["linii_statii_dus"];
									$intors2=$k2["linii_statii_intors"];

									//verific daca traseele astea contin statia de final
									
									if(strpos($intors2,$b) != NULL || strpos($dus2,$b))
									{
										if(strpos($rasp,$k2["linii_nume"])==NULL)
										{
											?><img style="height:80px; width:80px;" src="img/butoane/<?php echo $k["linii_nume"];?>.png"> schimbare cu linia
											<img style="height:80px; width:80px;" src="img/butoane/<?php echo $k2["linii_nume"];?>.png">
											<hr>
											<?php
										}
										 $rasp=$rasp.$k2["linii_nume"]."#";
									}
								}
							}
							
						}
					}
				}
			}
			
	
	   }
	}
	 $obj = new main; 

?>
   <script>
   $(document).ready(function () {
	$(function() {

		$( "#nume_statie" ).autocomplete(
		{
			 minlength:2,
			 source:'scripts/statii_lista.php',
			 select: function(event, ui) {
					$('#nume_statie').val(ui.item.label);
				}
		})

	});
	
	$(function() {

		$( "#nume_destinatie" ).autocomplete(
		{
			 minlength:2,
			 source:'scripts/statii_lista.php',
			 select: function(event, ui) {
					$('#nume_destinatie').val(ui.item.label);
				}
		})

	});
	});
</script>
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <!-- We use the fluid option here to avoid overriding the fixed width of a normal container within the narrow content columns. -->
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/ratbv">Planificator traseu</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
          <ul class="nav navbar-nav">
            <li class="active"><a href="http://www.ratbv.ro/">RATBV</a></li>
            <li><a href="/ratbv/index.php?type=info">Informatii suplimentare</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div>
    </nav>
	
	 <?php 
	   if($type==NULL)
	   {
		?>
			
			<div style="background-position:50% 50%; background-image: url(img/background.jpg); min-height:900px; height:100%;">
			<div style="height:330px;"></div>
		<?php
			$obj::principal();
		    ?></div><?php
	   }
	   if($type=="find")
	   {
	   ?><div id="all" style="width:76%; margin:auto"> <?php
		  $obj::traseu();
	   ?> 
	   </div> <?php
		}
		if($type=="info")
		{
		  ?>
		 <div style="background-position:50% 50%; background-image: url(img/background2.jpg); min-height:900px; height:100%;">
		 <div style="height:66px;"></div>
		  <div style="margin-left:36%; background-color: #f5f5f5; border: 1px solid #ccc;  padding:20px; width:30%">
			Intrucat in ziua de astazi, detinerea oricarui tip de informatie aduce putere, putem afirma ca odata cu lipsa acesteia apar pierderile.Proiectul are ca scop informarea cetatenilor care folosesc mijloacele de transport in comun in legatura cu traseele propice scopurilor acestora.Din punct de vedere al programarii propriu-zise, dupa introducerea numelui statiei din care porneste calatorul respectiv numele statiei destinatie, se va genera o lista cu toate autobuzele care indeplinesc traseul, iar la alegerea utilizatorului se va afisa orarul liniei respective pentru punerea acestuia la curent cu mersul mijloacelor de transport in comun.
			In cazul in care traseul nu poate fi realizat cu ajutorul unei singure linii, aplicate este in stare sa genereze combinatiile de autobuze care pot duce la destinatia finala calatorul.
			De asemenea, pentru confortul moral al utilizatorului, aplicatia afiseaza durata aproximativa a traseului, aceasta fiind calculata in raport cu distanta dintre statii.
			In functie de scopurile calatorilor, programul ii va informa pe acestia in legatura cu tipul de mijloc de transport, impartit pe 3 categorii:autobuze,autobuze midi sau troleibuze.
		  </div>
		  <div style="margin-left:36%; background-color: #f5f5f5; border: 1px solid #ccc;  padding:20px; width:30%; margin-top:30px;">
			Proiect realizat de:
			<ul>
			  <li> Mircea Sorin </li>
			  <li> Mihalache Mihai </li>
			  <li> Morcov Madalin </li>
			  <li> Prunau Lucian </li>
			  <li> Neghina Daniel </li>
			  <li> Vilcu Mihai </li>
			</ul>
			
		  </div>
		 </div>
		 <?php
		}
	  ?>
    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>