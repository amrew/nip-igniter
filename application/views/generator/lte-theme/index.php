<section class="content-header">
    <h1><?php echo $pageTitle;?> List</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <!-- left column -->
        <div class="col-md-12">
        	<div class="box box-success">
                <div class="box-header hidden-print">
                	<div class="box-tools">
	                    <a class="btn btn-primary btn-sm pull-left" href="<?php echo site_url("{$pathController}/edit");?>" style="color:#fff">
							<span class="glyphicon glyphicon-plus"></span> New Record
						</a>
					    <input type="text" name="table_search" class="form-control input-sm pull-right input-global-search" style="width: 150px;" placeholder="Search all fields..."/>
                    </div>
                </div><!-- /.box-header -->
                <br>

                <div class="box-body no-padding">
                	<!--Show ajax message here-->
					<div id="ajax-message"></div>

                	<table class="table table-hover">
						
						<!--Heading-->
						<thead>
							<tr>
								<th width="80">#</th>

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
								
								<th style="width:100px" class="hidden-print">Action</th>
							</tr>
						</thead>

						<!--Search by fields-->
						<tbody class="hidden-print">
							<tr class="warning">
								<td>
									<div class="checkbox">
											<input type="checkbox" id="all-checkbox" class="icheck">
										<label>
											No.
										</label>
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
											<div class="checkbox" style="margin:0">
								              <input type="checkbox" class="each-checkbox icheck hidden-print" name="check" value="<?php echo $row->{content:primary};?>">
								              <label><?php echo ($offset+1)?></label>
								            </div>
										</td>
										
										{content:tbody}
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;">
												<?php if($row->{content:updatedField} != null && $row->{content:updatedField} != $row->{content:createdField}):?>
													<span class="label label-default">Updated</span></td>
												<?php else:?>
													<span class="label label-default">Created</span></td>
												<?php endif;?>
											<td style="width:85px;">
												<?php if($row->{content:updatedField} != null && $row->{content:updatedField} != $row->{content:createdField}):?>
													<?php echo date("d M Y", strtotime($row->{content:updatedField}));?>
												<?php else:?>
													<?php echo date("d M Y", strtotime($row->{content:createdField}));?>
												<?php endif;?>
											</td>
										<?php endif;?>
										<td class="hidden-print">
											<!-- Split button -->
											<div class="btn-group">
												<a href="<?php echo site_url("{$pathController}/view/{$row->{content:primary}}");?>" type="button" class="btn btn-info btn-xs show-modal"><i class="fa fa-eye"></i> View</a>
													<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
													</button>
												<ul class="dropdown-menu" role="menu" style="min-width:50px;">
													<li><a href="<?php echo site_url("{$pathController}/edit/{$row->{content:primary}}");?>"><i class="fa fa-edit"></i> Edit</a></li>
													<li><a href="#" class="btn-action" data-id="<?php echo $row->{content:primary};?>" data-url="<?php echo site_url("{$pathController}/delete");?>"><i class="fa fa-remove"></i> Delete</button></li>
												</ul>
											</div>
										</td>
									</tr>
								<?php $offset++;endforeach;?>

							<?php endif;?>
						</tbody>
					</table>
					
					<div class="box-footer clearfix hidden-print">
						<br>
						<div class="row-fluid">
							<div class="col-xs-6">
								
								<!--Button action for checkbox-->
								<div class="btn-group hidden-print">
							      <button type="button" class="btn btn-default btn-xs dropdown-toggle pull-left" data-toggle="dropdown" title="Action for checkbox above">Action <span class="caret"></span></button>
							      <ul class="dropdown-menu" role="menu">
							        <li><a href="<?php echo site_url($pathController.'/move-to-trash');?>" class="btnAboutTrash">Move to trash</a></li>
							      </ul>
							    </div>

							</div>
							<div class="col-xs-6">

								<!--Link to trash-->
								<?php if($this->Model->getSoftDeletes()):?>
									<a href="<?php echo site_url("{$pathController}/trash");?>" class="btn btn-default btn-xs pull-right hidden-print" title="Trash">
										<span class="glyphicon glyphicon-trash"></span> Trash
									</a>
								<?php endif;?>
								
								<!--Button to print this current page-->
								<button type="button" class="btn btn-default btn-xs hidden-print pull-right" id="btn-print" title="Print current page" style="margin-right:6px;">
							    	<span class="glyphicon glyphicon-print"></span> Print
							    </button>

							    <!--Button to generate pdf this current page-->
								<a href="#" id="btn-excel" title="Download Excel file" class="btn btn-default btn-xs hidden-print pull-right" style="margin-right:6px;">
							    	<span class="glyphicon glyphicon-file"></span> Excel
							    </a>

							    <!--Button to generate pdf this current page-->
								<a href="#" id="btn-pdf" title="Download PDF file" class="btn btn-default btn-xs hidden-print pull-right" style="margin-right:6px;">
							    	<span class="glyphicon glyphicon-file"></span> PDF
							    </a>

							</div>
						</div>
						<hr>
						<div class="row-fluid">
							<div class="col-xs-12">

								<!--Pagination Link-->
								<div id="page-container" class="pull-right" style="margin-left:10px;">
									<?php echo $pagination;?>
								</div>

								<!--Limit row for pagination-->
								<select id="select-limit" class="pull-right form-control" style="width:100px">
									<option value="<?php echo site_url($pathController.'/index/10');?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
									<?php $i=20;while($i<101):?>
										<option value="<?php echo site_url($pathController.'/index/'.$i);?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
									<?php $i+=10;endwhile;?>
									<?php $i=100;while($i<501):?>
										<option value="<?php echo site_url($pathController.'/index/'.$i);?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
									<?php $i+=100;endwhile;?>
								</select>
							</div>
						</div>

					</div>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
	currentUrl = '<?php echo current_url();?>';
</script>