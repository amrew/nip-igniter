<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
	<li>
		<a href="<?php echo site_url("admin/dashboard");?>">Home</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="<?php echo $callback;?>"><?php echo $pageTitle;?></a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		Trash
	</li>
</ul>

<div id="ajax-message"></div>
<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		
		<!-- Begin: life time stats -->
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-list-alt font-green-sharp"></i>
					<span class="caption-subject font-green-sharp bold uppercase"><?php echo $pageTitle;?> Listing</span>
					<span class="caption-helper">manage trash records...</span>
				</div>
				<div class="actions">
					<div class="btn-group">
						<a class="btn btn-default btn-circle" href="#" data-toggle="dropdown">
						<i class="fa fa-share"></i>
						<span class="hidden-480">
						Tools </span>
						<i class="fa fa-angle-down"></i>
						</a>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="#" id="btn-print" title="Print current page">
								Print Page </a>
							</li>
							<!-- <li>
								<a href="#" id="btn-excel" title="Download Excel file">
								Export to Excel </a>
							</li>
							<li>
								<a href="#" id="btn-pdf" title="Download PDF file">
								Export to PDF </a>
							</li> -->
						</ul>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="clearfix">
					<input type="text" name="table_search" class="form-control pull-right input-global-search" style="width: 150px;" placeholder="Search all fields..."/>
				</div>
				<br>
				<div class="table-container">
					
					<!-- Table -->
	            	<table class="table table-hover">
						
						<!--Heading-->
						<thead>
							<tr>
								<th width="80">#</th>

								<!--Sorting-->
								<th>
					<a href="#" class="sorting" data-field="name" data-direction="asc">
						Name <span class="glyphicon glyphicon-sort hidden-print"></span>
					</a>
				</th>
				<th>
					<a href="#" class="sorting" data-field="status_id" data-direction="asc">
						Status <span class="glyphicon glyphicon-sort hidden-print"></span>
					</a>
				</th>
				
								<!--Timestamps-->
								<?php if($this->Model->getTimestamps()):?>
								<th colspan="2" class="text-center">
									<a href="#" class="sorting" data-field="updated" data-direction="asc">
										Activity <span class="glyphicon glyphicon-sort hidden-print"></span>
									</a>
								</th>
								<?php endif;?>
								
								<th style="width:140px" class="hidden-print">Action</th>
							</tr>
						</thead>

						<!--Search by fields-->
						<tbody class="hidden-print">
							<tr class="warning">
								<td>
									<div class="checkbox1">
						              <input type="checkbox" id="all-checkbox" class="icheck">
						            </div>
						        </td>

								<td>
					<input type="text" name="name" class="form-control input-search " placeholder="Search by Name..." value="<?php echo isset($_GET["keywords"]["name"])?$_GET["keywords"]["name"]:"";?>">
				</td>
				<td>
					<select name="status_id" class="form-control input-search">
						<option value="">All</option>
						<?php foreach($allStatus as $row):?>
							<option value="<?php echo $row->id;?>"
								<?php if(isset($_GET['keywords']['status_id'])):?>
									<?php echo $_GET['keywords']['status_id']==$row->id?"selected":"";?>
								<?php endif;?>
							><?php echo $row->title;?></option>
						<?php endforeach;?>
					</select>
				</td>
				
								<?php if($this->Model->getTimestamps()):?>
									<td colspan="2">
										<input class="form-control input-search datepicker pull-right" name="updated" placeholder="Search by updated date...">
									</td>
								<?php endif;?>
								<td class="hidden-print"></td>
							</tr>
						</tbody>

						<!--Container-->
						<tbody id="table-body">
							<?php if(empty($rows)):?>
								<tr>
									<td colspan="6" style="text-align:center">No data found.</td>
								</tr>
							<?php else:?>

								<?php foreach($rows as $i => $row):?>
									<tr id="tr-<?php echo $row->id;?>">
										<td>
											<div class="checkbox" style="margin:0">
								              <input type="checkbox" class="each-checkbox icheck" name="check" value="<?php echo $row->id;?>">
								              <label><?php echo ($offset+1)?></label>
								            </div>
										</td>
										
										<td><?php echo $row->name;?></td>
										<td><?php echo $row->status->title;?></td>
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;"><span class="badge badge-default badge-roundless">Deleted</span></td>
											<td style="width:85px;"><small><?php echo date("d M Y", strtotime($row->deleted));?></small></td>
										<?php endif;?>
										<td class="hidden-print">
											<button class="btn btn-success btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/restore/trash?type={$type}");?>">Restore</button>
											<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/force-delete?type={$type}");?>">Delete</button>
										</td>
									</tr>
								<?php $offset++;endforeach;?>

							<?php endif;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- End: life time stats -->

		<div class="clearfix">
			<!--Button action for checkbox-->
			<div class="btn-group hidden-print">
		      <button type="button" class="btn btn-default btn-xs dropdown-toggle pull-left" data-toggle="dropdown" title="Action for checkbox above">Action <span class="caret"></span></button>
		      <ul class="dropdown-menu" role="menu">
		        <li><a href="<?php echo site_url($pathController."/restoreTrash?type={$type}");?>" class="btnAboutTrash">Restore</a></li>
		        <li><a href="<?php echo site_url($pathController."/deletePermanently?type={$type}");?>" class="btnAboutTrash">Delete permanently</a></li>
		      </ul>
		    </div>

		    <!--Pagination Link-->
			<div id="page-container" class="pull-right" style="margin-left:10px;">
				<?php echo $pagination;?>
			</div>

			<!--Limit row for pagination-->
			<select id="select-limit" class="pull-right form-control" style="width:100px">
				<option value="<?php echo site_url($pathController."/trash/10?type={$type}");?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
				<?php $i=20;while($i<101):?>
					<option value="<?php echo site_url($pathController."/trash/".$i."?type={$type}");?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
				<?php $i+=10;endwhile;?>
				<?php $i=100;while($i<501):?>
					<option value="<?php echo site_url($pathController."/trash/".$i."?type={$type}");?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
				<?php $i+=100;endwhile;?>
			</select>
		</div>

	</div>
</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript">
	currentUrl = '<?php echo current_url();?>';
	tempKeywords = '?type=<?php echo $type;?>';
</script>