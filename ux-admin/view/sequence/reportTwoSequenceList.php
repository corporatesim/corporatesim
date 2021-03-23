<script type="text/javascript">
	<!--
		var loc_url_del  = "ux-admin/chart/del/";
		var loc_url_stat = "ux-admin/chart/stat/";
  //-->
</script>
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Report 2 Sequencing
		</h1>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="active">Report 2 Sequencing</li>
			</ul>
		</div>
	</div>
	<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				<label style="padding-top:7px;">Report 2 Sequencing For Component/Sub-Component :- ( <span>Component / SubComponent <code>Output-Type</code> <span class="alert-success">ScenarioName </span> </span>) </label>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<form action="" method="">
					<div class="row col-md-12">
						<div class="col-md-2">
							<label for="Select Game"><span class="alert-danger">*</span> Select Game</label>
						</div>
						<div class="col-md-6">
							<select class="form-control" name="game_id" id="game_id" onchange="return showOutputCompSubcompListingOrder(this);">
								<option value="">--Select Game--</option>
								<?php foreach($gameData as $gameDataRow){ ?>
									<option value="<?php echo $gameDataRow->Game_ID;?>"><?php echo $gameDataRow->Game_Name;?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</form>
				<!-- add data here -->
				<br><br><br>
				<div class="clearfix"></div>
				<div class="col-md-12 row" id="addCompSubcompListing">
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<script>
		async function showOutputCompSubcompListingOrder(element)
		{
			// alert($(element).val());
			var gameid = $(element).val();
			if(gameid.length>0)
			{
				var sequenceData = await fetch("<?php echo site_root . 'ux-admin/model/ajax/siteusers.php'; ?>", {
					method: 'post',
					headers: {
						'Accept': 'application/json, text/plain, */*',
						"Content-type": "application/x-www-form-urlencoded;"
						// "Content-type": "application/json;"
					},
				body: "action=reportTwoSequence&gameid="+gameid,
				})
				.then(function(result){
					return result.json();
				})
				.then(function(response){
					if(response.code == 201)
					{
						$("#addCompSubcompListing").html("<div class='text-danger' style='text-align:center;'>"+response.msg+"</div>");
					}
					else
					{
						var formData = "<form method='post' action=''> <input type='hidden' name='OpSeq_GameId' value='"+gameid+"'> <div class='row col-md-12'>";
						$(response.data).each(function(i,e){
							// SubLink_CompID SubLink_SubCompID SubLink_LinkID
							var compEdit = "<?php echo site_root.'ux-admin/ManageComponent/edit/';?>"+btoa(e.SubLink_CompID);
							var subCompEdit = "<?php echo site_root.'ux-admin/ManageSubComponent/Edit/';?>"+btoa(e.SubLink_SubCompID);
							var scenEdit = "<?php echo site_root.'ux-admin/linkage/link/';?>"+e.SubLink_LinkID;
							formData += "<div class='col-sm-6 form-group'><label title='Area: "+e.SubLink_AreaName+"'><a href='"+compEdit+"' target='_blank'>"+e.SubLink_CompName+"</a> / <a href='"+subCompEdit+"' target='_blank'>"+((e.SubLink_SubcompName)?e.SubLink_SubcompName:'')+"</a> : </label> <code>"+showCategory(e.SubLink_Competence_Performance)+"</code> <span class='alert-success'><a href='"+scenEdit+"' target='_blank'>"+e.Scen_Name+"</a></span> <input type='hidden' name='OpSeq_CompId[]' value='"+e.SubLink_CompID+"'> <input type='hidden' name='OpSeq_SubcCompId[]' value='"+e.SubLink_SubCompID+"'> <input type='hidden' name='OpSeq_LinkId[]' value='"+e.SubLink_LinkID+"'> <input type='hidden' name='OpSeq_SubLinkId[]' value='"+e.SubLink_ID+"'> <input type='number' required name='OpSeq_Order[]' title='This sequence will be shown in the report 2 table' placeholder='Enter Sequence' value='"+e.OpSeq_Order+"'> </div>"
						});
						formData += "<div class='col-md-12'> <button value='submit' type='submit' name='submit' class='btn btn-primary'>Submit</button> <a href='' class='btn btn-danger'>Cancel</a> </div> </div> </form>";
						$("#addCompSubcompListing").html(formData);
					}
				});
			}
			else
			{
				// Swal.fire({
				// 	icon: 'error',
				// 	title: 'Error',
				// 	html: 'No game selected',
				// 	showCancelButton: true,
				// 	showConfirmButton: false,
				// 	cancelButtonText: 'Close'
				// });
				$("#addCompSubcompListing").html("<div class='text-danger' style='text-align:center;'>No Game Selected.</div>");
			}
		}

		function showCategory(SubLink_Competence_Performance)
		{
			// console.log(SubLink_Competence_Performance);
			// 3-(Output)Simulated Performance, 4-(Output)Competence Readiness, 5-(Output)Competence Application, 6-(Output)None	
			switch(SubLink_Competence_Performance)
			{
				case '3':
				return 'Simulated Performance';
				break;

				case '4':
				return 'Competence Readiness';
				break;

				case '5':
				return 'Competence Application';
				break;

				default:
				return 'None';
				break;
			}
		}
	</script>