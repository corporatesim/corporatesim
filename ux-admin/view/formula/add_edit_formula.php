<!-- <?php // echo "<pre>"; print_r($subcomponents->fetch_object()); exit; ?> -->
	<script type="text/javascript">
		<!--
			var loc_url_del  = "ux-admin/ManageGame/del/";
			var loc_url_stat = "ux-admin/ManageGame/stat/";
//-->
</script>

<style>
<!--
.undo_btn{
	position: absolute;
	bottom  : 15px; 
}
.formula_box{
	display: flex;
}

.components, .operators, .subcomponents{
	list-style: none;
	margin    : 0;
	padding   : 0;
	border    : 1px solid #d8d8d8;
	height    : 300px;
	overflow-y: scroll;
}

.components li, .operators li, .subcomponents li{
	cursor : pointer;
	padding: 2px 10px;
}

.components li:hover, .operators li:hover, .subcomponents li:hover{
	background-color: #f8f8f8;
}

@media only screen and (max-width:360px){
	.undo_btn{
		position: unset;
		bottom  : auto;
	}
	.formula_box{
		display: unset;
	}
}
-->
</style>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $head; ?></h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a
				href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
				<li class="completed">
					<a href="javascript:void(0);"> Master Management</a></li>
					<li class="active"><a href="<?php echo site_root; ?>ux-admin/Formulas"> Formulas</a></li>
					<li class="active"><?php echo $head; ?></li>
				</ul>
			</div>
		</div>

		<div class="error_box">
			<label></label>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="row">
					<div class="formula_box">			
						<div class="col-xs-12 col-sm-12 col-md-9 form-group">
							<label>Formula title</label>
							<input type="hidden" name="id" id="id" 
							value="<?php if(isset($_GET['edit'])){ echo $details->f_id; } ?>">
							<input type="text" name="formula_title" 
							value="<?php if(!empty($details->formula_title)) echo $details->formula_title; ?>"
							id="formula_title" class="form-control" />
						</div>
					</div>
					<?php if(!empty($details->expression_string)) {?>
						<div class="formula_box">
							<div class="col-xs-12 col-sm-8 col-md-8 form-group">
								<label>View Original Formula</label>
								<textarea name="formula_view" id="formula_view" class="form-control" rows="5" readonly><?php if(!empty($details->expression_string)) echo $details->expression_string; ?></textarea>
							</div>
						</div>
					<?php } ?>
					<div class="formula_box">	
						<div class="col-sm-6">
							<label>Count of ( : </label><label id="openbracket" name="openbracket" >0</label>
						</div>
						<div class="col-sm-6">
							<label>Count of ) : </label><label id="closebracket" name="closebracket" >0</label>
						</div>
					</div>
					<div class="formula_box">				
						<div class="col-xs-12 col-sm-8 col-md-8 form-group">
							<label>Create Formula</label>
							<textarea name="formula" id="formula" class="form-control" rows="10" readonly><?php if(!empty($details->expression_string)) echo $details->expression_string; ?></textarea>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4">
							<button type="button" class="btn btn-default undo_btn" style="">Undo</button>
						</div>
					</div>
					<div class="clearfix"></div>

					<!-- Games -->
					<div class="col-xs-12 col-sm-4 col-md-4 form-group">
						<label><span class="alert-danger">*</span>Select Game</label> 
						<select class="form-control" name="game_id" id="game_id">
							<option value="">-- SELECT --</option>
							<?php 
						// Fetch Services list
							$game = $functionsObj->SelectData(array(), 'GAME_GAME', array('Game_Delete=0'), '', '', '', '', 0);
							while($row = $game->fetch_object()){ ?>
								<option value="<?php echo $row->Game_ID; ?>">
									<?php echo $row->Game_Name; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<!-- END Games -->

					<!-- Scenario -->
					<div class="col-xs-12 col-sm-4 col-md-4 form-group hidden" id="scenarioSelect">
						<label><span class="alert-danger">*</span>Select Scenario</label> 
						<select class="form-control" name="scen_id" id="scen_id">
							<option value="">-- SELECT --</option>
							<?php 
						// Fetch Services list
							$scenario = $functionsObj->SelectData(array(), 'GAME_SCENARIO', array('Scen_Delete=0'), '', '', '', '', 0);
							while($row = $scenario->fetch_object()){ ?>
								<option value="<?php echo $row->Link_ID; ?>">
									<?php echo $row->Scen_Name; ?>
								</option>
							<?php } ?>
						</select>
					</div>
					<!-- END Games -->

					<div class="clearfix"></div>	

					<!-- Components -->
					<div class="col-xs-12 col-sm-4 col-md-4 form-group">
						<label>Components </label>
						<ul class="components" name="comp_id" id="comp_id">
							<?php
							if( $components->num_rows > 0 ) {
								while( $rows = $areaComponents->fetch_object() ){ ?>
									<li id="comp_<?php echo $rows->Comp_ID; ?>" value="{<?php echo $rows->Comp_Name; ?>}" data-toggle="tooltip" title="<?php echo $rows->AreaName; ?>">
										<?php echo $rows->Comp_Name; ?>
										</li><?php
									}
								} ?>
							</ul>
						</div>
						<!-- END Components -->

						<!-- Sub Components -->
						<div class="col-xs-12 col-sm-4 col-md-4 form-group">
							<label>Sub Components </label>
							<ul class="subcomponents" name="subcomp_id" id="subcomp_id">
								<?php
								if( $subcomponents->num_rows > 0 ) {
									while( $rows = $areaSubcomponents->fetch_object() ){ ?>
										<li id="subc_<?php echo $rows->SubComp_ID; ?>" value="{<?php echo $rows->SubComp_Name; ?>}" data-toggle="tooltip" title="<?php echo 'Area: '.$rows->AreaName.', Component: '.$rows->ComponentName;?>">
											<?php echo $rows->SubComp_Name; ?>
											</li><?php
										}
									} ?>
								</ul>
							</div><!-- END Sub Components -->

							<!-- Math Operators -->
							<div class="col-xs-12 col-sm-4 col-md-1 form-group">
								<label>Operators</label>
								<ul class="operators"><?php
								if( $operators->num_rows > 0 ) {
									while( $rows = $operators->fetch_object() ){ ?>
										<li id="<?php echo $rows->operator; ?>" value="{<?php echo $rows->operator; ?>}">
											<?php echo $rows->operator; ?>
											</li><?php
										}
									} ?>
								</ul>
							</div><!-- END Math Operators -->

							<div class="col-xs-12 col-sm-12 col-md-8 form-group text-center">
								<button type="button" class="btn btn-primary" name="add_formula" id="add_formula">Submit</button>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>

				<script type="text/javascript">
// <!--
var formula        = [];
var formula_string = [];

	//$('.components li, .subcomponents li, .operators li').click( function(){
		$('.components, .subcomponents, .operators').on('click', 'li', function () {
			formula.push( $( this ).attr( 'id' ) );
		// console.log( formula.join(" ") );
		//alert($( this ).attr('value'));
		if($( this ).attr('value') == '{(}'){
			$('#openbracket').html(parseInt(($('#openbracket').html()),10)+1);			
		}		
		if($( this ).attr('value') == '{)}'){
			$('#closebracket').html(parseInt(($('#closebracket').html()),10)+1);
		}
		formula_string.push( $( this ).attr('value') );
		$('#formula').text( formula_string.join(" ") );
	});

		$('.undo_btn').click( function(){
			var fpop  = formula.pop();
			var fspop = formula_string.pop();
		//alert(fpop);
		//alert(fspop);
		if(fspop == '{(}'){
			$('#openbracket').html(parseInt(($('#openbracket').html()),10)-1);			
		}		
		if(fspop == '{)}'){
			$('#closebracket').html(parseInt(($('#closebracket').html()),10)-1);
		}
		$('#formula').text( formula_string.join(" ") );
	});

		$('#add_formula').click( function(){
			if( $('#formula').val() != '' ){

				$('.error_box label').removeClass('error');
				$('.error_box label').html('');
				var formula_title = $('#formula_title').val();
				var formula_exp   = formula.join(" ");
				var formula_str   = formula_string.join(" ");
				var formula_id    = $('#id').val();
				var game_id       = $("#game_id").val();
				var scen_id       = $("#scen_id").val();
			//alert(formula_id); 
			//alert("formula_exp "+formula_exp);
			//alert("formula_str "+formula_str);
			$.ajax({
				url : site_root + "ux-admin/model/ajax/game_add_formula.php",
				type: "POST",
				data: { formula_title: formula_title, formula: formula_exp, formula_string: formula_str, formula_id: formula_id, game_id: game_id, scen_id: scen_id },
				beforeSend: function(){
					// Show loading Icon
				},
				success: function( result ){
					//alert(result);
					try{
						var response = JSON.parse( result );
						if( response.status == 1 ){
							$('.error_box label').removeClass('error');
							$('.error_box label').html( '' );
							window.location = site_root + 'ux-admin/Formulas';
						} else {
							$('.error_box label').removeClass('error');
							$('.error_box label').html( response.msg );
							$('.error_box label').addClass('success');
						}
					} catch( e ){
						console.log( result );
					}
				}
			});
		} else {
			$('.error_box label').html('Please Create formula to add formula');
			$('.error_box label').addClass('error');
			$('html, body').animate({
				scrollTop: ($('.error_box label').offset().top)
			}, 'fast');
		}
	});

		$('#game_id').change( function(){
			var game_id = $(this).val();
		//alert(comp_id);
		if(game_id.length < 1)
		{
			alert('Please Select Game.');
			$('#scenarioSelect').addClass('hidden');
			return false;
		}
		$('#scen_id').html('<option value="">-- SELECT --</option>');
		$('#scenarioSelect').removeClass('hidden');
		$.ajax({
			url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { game_id: game_id },
			success: function(data){
				$('#scen_id').html(data);
			}
		});		
	});

		$('#scen_id').change( function(){
			var scen_id = $(this).val();
		//alert(scen_id);		
		if(scen_id.length < 1)
		{
			alert('Please Select Scenario.');
			return false;
		}
		$.ajax({
			url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { comp_scen_id: scen_id },
			success: function(data){
				$('#comp_id').html(data);
			}
		});		

		$.ajax({
			url : site_root + "ux-admin/model/ajax/populate_dropdown.php",
			type: "POST",
			data: { subcomp_scen_id: scen_id },
			success: function(data){
				$('#subcomp_id').html(data);
			}
		});		
		setTimeout(function(){
			$('[data-toggle="tooltip"]').tooltip();
		},1000);
	});

//-->
</script>
