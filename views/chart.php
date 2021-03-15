<?php 
include_once 'includes/header.php'; 


?>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/3.9.0/math.min.js"></script>-->
  	<script src="js/jquery.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<link href="<?=site_root?>css/dd_pushupbox.css" rel="stylesheet" type="text/css">
<script src="<?=site_root?>/js/dd_pushupbox.js"></script>

	<section>
	
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-10 no_padding">
				<h2 class="InnerPageHeader"><?php if(!empty($result)){ echo $result->Scenario ; }?> Decisions</h2></div>
				<!--<div class="col-sm-3 col-md-2 text-center timer">hh:mm:ss</div>-->
				<?php //echo $_SESSION['date']; ?>
				<div class="clearfix"></div>
				
				
				
				
				
				
					<div class="col-sm-12 no_padding shadow">
						<div class="col-sm-6 ">
							<p class="innerPageLink">All Chart</p><i class="fa fa-window-restore" aria-hidden="true"></i>

						</div>
						<div class="col-sm-6  text-right">
							
						</div>
						<div class="col-sm-12"><hr style="margin: 5px 0;"></hr></div>
						
						<!-- Nav tabs -->	
						<div class=" TabMain col-sm-12">
							
							<!-- -----------------------------       Chart Section    ----------------------------------------------->
				
					
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>
						<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Chango">
					<?php 
					if($countRow >0)
					{						
						for($i=1; $i<=$countRow; $i++)
						{	
							
					?>
				
					 <div id="chart_div_<?=$i?>" style="width: 1000px; height: 400px;"><hr></div>
						

						<script type="text/javascript">
						  google.load('visualization', '1', {packages: ['corechart']});
						</script>
						
						<script type="text/javascript">
					  function drawVisualization() {
						// Some raw data (not necessarily accurate)
						var data = google.visualization.arrayToDataTable([
						  ['Components', 'Inputs'],
					   //     [role:  domain,   data,       data,      data,   domain,   data,     data],    --  hint for cols
						 
							<?php foreach($data[$i] as $key=>$val) { ?>
							
									['<?=$key?>',<?=$val?>],
									
							  
							<?php }?>
							  
							
						]);

						var options = {
						  title :  '<?=ucfirst($chartname[$i])?> : ',
						  is3D: true,
						  interpolateNulls: true,
						  vAxis: {titleTextStyle:{ fontName: 'Chango'}},
						  hAxis: {title: "---- Components/Subcomponents ---- -> ",titleTextStyle:{ fontName: 'Chango'},textStyle: {color: '#000', fontSize: 12},textPosition:"out",textPosition: 'none',slantedText:true},
						  seriesType: "bars",
						};

						var chart = new google.visualization.<?=$charttype[$i]=='pie'?'PieChart':'ComboChart'?>(document.getElementById('chart_div_<?=$i?>'));
						chart.draw(data, options);

					   }
					  google.setOnLoadCallback(drawVisualization);
					</script>
					
					<br><hr>
					
						<?php  
						}
					}
					else
					{
						echo 'No Charts';
					}
				?>
				<!-- -----------------------------       Chart Section  end  ----------------------------------------------->
						
			
		</div><!--container---->
	</section>	
	


<!-- Modal -->


	

</body>
</html>

