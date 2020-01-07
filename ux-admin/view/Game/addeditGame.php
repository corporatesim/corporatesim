<script src="<?php echo site_root; ?>assets/components/ckeditor/ckeditor.js" type="text/javascript"></script>

<style type="text/css">
	span.alert-danger {
		background-color: #ffffff;
		font-size: 18px;
	}
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $header; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Master Management</a></li>
			<li class="active"><a	href="<?php echo site_root."ux-admin/ManageGame"; ?>">Manage Game</a></li>
			<li class="active"><?php echo $header; ?> <?php echo ($gamedetails->Game_Name)?"<b>(".$gamedetails->Game_Name.")</b>":'';?></li>
		</ul>
	</div>
</div>

<?php if(isset($_GET['edit'])){ ?>
	<div class="row">
		<div class="col-sm-12">
			<div class=" right" style="text-align:right; margin: 50px 0 0 0; font-size:15px;">
				<a href="<?php echo site_root."ux-admin/ManageGame"; ?>"
					title="Game List"> Back</a> | 
					<a href="<?php echo site_root."ux-admin/ManageGameContent/Edit/".base64_encode($gamedetails->Game_ID); ?>"
						title="General"><span class="fa fa-book"></span> Content</a> | 
						<a href="<?php echo site_root."ux-admin/ManageGameDocument/Edit/".base64_encode($gamedetails->Game_ID); ?>"
							title="Document"><span class="fa fa-image"></span> Document</a> | 				
							<a href="<?php echo site_root."ux-admin/ManageGameImage/Edit/".base64_encode($gamedetails->Game_ID); ?>"
								title="Image"><span class="fa fa-image"></span> Image</a> | 
								<a href="<?php echo site_root."ux-admin/ManageGameVideo/Edit/".base64_encode($gamedetails->Game_ID); ?>"
									title="Video"><span class="fa fa-video-camera"></span> Video</a>
								</div>
							</div>
						</div>
						<br>
						<br>		
					<?php } ?>		
					<!-- DISPLAY ERROR MESSAGE -->
					<?php if(isset($msg)){ ?>
						<div class="form-group <?php echo $type[1]; ?>">
							<div align="center" id="<?php echo $type[0]; ?>">
								<label class="control-label" for="<?php echo $type[0]; ?>">
									<?php echo $msg; ?>
								</label>
							</div>
						</div>
					<?php } ?>
					<!-- DISPLAY ERROR MESSAGE END -->

					<div class="col-sm-12">
						<form method="POST" action="" id="game_frm" name="game_frm" enctype="multipart/form-data">
							<div class="row col-md-12">
								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="Game_Type" class="containerCheckbox">
											<input type="checkbox" class="" name="Game_Type" id="Game_Type" value="1" <?php echo ($gamedetails->Game_Type == 1)?'checked':'';?>> Bot-Enabled
											<span class="checkmark"></span>
										</label>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12">
									<div class="form-group">
										<label for="eLearning" class="containerCheckbox">
											<input type="checkbox" class="" name="eLearning" id="eLearning" value="1" <?php echo ($gamedetails->Game_Elearning == 1)?'checked':'';?>> eLearning
											<span class="checkmark"></span>
										</label>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12" id="skipIntroduction" data-toggle="tooltip" title="This will skip introduction from all scenario for this game">
									<div class="form-group">
										<div class="form-check" data-toggle="tooltip">
											<label class="form-check-label containerCheckbox" for="Game_Introduction">
												<input type="checkbox" class="form-check-input" id="Game_Introduction" name="Game_Introduction" value="1"<?php echo ($gamedetails->Game_Introduction == 1)?'checked':'';?>> Skip Introduction
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12" id="skipDescription" data-toggle="tooltip" title="This will skip description from all scenario for this game">
									<div class="form-group">
										<div class="form-check" data-toggle="tooltip">
											<label class="form-check-label containerCheckbox" for="Game_Description">
												<input type="checkbox" class="form-check-input" id="Game_Description" name="Game_Description" value="1"<?php echo ($gamedetails->Game_Description == 1)?'checked':'';?>> Skip Description
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12" id="skipIntroductionLink" data-toggle="tooltip" title="This will hide introduction link from all scenario for this game">
									<div class="form-group">
										<div class="form-check" data-toggle="tooltip">
											<label class="form-check-label containerCheckbox" for="Game_IntroductionLink">
												<input type="checkbox" class="form-check-input" id="Game_IntroductionLink" name="Game_IntroductionLink" value="1"<?php echo ($gamedetails->Game_IntroductionLink == 1)?'checked':'';?>> Hide Introduction Link
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12" id="skipDescriptionLink" data-toggle="tooltip" title="This will hide description link from all scenario for this game">
									<div class="form-group">
										<div class="form-check" data-toggle="tooltip">
											<label class="form-check-label containerCheckbox" for="Game_DescriptionLink">
												<input type="checkbox" class="form-check-input" id="Game_DescriptionLink" name="Game_DescriptionLink" value="1"<?php echo ($gamedetails->Game_DescriptionLink == 1)?'checked':'';?>> Hide Description Link
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12" id="skipBackToIntro" data-toggle="tooltip" title="This will hide back to introduction link from all scenario for this game">
									<div class="form-group">
										<div class="form-check" data-toggle="tooltip">
											<label class="form-check-label containerCheckbox" for="Game_BackToIntro">
												<input type="checkbox" class="form-check-input" id="Game_BackToIntro" name="Game_BackToIntro" value="1" <?php echo ($gamedetails->Game_BackToIntro == 1)?'checked':'';?>> Hide Back To Intro
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

								<div class="row name col-md-3 col-lg-3 col-sm-12 col-xs-12" id="skipHideScenarioLink" data-toggle="tooltip" title="Hide scenario link from introduction/game_description page">
									<div class="form-group">
										<div class="form-check" data-toggle="tooltip">
											<label class="form-check-label containerCheckbox" for="Game_HideScenarioLink">
												<input type="checkbox" class="form-check-input" id="Game_HideScenarioLink" name="Game_HideScenarioLink" value="1" <?php echo ($gamedetails->Game_HideScenarioLink == 1)?'checked':'';?>> Hide Scenario Link
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>

							</div>

							<div class="row">
								<div class="col-md-6 form-group" data-toggle="tooltip" title="Selected user can only change the design. And Creator can not be the Associate">
									<label for="name"><span class="alert-danger">*</span>Associate Access</label>
									<select name="Game_Associates" id="Game_Associates" class="form-control" required="">
										<option value="-1">--Select Users--</option>
										<?php foreach($userObj as $userObjRow){ ?>
											<option value="<?php echo $userObjRow->id;?>" <?php echo ($gamedetails->Game_Associates == $userObjRow->id)?'selected':'';?> ><?php echo $userObjRow->fname.' '.$userObjRow->lname;?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6 form-group" data-toggle="tooltip" title="Game will be available for mobile and desktop platform according to this category">
									<label for="name"><span class="alert-danger">*</span>Game Category</label>
									<select name="Game_Category" id="Game_Category" class="form-control" required="">
										<option value="-1">--Select Category--</option>
										<option value="Desktop Simulation" <?php echo ($gamedetails->Game_Category == 'Desktop Simulation')?'selected':'';?>>
											Desktop Simulation
										</option>
										<option value="Desktop Assesment" <?php echo ($gamedetails->Game_Category == 'Desktop Assesment')?'selected':'';?>>
											Desktop Assesment
										</option>
										<option value="Desktop eLearning" <?php echo ($gamedetails->Game_Category == 'Desktop eLearning')?'selected':'';?>>
											Desktop eLearning
										</option>
										<option value="Mobile Simulation" <?php echo ($gamedetails->Game_Category == 'Mobile Simulation')?'selected':'';?>>
											Mobile Simulation
										</option>
										<option value="Mobile Assesment" <?php echo ($gamedetails->Game_Category == 'Mobile Assesment')?'selected':'';?>>
											Mobile Assesment
										</option>
										<option value="Mobile eLearning" <?php echo ($gamedetails->Game_Category == 'Mobile eLearning')?'selected':'';?>>
											Mobile eLearning
										</option>
									</select>
								</div>
							</div>

							<div class="row name" id="name">
								<div class="col-sm-6">
									<input type="hidden" name="id"
									value="<?php if(isset($_GET['edit'])){ echo $gamedetails->Game_ID; } ?>">
									<div class="form-group">
										<label for="name"><span class="alert-danger">*</span>Name</label>
										<input type="text" name="name"
										value="<?php if(!empty($gamedetails->Game_Name)) echo $gamedetails->Game_Name; ?>"
										class="form-control" placeholder="Game Name" required>
									</div>
								</div>
							</div>
							<div class="row name" id="comments">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="name"><span class="alert-danger">*</span>Comments</label>
										<textarea id="comments" name="comments" class="form-control" placeholder="Comments" required=""><?php if(!empty($gamedetails->Game_Comments)) echo $gamedetails->Game_Comments; ?></textarea>
									</div>
								</div>					
							</div>
							<div class="row name" id="header">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="name"><span class="alert-danger">*</span>Header</label>
										<textarea id="Game_Header" name="Game_Header" class="form-control" placeholder="Header" required=""><?php if(!empty($gamedetails->Game_Header)) echo $gamedetails->Game_Header; ?></textarea>
									</div>
								</div>					
							</div>	

							<div class="row name">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="Game_Status" class="containerCheckbox">
											<input type="checkbox" class="" name="Game_Status" id="Game_Status" value="1"> Available For B2C
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 hidden availableB2C">
									<div class="form-group">
										<label for="Game short Description"><span class="alert-danger">*</span>Game Short Description</label>
										<textarea id="Game_shortDescription" name="Game_shortDescription" class="form-control" placeholder="Short Description"><?php if(!empty($gamedetails->Game_shortDescription)) echo $gamedetails->Game_shortDescription; ?></textarea>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 hidden availableB2C">
									<div class="form-group">
										<label for="Game short Description"><span class="alert-danger">*</span>Game Long Description</label>
										<textarea id="Game_longDescription" name="Game_longDescription" class="form-control" placeholder="Long Description"><?php if(!empty($gamedetails->Game_longDescription)) echo $gamedetails->Game_longDescription; ?></textarea>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 hidden availableB2C">
									<div class="form-group">
										<label for="Game Prize"><span class="alert-danger">*</span>Game Prize</label>
										<input type="text" id="Game_prize" name="Game_prize" class="form-control" placeholder="Long Description" value="<?php echo ($gamedetails->Game_prize)?$gamedetails->Game_prize:'0.00'; ?>">
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 hidden availableB2C">
									<div class="form-group">
										<label for="Game Discount"><span class="alert-danger">*</span>Game Discount</label>
										<input type="text" id="Game_discount" name="Game_discount" class="form-control" placeholder="Long Description" value="<?php echo ($gamedetails->Game_discount)?$gamedetails->Game_discount:'0.00'; ?>">
									</div>
								</div>
							</div>	

							<div class="row name">
								<div >
									<div class="form-group">
										<label for="name"><span class="alert-danger">*</span>Message</label>
										<textarea id="message" name="message" class="form-control" placeholder="Message"><?php if(!empty($gamedetails->Game_Message)) echo $gamedetails->Game_Message; ?></textarea>
									</div>
								</div>
							</div>

							<div class="row name">
								<div class="col-md-6 col-xs-12">
									<div class="form-group">
										<label for="name">Game Image</label>
										<input type="file" class="form-control" name="Game_Image" id="Game_Image">
									</div>
								</div>
								<?php if(!empty($gamedetails->Game_Image)) { ?>
									<div class="col-md-6 col-xs-12">
										<img src="<?php echo site_root.'images/'.$gamedetails->Game_Image;?>" alt="Game Image" width="150">
									</div>
								<?php } ?>
							</div>
							<br>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group text-center">
										<?php if(isset($_GET['edit']) && !empty($_GET['edit'])){?>
											<button type="button" id="game_btn_update" class="btn btn-primary"> Update </button>
											<button type="submit" name="submit" id="game_update" class="btn btn-primary hidden" value="Update"> Update </button>
											<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
										<?php }else{?>
											<button type="button" id="game_btn" class="btn btn-primary" value="Submit"> Add </button>
											<button type="submit" name="submit" id="game_sbmit" class="btn btn-primary hidden" value="Submit"> Add </button>
											<button type="button" class="btn btn-danger" onclick="window.location='<?php echo $url; ?>';"> Cancel </button>
										<?php }?>
									</div>
								</div>
							</div>
						</form>

						<?php 
						if(isset($_GET['edit']) && !empty($_GET['edit'])){	
								//include_once doc_root.'ux-admin/view/Game/tabheader.php';
						}
						?>	

					</div>
					<div class="clearfix"></div>
					<script type="text/javascript">
						<!--
							CKEDITOR.replace('message');
//-->
</script>
<script>
	$(document).ready(function(){
		// to show the for b2c available games if checked
		$('#Game_Status').on('click',function(){
			if($(this).is(':checked'))
			{
				$('.availableB2C').each(function(i,e){
					$(this).removeClass('hidden');
					$('#Game_shortDescription').prop('required',true);
					$('#Game_longDescription').prop('required',true);
					$('#Game_prize').prop('required',true);
					$('#Game_discount').prop('required',true);
				});
			}
			else
			{
				$('.availableB2C').each(function(i,e){
					$(this).addClass('hidden');
					$('#Game_shortDescription').prop('required',false);
					$('#Game_longDescription').prop('required',false);
					$('#Game_prize').prop('required',false);
					$('#Game_discount').prop('required',false);
				});
			}
		});
		// if available for b2c then show all field and mark as checked
		<?php if($gamedetails->Game_Status){ ?>
			$('#Game_Status').trigger('click');
		<?php } ?>

		$('#game_btn').click( function(){
			//	if($("#siteuser_frm").valid()){		
				$( "#game_sbmit" ).trigger( "click" );
			//	}
		});

		$('#game_btn_update').click( function(){
			//	if($("#siteuser_frm").valid()){
				$( "#game_update" ).trigger( "click" );
			//	}
		});

		disableCheckboxIfBotEnabled();
		makeCheckBoxDisable();

	});

	function disableCheckboxIfBotEnabled()
	{
		// if game is bot-enabled then disable all checkboxes
		$('#Game_Type').on('click',function(){
			makeCheckBoxDisable();
		});
	}

	function makeCheckBoxDisable()
	{
		if($('#Game_Type').is(':checked'))
		{
			$('#Game_IntroductionLink').prop({"disabled": true, "checked" : false});
			$('#Game_Introduction').prop({"disabled"    : true, "checked" : false});
			$('#Game_Description').prop({"disabled"     : true, "checked" : false});
			$('#Game_DescriptionLink').prop({"disabled" : true, "checked" : false});
			$('#Game_BackToIntro').prop({"disabled"     : true, "checked" : false});
		}
		else
		{
			$('#Game_IntroductionLink').prop({"disabled": false});
			$('#Game_Introduction').prop({"disabled"    : false});
			$('#Game_Description').prop({"disabled"     : false});
			$('#Game_DescriptionLink').prop({"disabled" : false});
			$('#Game_BackToIntro').prop({"disabled"     : false});
		}
	}
// -->
</script>
