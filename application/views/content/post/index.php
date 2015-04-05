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
	                    <a class="btn btn-primary btn-sm pull-left" href="<?php echo site_url("{$pathController}/edit").$queryString;?>" style="color:#fff">
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

								<td>
					<input type="text" name="title" class="form-control input-search " placeholder="Search by Title..." value="<?php echo isset($_GET["keywords"]["title"])?$_GET["keywords"]["title"]:"";?>">
				</td>
				<td width="150">
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
									<td colspan="7" style="text-align:center">No data found.</td>
								</tr>
							<?php else:?>

								<?php foreach($rows as $i => $row):?>
									<tr id="tr-<?php echo $row->id;?>">
										<td>
											<div class="checkbox" style="margin:0">
								              <input type="checkbox" class="each-checkbox icheck hidden-print" name="check" value="<?php echo $row->id;?>">
								              <label><?php echo ($offset+1)?></label>
								            </div>
										</td>
										
										<td>
											<?php if(!empty($row->image)):?>
												<img src="<?php echo $row->pathImage;?>" width="100" class="pull-left img-thumbnail" style="margin-right:8px">
											<?php endif;?>
											<strong><?php echo $row->title;?></strong><br>
											<small><?php echo $row->summary;?></small>
										</td>
										<td class="text-center"><?php echo $row->term->title;?></td>
										<td class="text-center"><?php echo $row->status->title;?></td>
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;">
												<?php if($row->updated != null && $row->updated != $row->created):?>
													<span class="label label-default">Updated</span></td>
												<?php else:?>
													<span class="label label-default">Created</span></td>
												<?php endif;?>
											<td style="width:90px;">
												<?php if($row->updated != null && $row->updated != $row->created):?>
													<?php echo date("d M Y", strtotime($row->updated));?>
												<?php else:?>
													<?php echo date("d M Y", strtotime($row->created));?>
												<?php endif;?>
											</td>
										<?php endif;?>
										<td class="hidden-print">
											<!-- Split button -->
											<div class="btn-group">
												<a href="<?php echo site_url("{$pathController}/view/{$row->id}").$queryString;?>" type="button" class="btn btn-info btn-xs show-modal"><i class="fa fa-eye"></i> View</a>
													<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
													</button>
												<ul class="dropdown-menu" role="menu" style="min-width:50px;">
													<li><a href="<?php echo site_url("{$pathController}/edit/{$row->id}").$queryString;?>"><i class="fa fa-edit"></i> Edit</a></li>
													<li><a href="#" class="btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/delete").$queryString;?>"><i class="fa fa-remove"></i> Delete</button></li>
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
							        <li><a href="<?php echo site_url($pathController.'/move-to-trash').$queryString;?>" class="btnAboutTrash">Move to trash</a></li>
							      </ul>
							    </div>

							</div>
							<div class="col-xs-6">

								<!--Link to trash-->
								<?php if($this->Model->getSoftDeletes()):?>
									<a href="<?php echo site_url("{$pathController}/trash").$queryString;?>" class="btn btn-default btn-xs pull-right hidden-print" title="Trash">
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
									<option value="<?php echo site_url($pathController.'/index/10').$queryString;?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
									<?php $i=20;while($i<101):?>
										<option value="<?php echo site_url($pathController.'/index/'.$i).$queryString;?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
									<?php $i+=10;endwhile;?>
									<?php $i=100;while($i<501):?>
										<option value="<?php echo site_url($pathController.'/index/'.$i).$queryString;?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
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
	currentUrl   = '<?php echo current_url();?>';
	tempKeywords = '<?php echo $queryString;?>';
</script>