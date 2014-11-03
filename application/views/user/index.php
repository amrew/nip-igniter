<div class="row hidden-print">
	<div class="col-sm-6 col-md-8 margin-bottom">
	
		<!--Button to add new record-->
		<a class="btn btn-primary btn-sm" href="<?php echo site_url("{$pathController}/edit");?>">
			<span class="glyphicon glyphicon-plus"></span> New Record
		</a>
	
	</div>
	<div class="col-sm-6 col-md-4 margin-bottom">
	
		<!--Global search textbox-->
		<input type="text" class="form-control input-global-search" placeholder="Seach all fields...">
	
	</div>
	<div class="col-xs-12">

		<!--Show ajax message here-->
		<div id="ajax-message"></div>
	
	</div>
</div>

<div class="table-responsive">
	<table class="table table-hover">
		
		<!--Heading-->
		<thead>
			<tr>
				<th>#</th>

				<!--Sorting-->
				<th>
					<a href="#" class="sorting" data-field="username" data-direction="asc">
						Username <span class="glyphicon glyphicon-sort hidden-print"></span>
					</a>
				</th>
				<th>
					<a href="#" class="sorting" data-field="email" data-direction="asc">
						Email <span class="glyphicon glyphicon-sort hidden-print"></span>
					</a>
				</th>
				<th>
					<a href="#" class="sorting" data-field="role_id" data-direction="asc">
						Role <span class="glyphicon glyphicon-sort hidden-print"></span>
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
				
				<th style="width:150px" class="hidden-print">Action</th>
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
					<input type="text" name="username" class="form-control input-search " placeholder="Search by Username..." value="<?php echo isset($_GET["keywords"]["username"])?$_GET["keywords"]["username"]:"";?>">
				</td>
				<td>
					<input type="text" name="email" class="form-control input-search " placeholder="Search by Email..." value="<?php echo isset($_GET["keywords"]["email"])?$_GET["keywords"]["email"]:"";?>">
				</td>
				<td>
					<select name="role_id" class="input-selecter input-search">
						<option value="">All</option>
						<?php foreach($allRole as $row):?>
							<option value="<?php echo $row->id;?>"
								<?php if(isset($_GET['keywords']['role_id'])):?>
									<?php echo $_GET['keywords']['role_id']==$row->id?"selected":"";?>
								<?php endif;?>
							><?php echo $row->title;?></option>
						<?php endforeach;?>
					</select>
				</td>
				<td>
					<select name="status_id" class="input-selecter input-search">
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
					<td colspan="8" style="text-align:center">No data found.</td>
				</tr>
			<?php else:?>

				<?php foreach($rows as $i => $row):?>
					<tr id="tr-<?php echo $row->id;?>">
						<td>
							<div class="checkbox">
				              <input type="checkbox" class="each-checkbox icheck hidden-print" name="check" value="<?php echo $row->id;?>">
				              <label><?php echo ($offset+1)?></label>
				            </div>
						</td>
						
						<td><?php echo $row->username;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->role->title;?></td><td><?php echo $row->status->title;?></td>
						<?php if($this->Model->getTimestamps()):?>
							<td>
								<?php if($row->updated != null && $row->updated != $row->created):?>
									<span class="label label-default">Updated</span></td>
								<?php else:?>
									<span class="label label-default">Created</span></td>
								<?php endif;?>
							<td>
								<?php if($row->updated != null && $row->updated != $row->created):?>
									<?php echo date("d M Y", strtotime($row->updated));?>
								<?php else:?>
									<?php echo date("d M Y", strtotime($row->created));?>
								<?php endif;?>
							</td>
						<?php endif;?>
						<td class="hidden-print">
							<a class="btn btn-info btn-xs show-modal" href="<?php echo site_url("{$pathController}/view/{$row->id}");?>">View</a>
							<a class="btn btn-info btn-xs" href="<?php echo site_url("{$pathController}/edit/{$row->id}");?>">Edit</a>
							<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/delete");?>">Delete</button>
						</td>
					</tr>
				<?php $offset++;endforeach;?>

			<?php endif;?>
		</tbody>
	</table>
</div>

<div class="row">
	<div class="col-xs-6">
		
		<!--Button action for checkbox-->
		<div class="btn-group hidden-print">
	      <button type="button" class="btn btn-xs dropdown-toggle pull-left" data-toggle="dropdown" title="Action for checkbox above">Action <span class="caret"></span></button>
	      <ul class="dropdown-menu" role="menu">
	        <li><a href="<?php echo site_url($pathController.'/move-to-trash');?>" class="btnAboutTrash">Move to trash</a></li>
	      </ul>
	    </div>

	</div>
	<div class="col-xs-6">

		<!--Link to trash-->
		<?php if($this->Model->getSoftDeletes()):?>
			<a href="<?php echo site_url("{$pathController}/trash");?>" class="btn btn-xs pull-right hidden-print" title="Trash">
				<span class="glyphicon glyphicon-trash"></span> Trash
			</a>
		<?php endif;?>
		
		<!--Button to print this current page-->
		<button type="button" class="btn btn-xs hidden-print pull-right" id="btn-print" title="Print current page" style="margin-right:6px;">
	    	<span class="glyphicon glyphicon-print"></span> Print
	    </button>

	    <!--Button to generate pdf this current page-->
		<a href="#" id="btn-excel" title="Download Excel file" class="btn btn-xs hidden-print pull-right" style="margin-right:6px;">
	    	<span class="glyphicon glyphicon-file"></span> Excel
	    </a>

	    <!--Button to generate pdf this current page-->
		<a href="#" id="btn-pdf" title="Download PDF file" class="btn btn-xs hidden-print pull-right" style="margin-right:6px;">
	    	<span class="glyphicon glyphicon-file"></span> PDF
	    </a>

	</div>
</div>

<br>

<div class="row hidden-print">
	<div class="col-xs-12">

		<!--Limit row for pagination-->
		<select id="select-limit">
			<option value="<?php echo site_url($pathController.'/index/10');?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
			<?php $i=20;while($i<101):?>
				<option value="<?php echo site_url($pathController.'/index/'.$i);?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
			<?php $i+=10;endwhile;?>
			<?php $i=100;while($i<501):?>
				<option value="<?php echo site_url($pathController.'/index/'.$i);?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
			<?php $i+=100;endwhile;?>
		</select>

		<!--Pagination Link-->
		<div id="page-container" class="pull-right" style="margin-right:10px;">
			<?php echo $pagination;?>
		</div>
	</div>
</div>

<script type="text/javascript">
	currentUrl = '<?php echo current_url();?>';
</script>