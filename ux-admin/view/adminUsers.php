<style type="text/css">
	input:focus:invalid {
		border-color: red;
	}

	input:focus:valid {
		border-color: green;
	}

	span.alert-danger {
		background-color: #ffffff;
		font-size: 18px;
	}

	.access_user {
		margin-bottom: 2px;
	}
	#category_selection  .form-group, #access_selection .form-group{
		margin-bottom: 5px;
	}
</style>

<script type="text/javascript">
	<!--
		var loc_url_del = "ux-admin/AdminUsers/delete=";
		var loc_url_stat = "ux-admin/AdminUsers/stat=";
//-->
</script>

<div class="row">
	<div class="col-sm-12">
		<h1 class="page-header">Admin Users</h1>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active"><a href="javascript:void(0);">Manage Users</a></li>
			<li class="active">Admin Users</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){ ?>
	<div class="form-group <?php echo $type[1]; ?>">
		<div align="center" class="form-control" id="<?php echo $type[0]; ?>">
			<label class="control-label" for="<?php echo $type[0] ?>"><?php echo $msg ?></label>
		</div>
	</div>
<?php } ?>

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<b>Add User</b>
			</div>
			<form role="form" method="POST" action="">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<b>User Details</b>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-xs-6 col-sm-6">
											<div class="form-group">
												<input type="hidden" name="userid" class="form-control"
												value="<?php if(isset($_GET['edit']) && isset($userdetails)){echo $userdetails->id;}?>" />
												<input type="text" name="fname" class="form-control"
												pattern="[a-zA-Z]{3,}" placeholder="First Name"
												value="<?php if(!empty($userdetails->fname)){ echo $userdetails->fname; } ?>"
												required />
											</div>
										</div>
										<div class="col-xs-6 col-sm-6">
											<div class="form-group">
												<input type="text" name="lname" class="form-control"
												pattern="[a-zA-Z]{3,}" placeholder="Last Name"
												value="<?php if(!empty($userdetails->lname)){ echo $userdetails->lname; } ?>"
												required />
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
									
									<div class="row">
										<div class="col-xs-6 col-sm-6">
											<div class="form-group">
												<input type="text" pattern=".{5,}" name="username" id="username"
												class="form-control" placeholder="Username"
												value="<?php if(!empty($userdetails->username)){ echo $userdetails->username; } ?>"
												required />
											</div>
										</div>
										
										<div class="col-xs-6 col-sm-6">
											<div class="form-group">
												<input type="email"
												pattern="[\Sa-zA-Z0-9]{3,}@[a-zA-Z]{3,}.[a-zA-Z]{2,}"
												name="email" class="form-control" placeholder="Email"
												value="<?php if(!empty($userdetails->email)){ echo $userdetails->email; } ?>"
												<?php if(isset($_GET['edit'])){ echo 'disabled'; }else{ echo 'required'; } ?> />
											</div>
										</div>
									</div>
									<div class="username_error"></div>
									<div class="clearfix"></div>
									
									
									<div class="row">
										<div class="col-xs-6 col-sm-6">
											<div class="form-group">
												<input type="password" pattern=".{5,}" name="password"
												class="form-control" value=""
												placeholder="<?php if(isset($_GET['edit'])){ echo "New Password";}else{echo "Password";} ?>"
												<?php if(!isset($_GET['edit'])){echo 'required'; } ?>>
											</div>
										</div>
										
										<div class="col-xs-6 col-sm-6">
											<div class="form-group">
												<input type="password" pattern=".{5,}" name="retypepass"
												class="form-control" placeholder="Re-Type Password"
												<?php if(!isset($_GET['edit'])){echo 'required'; } ?>>
											</div>
										</div>
										
									</div>
									<div class="clearfix"></div>
									
								</div>
							</div>
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<b>User Rights Modification</b>
									<label for="Check All" class="pull-right">
										<input type="checkbox" id="checkAllCheckboxes"> Check All
									</label>
								</div>
								
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" >
											<thead>
												<tr>
													<th >Menu</th>
													<th width="180">Enable/Disable</th>
													<th>Add</th>
													<th>Edit</th>
													<th>Delete</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Area</td>
													<?php
													$val = $userdetails->admin_rights;
													$rights = json_decode($val, true);
													//echo "<pre>";print_r($rights);exit;
													$data = $rights['innerlinkage']['innerPermission'];
													//echo "<pre>";print_r($data);exit;
													?>
													<td><input type="checkbox" name="area_enable" value="yes" <?=$rights['area']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="area_add" value="yes" <?=$rights['area']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="area_edit" value="yes" <?=$rights['area']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="area_delete" value="yes" <?=$rights['area']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												
												<tr>
													<td>Component</td>
													<td><input type="checkbox" name="component_enable" value="yes" <?=$rights['component']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="component_add" value="yes" <?=$rights['component']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="component_edit" value="yes" <?=$rights['component']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="component_delete" value="yes" <?=$rights['component']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												
												<tr>
													<td>Sub Component</td>
													<td><input type="checkbox" name="subcomponent_enable" value="yes" <?=$rights['sub component']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="subcomponent_add" value="yes" <?=$rights['sub component']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="subcomponent_edit" value="yes" <?=$rights['sub component']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="subcomponent_delete" value="yes" <?=$rights['sub component']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												
												<tr>
													<td>Game</td>
													<td><input type="checkbox" name="game_enable" value="yes" <?=$rights['game']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="game_add" value="yes" <?=$rights['game']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="game_edit" value="yes" <?=$rights['game']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="game_delete" value="yes"<?=$rights['game']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												
												<tr>
													<td>Scenario</td>
													<td><input type="checkbox" name="scenario_enable" value="yes" <?=$rights['scenario']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="scenario_add" value="yes" <?=$rights['scenario']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="scenario_edit" value="yes" <?=$rights['scenario']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="scenario_delete" value="yes" <?=$rights['scenario']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												
												<tr>
													<td>Formulas</td>
													<td><input type="checkbox" name="formulas_enable" value="yes" <?=$rights['formulas']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="formulas_add" value="yes" <?=$rights['formulas']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="formulas_edit" value="yes" <?=$rights['formulas']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="formulas_delete" value="yes" <?=$rights['formulas']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												
												<tr>
													<td>Linkage</td>
													<td><input type="checkbox" name="linkage_enable" value="yes" <?=$rights['linkage']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="linkage_add" value="yes" <?=$rights['linkage']['add']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="linkage_edit" value="yes" <?=$rights['linkage']['edit']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" name="linkage_delete" value="yes" <?=$rights['linkage']['delete']=='yes'?'checked="yes"':''?>></td>
												</tr>
												<!-- adding inner linage -->
												<tr>
													<td><i class="glyphicon glyphicon-plus-sign" id="showMore"></i>
														<i class="glyphicon glyphicon-minus-sign hidden" id="showLess"></i>
													Inner Linkage</td>
													<td><input type="checkbox" name="innerlinkage_enable" id="enableInnerLinkage" value="yes" <?=$rights['innerlinkage']['enable']=='yes'?'checked="yes"':''?>></td>
													<td><input type="checkbox" class="enablecheckboxes" name="innerlinkage_add" value="yes" <?=$rights['innerlinkage']['add']=='yes'?'checked="yes"':''?> disabled=""></td>
													<td><input type="checkbox" class="enablecheckboxes" id="enablechecks" name="innerlinkage_edit" value="yes" <?=$rights['innerlinkage']['edit']=='yes'?'checked="yes"':''?> disabled="" ></td>
													<td><input type="checkbox" class="enablecheckboxes" name="innerlinkage_delete" value="yes" <?=$rights['innerlinkage']['delete']=='yes'?'checked="yes"':''?> disabled=""></td>

													<tr id="showhideArea" class="collapse">
														<td>Select Area</td>
														
														<td colspan="4"><input type="checkbox" name="areaL_edit" value="yes"<?=$data['edit_area']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>
													</tr>

													<tr id="showhideComponent" class="collapse">
														<td>Select Component</td>
														
														<td colspan="4"><input type="checkbox" name="componentL_edit" value="yes"<?=$data['edit_compo']=='yes'?'checked="yes"':''?>class="enableall" disabled="" style="margin-left:55%;"></td>
														
													</tr>

													<tr id="showhideSubComponent" class="collapse">
														<td>Select SubComponent</td>
														
														<td colspan="4"><input type="checkbox" name="subcompoL_edit" value="yes"<?=$data['edit_subcompo']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

														<tr id="showhideviewingorder" class="collapse">
														<td>Select ViewingOrder</td>
														
														<td colspan="4"><input type="checkbox" name="viewingorder_edit" value="yes"<?=$data['edit_viewingorder']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>


													<tr id="showhideLabel" class="collapse">
														<td>Select Label Current/Last</td>
														
														<td colspan="4"><input type="checkbox" name="labelC_edit" value="yes"<?=$data['edit_label']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

													<tr id="showhideOrder" class="collapse">
														<td>Select Label Order</td>

														<td colspan="4"><input type="checkbox" name="labelOrder_edit" value="yes"<?=$data['edit_labelOrder']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

													<tr id="showhideBGColor" class="collapse">
														<td>Select BG Color</td>
														
														<td colspan="4"><input type="checkbox" name="bgColor_edit" value="yes"<?=$data['edit_bgcolor']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

													<tr id="showhideTextColor" class="collapse">
														<td>Select Text Color</td>
														
														<td colspan="4"><input type="checkbox" name="textbgColor_edit" value="yes"<?=$data['edit_textbgcolor']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>
														
													</tr>

													<tr id="showhideType" class="collapse">
														<td>Select Type</td>
														
														<td colspan="4"><input type="checkbox" name="type_edit" value="yes"<?=$data['edit_type']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

													<tr id="showhideOrder" class="collapse">
														<td>Select Order</td>

														<td colspan="4"><input type="checkbox" name="order_edit" value="yes"<?=$data['edit_order']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>


													<tr id="showhideshowhide" class="collapse">
														<td>Select show/hide</td>

														<td colspan="4"><input type="checkbox" name="showhide_edit" value="yes"<?=$data['edit_showhide']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

													<tr id="showhideReplace" class="collapse">
														<td>Select Replace</td>
														
														<td colspan="4"><input type="checkbox" name="replace_edit" value="yes"<?=$data['edit_replace']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>

													<tr id="showhideChart" class="collapse">
														<td>Select Chart</td>
														
														<td colspan="4"><input type="checkbox" name="chart_edit" value="yes"<?=$data['edit_chart']=='yes'?'checked="yes"':''?> class="enableall" disabled="" style="margin-left:55%;"></td>

													</tr>
												</tr>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
						</div>

					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group" align="center">
							<?php if(isset($_GET['edit'])){?>
								<input type="submit" name="submit" value="Update" 
								class="btn btn-primary" />
								<a href="<?php echo site_root."ux-admin/AdminUsers";?>"
									class="btn btn-primary">Cancel</a>
								<?php }else{?>
									<input type="submit" name="submit" value="Submit" id="submit"
									class="btn btn-primary" />
								<?php }?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#showMore').on('click', function() {
			$(this).addClass('hidden');
			$('#showLess').removeClass('hidden');
			$('.collapse').each(function(){
				$(this).toggle();
			});
		});
		$('#showLess').on('click',function(){
			$(this).addClass('hidden');
			$('#showMore').removeClass('hidden');
			$('.collapse').each(function(){
				$(this).toggle();
			});
		});
	});

	$(document).ready(function(){
		// for all checkboxes to be checked/unchecked
		$('#checkAllCheckboxes').on('click',function(){
			if($(this).is(':checked')){
				$('input[type="checkbox"]').prop('checked', true);
			}
			else
			{
				$('input[type="checkbox"]').prop('checked', false);
			}
		});
		enableInnerLinkageCheckboxes();
		enableEditChceckboxesForInnerLinkage();

		$('input[type="checkbox"]').on('click',function(){
			enableInnerLinkageCheckboxes();
			enableEditChceckboxesForInnerLinkage();
			if(!$(this).is(':checked')){
				$('#checkAllCheckboxes').prop('checked', false);
			}
		});
	});

	// to enable/disable inner linkage add/edit/delete checkboxes
	function enableInnerLinkageCheckboxes()
	{
		if($('#enableInnerLinkage').is(':checked'))
		{
			$('.enablecheckboxes').removeAttr("disabled");
		}
		else
		{  
			$('.enablecheckboxes').attr("disabled",true);
			$('#enablechecks').prop('checked', false);
			$('.enableall').prop('checked', false);

		}
	}

	// to enable disable input in the linkage page while, inner linkage edit checkbox is checked
	function enableEditChceckboxesForInnerLinkage()
	{
		if(($('#enablechecks').is(':checked')) && (!$('#enablechecks').is(':disabled')))
		{
			$('.enableall').removeAttr("disabled");
		}
		else
		{
			$('.enableall').attr("disabled",true);
		}
	}

</script>
