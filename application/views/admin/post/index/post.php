<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb hidden-print">
	<li>
		<a href="<?php echo site_url("admin/dashboard");?>">Home</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="#">Master Data</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		List
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
					<span class="caption-helper">manage records...</span>
				</div>
				<div class="actions hidden-print">
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
							<li>
								<a href="#" id="btn-excel" title="Download Excel file">
								Export to Excel </a>
							</li>
							<li>
								<a href="#" id="btn-pdf" title="Download PDF file">
								Export to PDF </a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="portlet-body">
				<div class="clearfix hidden-print">
					<a href="<?php echo site_url("{$pathController}/edit?type={$type}");?>" class="btn btn-success btn-circle pull-left">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">
						New Record </span>
					</a>
					<input type="text" name="table_search" class="form-control pull-right input-global-search" style="width: 150px;" placeholder="Search all fields..."/>
				</div>
				<br>
				<div class="table-container">
					
					<!-- Table -->
	            	<table class="table table-hover">
						
						<!--Heading-->
						<thead>
							<tr>
								<th width="40">#</th>

								<!--Sorting-->
								<th>
									<a href="#" class="sorting" data-field="title" data-direction="asc">
										Title <span class="glyphicon glyphicon-sort hidden-print"></span>
									</a>
								</th>
								<th>
									<a href="#" class="sorting" data-field="category_id" data-direction="asc">
										Category <span class="glyphicon glyphicon-sort hidden-print"></span>
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
								
								<th style="width:110px" class="hidden-print">Action</th>
							</tr>
						</thead>

						<!--Search by fields-->
						<tbody class="hidden-print">
							<tr class="warning">
								<td>
									<div class="checkbox">
											<input type="checkbox" id="all-checkbox" class="icheck">
									</div>
						        </td>

								<td>
									<input type="text" name="title" class="form-control input-search " placeholder="Search by Title..." value="<?php echo isset($_GET["keywords"]["title"])?$_GET["keywords"]["title"]:"";?>">
								</td>
								<td width="120">
									<select name="category_id" class="form-control input-search">
										<option value="">All</option>
										<?php foreach($allTerm as $row):?>
											<option value="<?php echo $row->id;?>"
												<?php if(isset($_GET['keywords']['category_id'])):?>
													<?php echo $_GET['keywords']['category_id']==$row->id?"selected":"";?>
												<?php endif;?>
											><?php echo $row->title;?></option>
										<?php endforeach;?>
									</select>
								</td>
								<td width="100">
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
										<input class="form-control input-search date-picker pull-right" name="updated" placeholder="Search by updated date...">
									</td>
								<?php endif;?>
								<td class="hidden-print"></td>
							</tr>
						</tbody>

						<!--Container-->
						<tbody id="table-body">
							<?php if(empty($rows)):?>
								<tr>
									<td colspan="7" style="text-align:center">No data found.</td>
								</tr>
							<?php else:?>

								<?php foreach($rows as $i => $row):?>
									<tr id="tr-<?php echo $row->id;?>">
										<td>
											<div class="checkbox" style="margin:0">
								              <input type="checkbox" class="each-checkbox icheck hidden-print" name="check" value="<?php echo $row->id;?>">
								            </div>
										</td>
										
										<td>
											<h5><strong><?php echo $row->title;?></strong></h5>
											<ul class="list-inline">
												<li><i class="fa fa-user"></i> <?php echo $row->user->username;?></li>
												<li><i class="fa fa-eye"></i> <?php echo $row->view_count;?></li>
											</ul>
											<p><small><?php echo $row->summary;?></small></p>
										</td>
										<td style="vertical-align:middle">
											<?php echo $row->term->title;?>
										</td>
										<td style="vertical-align:middle;text-align:center">
											<button class="btn btn-<?php echo $row->status_id==1?'success':'warning';?> btn-xs tooltips btn-change" 
												data-container="body" 
												data-placement="top" 
												data-original-title="Change Status!" 
												data-status-id="<?php echo $row->status_id;?>"
												data-id="<?php echo $row->id;?>">
												<?php echo $row->status->title;?>
											</button>
										</td>
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;vertical-align:middle">
												<?php if($row->updated != null && $row->updated != $row->created):?>
													<span class="badge badge-default badge-roundless">Updated</span>
												<?php else:?>
													<span class="badge badge-default badge-roundless">Created</span>
												<?php endif;?>
											</td>
											<td style="width:100px;vertical-align:middle">
												<?php if($row->updated != null && $row->updated != $row->created):?>
													<?php echo date("d M Y", strtotime($row->updated));?>
												<?php else:?>
													<?php echo date("d M Y", strtotime($row->created));?>
												<?php endif;?>
											</td>
										<?php endif;?>
										<td class="hidden-print" style="vertical-align:middle">
											<!-- Split button -->
											<div class="btn-group">
												<a href="<?php echo site_url("{$pathController}/view/{$row->id}?type={$type}");?>" type="button" class="btn btn-info btn-xs show-modal" data-type="big" style="margin-right:0;"><i class="fa fa-eye"></i> View</a>
													<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
													</button>
												<ul class="dropdown-menu" role="menu" style="min-width:50px;">
													<li><a href="<?php echo site_url("{$pathController}/edit/{$row->id}?type={$type}");?>"><i class="fa fa-edit"></i> Edit</a></li>
													<li><a href="#" class="btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/delete?type={$type}");?>"><i class="fa fa-remove"></i> Delete</button></li>
												</ul>
											</div>
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
			<div class="btn-group hidden-print pull-left">
		      <button type="button" class="btn btn-default btn-sm dropdown-toggle pull-left" data-toggle="dropdown" title="Action for checkbox above">Action <span class="caret"></span></button>
		      <ul class="dropdown-menu" role="menu">
		        <li><a href="<?php echo site_url($pathController."/move-to-trash?type={$type}");?>" class="btnAboutTrash">Move to trash</a></li>
		      </ul>
		    </div>

		    <!--Link to trash-->
			<?php if($this->Model->getSoftDeletes()):?>
				<a href="<?php echo site_url("{$pathController}/trash?type={$type}");?>" class="btn btn-default pull-right hidden-print" title="Trash" style="margin-left:8px;">
					<span class="glyphicon glyphicon-trash"></span>
				</a>
			<?php endif;?>

			<!--Pagination Link-->
			<div id="page-container" class="pull-right hidden-print" style="margin-left:10px;">
				<?php echo $pagination;?>
			</div>

			<!--Limit row for pagination-->
			<select id="select-limit" class="pull-right form-control hidden-print" style="width:100px">
				<option value="<?php echo site_url($pathController."/index/10?type={$type}");?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
				<?php $i=20;while($i<101):?>
					<option value="<?php echo site_url($pathController."/index/".$i."?type={$type}");?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
				<?php $i+=10;endwhile;?>
				<?php $i=100;while($i<501):?>
					<option value="<?php echo site_url($pathController."/index/".$i."?type={$type}");?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
				<?php $i+=100;endwhile;?>
			</select>
		</div>

	</div>
</div>
<!-- END PAGE CONTENT-->

<script type="text/javascript">
	currentUrl = '<?php echo current_url();?>';
	tempKeywords = '?type=<?php echo $type;?>';
	$(function(){
		changeStatus();
	});
	function changeStatus(){
		$(".btn-change").unbind("click").on("click", function(e){
			e.preventDefault();
			var editUrl = '<?php echo site_url($pathController."/edit");?>';
			var button = $(this);
			
			var id = button.attr("data-id");
			var status = button.attr("data-status-id");
			var changeTo = status==1?2:1;
			
			$.ajax({
				url: editUrl+'/'+id+'<?php echo "?type={$type}";?>',
				beforeSend: function(){
					button.html('loading');
				},
				data: 'change_status=1&status_id='+changeTo,
				dataType:'json',
				type: 'post',
				success: function(rs){
					if(rs.status==1){
						button.attr("data-status-id", rs.changeTo);
						button.html(rs.title);
						button.removeClass().addClass('btn btn-xs btn-'+rs.param);
					}else{
						button.html('error');
						button.removeClass().addClass('btn btn-xs btn-danger');
					}
				}
			});
		});
	}
</script>