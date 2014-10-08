<div class="row hidden-print">
	<div class="col-sm-6 col-md-8 margin-bottom">
	
		<!--Button to add new record-->
		<a class="btn btn-primary btn-sm" href="<?php echo site_url("{$this->controller}/edit");?>">
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
				{content:thead}
				<!--Timestamps-->
				<?php if($this->Model->getTimestamps()):?>
				<th colspan="2" class="text-center">
					<a href="#" class="sorting" data-field="{content:updatedField}" data-direction="asc">
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

				{content:textbox_search_thead}
				<?php if($this->Model->getTimestamps()):?>
					<td colspan="2">
						<input class="form-control input-search datepicker pull-right" name="{content:updatedField}" placeholder="Search by {content:updatedField} date...">
					</td>
				<?php endif;?>
				<td class="hidden-print"></td>
			</tr>
		</tbody>

		<!--Container-->
		<tbody id="table-body">
			<?php if(empty($rows)):?>
				<tr>
					<td colspan="{content:count}" style="text-align:center">No data found.</td>
				</tr>
			<?php else:?>

				<?php foreach($rows as $i => $row):?>
					<tr id="tr-<?php echo $row->{content:primary};?>">
						<td>
							<div class="checkbox">
				              <input type="checkbox" class="each-checkbox icheck" name="check" value="<?php echo $row->{content:primary};?>">
				              <label><?php echo ($offset+1)?></label>
				            </div>
						</td>
						
						{content:tbody}
						<?php if($this->Model->getTimestamps()):?>
							<td>
								<?php if($row->{content:updatedField} != null && $row->{content:updatedField} != $row->{content:createdField}):?>
									<span class="label label-default">Updated</span></td>
								<?php else:?>
									<span class="label label-default">Created</span></td>
								<?php endif;?>
							<td>
								<?php if($row->{content:updatedField} != null && $row->{content:updatedField} != $row->{content:createdField}):?>
									<?php echo date("d M Y", strtotime($row->{content:updatedField}));?>
								<?php else:?>
									<?php echo date("d M Y", strtotime($row->{content:createdField}));?>
								<?php endif;?>
							</td>
						<?php endif;?>
						<td class="hidden-print">
							<a class="btn btn-info btn-xs show-modal" href="<?php echo site_url("{$this->controller}/view/{$row->{content:primary}}");?>">View</a>
							<a class="btn btn-info btn-xs" href="<?php echo site_url("{$this->controller}/edit/{$row->{content:primary}}");?>">Edit</a>
							<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->{content:primary};?>" data-url="<?php echo site_url("{$this->controller}/delete");?>">Delete</button>
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
	        <li><a href="<?php echo site_url($controller.'/move-to-trash');?>" class="btnAboutTrash">Move to trash</a></li>
	      </ul>
	    </div>

	</div>
	<div class="col-xs-6">

		<!--Link to trash-->
		<?php if($this->Model->getSoftDeletes()):?>
			<a href="<?php echo site_url("{$this->controller}/trash");?>" class="btn btn-xs pull-right hidden-print" title="Trash">
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		<?php endif;?>
		
		<!--Button to print this current page-->
		<button type="button" class="btn btn-xs hidden-print pull-right" id="btn-print" title="Print current page" style="margin-right:6px;">
	    	<span class="glyphicon glyphicon-print"></span>
	    </button>

	</div>
</div>

<br>

<div class="row">
	<div class="col-xs-12">

		<!--Limit row for pagination-->
		<select id="select-limit">
			<option value="<?php echo site_url($controller.'/index/10');?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
			<?php $i=20;while($i<101):?>
				<option value="<?php echo site_url($controller.'/index/'.$i);?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
			<?php $i+=10;endwhile;?>
		</select>

		<!--Pagination Link-->
		<div id="page-container" class="hidden-print pull-right" style="margin-right:10px;">
			<?php echo $pagination;?>
		</div>
	</div>
</div>

<script type="text/javascript">
	currentUrl = '<?php echo current_url();?>';
</script>