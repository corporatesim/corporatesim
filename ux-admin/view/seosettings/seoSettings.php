<style>
label{
	padding:7px 0;
	margin:0;
}
</style>
<div class="clearfix"></div>

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">SEO Settings:</h1>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<ul class="breadcrumb">
			<li class="completed"><a href="<?php echo site_root."ux-admin/Dashboard"; ?>">Home</a></li>
			<li class="active">SEO Settings</li>
		</ul>
	</div>
</div>

<?php if(isset($msg)){echo "<div class=\"form-group ". $type[1] ." \"><div align=\"center\" class=\"form-control\" id=". $type[0] ."><label class=\"control-label\" for=". $type[0] .">". $msg ."</label></div></div>";} ?>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><b>Global Setting:</b>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<form action="" method="post">
					<div class="row">
						<div class="form-group col-sm-12">
							<div class="col-sm-2"></div>
							<label class="col-sm-2" for="title">Page Title:</label>
							<div class="col-sm-6">
								<input type="hidden" name="id1" value="1">
								<input class="form-control" id="title" type="text" name="title" value="<?php echo $array[0]['content']; ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							<div class="col-sm-2"></div>
							<label class="col-sm-2" for="description">Page Description:</label>
							<div class="col-sm-6">
								<input type="hidden" name="id3" value="3">
								<textarea class="form-control" id="description" name="description"><?php echo $array[2]['content']; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-sm-12">
							<div class="col-sm-2"></div>
							<label class="col-sm-2" for="keyword">Page Keyword:</label>
							<div class="col-sm-6">
								<input type="hidden" name="id2" value="2">
								<textarea class="form-control" id="keyword" name="keyword"><?php echo $array[1]['content']; ?></textarea>
							</div>
						</div>
					</div>
					<div class="row text-center">
						<label>[NOTE] :- Use comma (,) to seperate Keywords.</label>
					</div>
					<div class="row">
						<div class="form-group col-sm-12 text-center">
							<input class="btn btn-primary" id="submit" type="submit" name="submit" value="Update" >
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading"><b>Analytics Code/Script:</b>
				<span class="pull-right">
					<input class="btn btn-primary" type="button" value="New Setting" onclick="window.location='<?php echo site_root."/ux-admin/index.php?q=SeoSettings&addNewSetting=1";?>'">
				</span>
				<div class="clearfix"></div>
			</div>
			<div class="panel-body">
				<div class="dataTable_wrapper">
					<table class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>Code</th>
								<th>Uploaded file</th>
								<th>Date-Time</th>
					      		<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if($res->num_rows > 0){
									$i=1;
									while($row = $res->fetch_assoc()){ ?>
					    				<tr>
						    				<th><?php echo $i;?></th>
					    					<?php if($row['type']== 'script'){?>
					    					<!-- <td><?php echo "".htmlspecialchars($row['content'])."";?></td> -->
					    					<td><?php if (empty($row['content'])){echo '---'; }else{ echo '[Script Code]'; } ?></td>
					    					<?php }else{?>
					    					<td><?php if(empty($row['content'])){ echo '---'; }else{ echo $row['content']; } ?></td>
					    					<?php }?>
					    					<td><?php if(empty($row['code_file'])){ echo '---'; }else{ echo $row['code_file']; } ?></td>
					    					<td><?php echo $row['date_time'];?></td>
					    					<td class="text-center">
					    						<a href="<?php echo site_root."ux-admin/SeoSettings&delete=".base64_encode($row['id']);?>" title="Delete"><span class="fa fa-trash"></span></a>
					    					</td>
										</tr>
								<?php $i++;
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>