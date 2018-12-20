<script type="text/javascript">
<!--
	var loc_url_del = "ux-admin/linkage/linkdel/";
	var loc_url_stat = "ux-admin/linkage/linkstat/";
//-->
</script>

<style type="text/css">
span.alert-danger {
	background-color: #ffffff;
	font-size: 18px;
}

</style>

<?php 
//echo "Test message";
//exit(); 

?>

<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="subcomp"){	//
			$("#subcomponent").show();
        }
		if($(this).attr("value")=="comp"){
			$("#subcomponent").hide();
		}
		
		if($(this).attr("value")=="formula"){	
			$("#formula").show();
			$("#admin").hide();
			$("#carry").hide();			
		}

		if($(this).attr("value")=="admin"){	
			$("#admin").show();
			$("#formula").hide();
			$("#carry").hide();
		}

		if($(this).attr("value")=="carry"){	
			$("#carry").show();
			$("#formula").hide();
			$("#admin").hide();
		}

		if($(this).attr("value")=="user"){	
			$("#carry").hide();
			$("#formula").hide();
			$("#admin").hide();
		}

    });
});
</script>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Manage Linkage</a></li>
			<li class="active"><?php echo $header; ?></li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading"></div>
			<div class="panel-body">
			<form method="POST" action="" id="area_frm" name="area_frm">
				<input type="hidden" name="areaTab" value="yes">
				<div class="col-sm-12">
				<?php 
					while($row = mysqli_fetch_array($area)) {
					?>
					<div class="col-sm-6">	
						<div class="form-group">
							<label><?=$row['Area_Name']?> : </label>&nbsp;<input type="text" name="<?=$row['AreaID']?>" value="<?=$row['Area_Sequencing']?>" style="width:50px;">
						</div>
					</div>
					<?php 
					}
					?>
										
				</div>
				<div class="col-sm-12">
					<div class="col-sm-6"> </div>
					<div class="col-sm-6" align="right">
						<button type="submit" name="submit" id="siteuser_sbmit" class="btn btn-primary " value="Submit"> Submit </button>
					</div>
				</div>
			</form>	
				
			</div>
		</div>
	</div>
</div>



