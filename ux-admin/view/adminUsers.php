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
									<div class="col-md-2 pull-right">
										<label for="Check All" class="containerCheckbox" id="select_all_checkbox">
											<input id="select_all" type="checkbox" > Check All
											<span class="checkmark"></span>
										</label>
									</div>
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
													$val    = $userdetails->admin_rights;
													$rights = json_decode($val, true);
													//echo "<pre>";print_r($rights);exit;
													$data   = $rights['innerlinkage']['innerPermission'];
													//echo "<pre>";print_r($data);exit;
													?>
													<td>
														<div class="col-md-2">
															<label for="area_enable" class="containerCheckbox">
																<input type="checkbox" id="area_enable" name="area_enable" value="yes" <?=$rights['area']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="area_add" class="containerCheckbox">
																<input type="checkbox" id="area_add" name="area_add" value="yes" <?=$rights['area']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="area_edit" class="containerCheckbox">
																<input type="checkbox" id="area_edit" name="area_edit" value="yes" <?=$rights['area']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="area_delete" class="containerCheckbox">
																<input type="checkbox" id="area_delete" name="area_delete" value="yes" <?=$rights['area']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>

												<tr>
													<td>Component</td>
													<td>
														<div class="col-md-2">
															<label for="component_enable" class="containerCheckbox">
																<input type="checkbox" id="component_enable" name="component_enable" value="yes" <?=$rights['component']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="component_add" class="containerCheckbox">
																<input type="checkbox" id="component_add" name="component_add" value="yes" <?=$rights['component']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="component_edit" class="containerCheckbox">
																<input type="checkbox" id="component_edit" name="component_edit" value="yes" <?=$rights['component']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="component_delete" class="containerCheckbox">
																<input type="checkbox" id="component_delete" name="component_delete" value="yes" <?=$rights['component']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>

												<tr>
													<td>Sub Component</td>
													<td>
														<div class="col-md-2">
															<label for="subcomponent_enable" class="containerCheckbox">
																<input type="checkbox" id="subcomponent_enable" name="subcomponent_enable" value="yes" <?=$rights['sub component']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="subcomponent_add" class="containerCheckbox">
																<input type="checkbox" id="subcomponent_add" name="subcomponent_add" value="yes" <?=$rights['sub component']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="subcomponent_edit" class="containerCheckbox">
																<input type="checkbox" id="subcomponent_edit" name="subcomponent_edit" value="yes" <?=$rights['sub component']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="subcomponent_delete" class="containerCheckbox">
																<input type="checkbox" id="subcomponent_delete" name="subcomponent_delete" value="yes" <?=$rights['sub component']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>

												<tr>
													<td>Game</td>
													<td>
														<div class="col-md-2">
															<label for="game_enable" class="containerCheckbox">
																<input type="checkbox" id="game_enable" name="game_enable" value="yes" <?=$rights['game']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="game_add" class="containerCheckbox">
																<input type="checkbox" id="game_add" name="game_add" value="yes" <?=$rights['game']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="game_edit" class="containerCheckbox">
																<input type="checkbox" id="game_edit" name="game_edit" value="yes" <?=$rights['game']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="game_delete" class="containerCheckbox">
																<input type="checkbox" id="game_delete" name="game_delete" value="yes"<?=$rights['game']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>

												<tr>
													<td>Scenario</td>
													<td>
														<div class="col-md-2">
															<label for="scenario_enable" class="containerCheckbox">
																<input type="checkbox" id="scenario_enable" name="scenario_enable" value="yes" <?=$rights['scenario']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="scenario_add" class="containerCheckbox">
																<input type="checkbox" id="scenario_add" name="scenario_add" value="yes" <?=$rights['scenario']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="scenario_edit" class="containerCheckbox">
																<input type="checkbox" id="scenario_edit" name="scenario_edit" value="yes" <?=$rights['scenario']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="scenario_delete" class="containerCheckbox">
																<input type="checkbox" id="scenario_delete" name="scenario_delete" value="yes" <?=$rights['scenario']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>

												<tr>
													<td>Formulas</td>
													<td>
														<div class="col-md-2">
															<label for="formulas_enable" class="containerCheckbox">
																<input type="checkbox" id="formulas_enable" name="formulas_enable" value="yes" <?=$rights['formulas']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="formulas_add" class="containerCheckbox">
																<input type="checkbox" id="formulas_add" name="formulas_add" value="yes" <?=$rights['formulas']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="formulas_edit" class="containerCheckbox">
																<input type="checkbox" id="formulas_edit" name="formulas_edit" value="yes" <?=$rights['formulas']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="formulas_delete" class="containerCheckbox">
																<input type="checkbox" id="formulas_delete" name="formulas_delete" value="yes" <?=$rights['formulas']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>

												<tr>
													<td>Linkage</td>
													<td>
														<div class="col-md-2">
															<label for="linkage_enable" class="containerCheckbox">
																<input type="checkbox" id="linkage_enable" name="linkage_enable" value="yes" <?=$rights['linkage']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="linkage_add" class="containerCheckbox">
																<input type="checkbox" id="linkage_add" name="linkage_add" value="yes" <?=$rights['linkage']['add']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="linkage_edit" class="containerCheckbox">
																<input type="checkbox" id="linkage_edit" name="linkage_edit" value="yes" <?=$rights['linkage']['edit']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td>
														<div class="col-md-2">
															<label for="linkage_delete" class="containerCheckbox">
																<input type="checkbox" id="linkage_delete" name="linkage_delete" value="yes" <?=$rights['linkage']['delete']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
												</tr>
												<!-- adding inner linage -->
												<tr>
													<td><i class="glyphicon glyphicon-plus-sign" id="showMore"> Inner Linkage</i>
														<i class="glyphicon glyphicon-minus-sign hidden" id="showLess"> Inner Linkage</i>
													</td>
													<td>
														<div class="col-md-2">
															<label for="innerlinkage_enable" class="containerCheckbox">
																<input type="checkbox" id="innerlinkage_enable" value="yes" name="innerlinkage_enable" <?=$rights['innerlinkage']['enable']=='yes'?'checked="yes"':''?>>
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td class="enableDisable">
														<div class="col-md-2">
															<label for="innerlinkage_add" class="containerCheckbox">
																<input type="checkbox" class="enablecheckboxes" id="innerlinkage_add" name="innerlinkage_add" value="yes" <?=$rights['innerlinkage']['add']=='yes'?'checked="yes"':''?> disabled="">
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td class="enableDisable">
														<div class="col-md-2">
															<label for="innerlinkage_edit" class="containerCheckbox">
																<input type="checkbox" class="enablecheckboxes" id="innerlinkage_edit" name="innerlinkage_edit" value="yes" <?=$rights['innerlinkage']['edit']=='yes'?'checked="yes"':''?> disabled="">
																<span class="checkmark"></span>
															</label>
														</div>
													</td>
													<td class="enableDisable">
														<div class="col-md-2">
															<label for="innerlinkage_delete" class="containerCheckbox">
																<input type="checkbox" class="enablecheckboxes" id="innerlinkage_delete" name="innerlinkage_delete" value="yes" <?=$rights['innerlinkage']['delete']=='yes'?'checked="yes"':''?> disabled="">
																<span class="checkmark"></span>
															</label>
														</div>
													</td>

													<tr id="showhideArea" class="collapse">
														<td>Select Area</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="areaL_edit" class="containerCheckbox">
																	<input type="checkbox" id="areaL_edit" name="areaL_edit" value="yes"<?=$data['edit_area']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>	
													</tr>

													<tr id="showhideComponent" class="collapse">
														<td>Select Component</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="componentL_edit" class="containerCheckbox">
																	<input type="checkbox" id="componentL_edit" name="componentL_edit" value="yes"<?=$data['edit_compo']=='yes'?'checked="yes"':''?>class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideSubComponent" class="collapse">
														<td>Select SubComponent</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="subcompoL_edit" class="containerCheckbox">
																	<input type="checkbox" id="subcompoL_edit" name="subcompoL_edit" value="yes"<?=$data['edit_subcompo']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideviewingorder" class="collapse">
														<td>Select ViewingOrder</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="viewingorder_edit" class="containerCheckbox">
																	<input type="checkbox" id="viewingorder_edit" name="viewingorder_edit" value="yes"<?=$data['edit_viewingorder']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>


													<tr id="showhideLabel" class="collapse">
														<td>Select Label Current/Last</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="labelC_edit" class="containerCheckbox">
																	<input type="checkbox" id="labelC_edit" name="labelC_edit" value="yes"<?=$data['edit_label']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideOrder" class="collapse">
														<td>Select Label Order</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="labelOrder_edit" class="containerCheckbox">
																	<input type="checkbox" id="labelOrder_edit" name="labelOrder_edit" value="yes"<?=$data['edit_labelOrder']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideBGColor" class="collapse">
														<td>Select BG Color</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="bgColor_edit" class="containerCheckbox">
																	<input type="checkbox" id="bgColor_edit" name="bgColor_edit" value="yes"<?=$data['edit_bgcolor']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideTextColor" class="collapse">
														<td>Select Text Color</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="textbgColor_edit" class="containerCheckbox">
																	<input type="checkbox" id="textbgColor_edit" name="textbgColor_edit" value="yes"<?=$data['edit_textbgcolor']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideType" class="collapse">
														<td>Select Type</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="type_edit" class="containerCheckbox">
																	<input type="checkbox" id="type_edit" name="type_edit" value="yes"<?=$data['edit_type']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideOrder" class="collapse">
														<td>Select Order</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="order_edit" class="containerCheckbox">
																	<input type="checkbox" id="order_edit" name="order_edit" value="yes"<?=$data['edit_order']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>


													<tr id="showhideshowhide" class="collapse">
														<td>Select show/hide</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="showhide_edit" class="containerCheckbox">
																	<input type="checkbox" id="showhide_edit" name="showhide_edit" value="yes"<?=$data['edit_showhide']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideReplace" class="collapse">
														<td>Select Replace</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="replace_edit" class="containerCheckbox">
																	<input type="checkbox" id="replace_edit" name="replace_edit" value="yes"<?=$data['edit_replace']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
													</tr>

													<tr id="showhideChart" class="collapse">
														<td>Select Chart</td>

														<td colspan="4" class="enableDisableSub">
															<div class="col-md-2" style="margin-left:50%;">
																<label for="chart_edit" class="containerCheckbox">
																	<input type="checkbox" id="chart_edit" name="chart_edit" value="yes"<?=$data['edit_chart']=='yes'?'checked="yes"':''?> class="enableall" disabled="">
																	<span class="checkmark"></span>
																</label>
															</div>
														</td>
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
		enableInnerLinkageCheckboxes();
		enableEditChceckboxesForInnerLinkage();

		$('input[type="checkbox"]').on('click',function(){
			enableInnerLinkageCheckboxes();
			enableEditChceckboxesForInnerLinkage();
			if(!$(this).is(':checked')){
				$('#select_all').prop('checked', false);
			}
		});
	});

	// to enable/disable inner linkage add/edit/delete checkboxes
	function enableInnerLinkageCheckboxes()
	{
		if($('#innerlinkage_enable').is(':checked'))
		{
			$('.enablecheckboxes').removeAttr("disabled");
			$('.enableDisable').css({'background-color':'#ffffff'});
		}
		else
		{  
			$('.enablecheckboxes').attr("disabled",true);
			$('#innerlinkage_edit').prop('checked', false);
			$('.enableall').prop('checked', false);
			$('.enablecheckboxes').prop('checked', false);
			$('.enableDisable').css({'background-color':'#d3d3d3'});
		}
	}

	// to enable disable input in the linkage page while, inner linkage edit checkbox is checked
	function enableEditChceckboxesForInnerLinkage()
	{
		if(($('#innerlinkage_edit').is(':checked')) && (!$('#innerlinkage_edit').is(':disabled')))
		{
			$('.enableall').removeAttr("disabled");
			$('.enableDisableSub').css({'background-color':'#ffffff'});
		}
		else
		{
			$('.enableall').attr("disabled",true);
			$('.enableall').attr("checked",false);
			$('.enableDisableSub').css({'background-color':'#d3d3d3'});
		}
	}

</script>
