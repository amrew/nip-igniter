<section class="content-header">
    <h1><i class="fa fa-trash"></i> <?php echo $pageTitle;?> List</h1>
</section>
<ol class="breadcrumb">
	<li><a href="<?php echo $callback;?>"><i class="fa fa-chevron-circle-left"></i> Back</a></li>
	<li><a href="<?php echo site_url($pathController).$queryString;?>"><?php echo $pageTitle;?></a></li>
	<li class="active"><span>Trash</span></li>
</ol>

<!-- Main content -->
<section class="content">
	<div class="row">
        <!-- left column -->
        <div class="col-md-12">
        	<div class="box box-warning">
                <div class="box-header hidden-print">
                	<div class="box-tools">
	                    <input type="text" name="table_search" class="form-control input-sm pull-right input-global-search" style="width: 150px;" placeholder="Search"/>
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
								
								<th style="width:120px" class="hidden-print">Action</th>
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
					<select name="role_id" class="form-control input-search">
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
									<td colspan="8" style="text-align:center">No data found.</td>
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
										
										<td><?php echo $row->username;?></td>
						<td><?php echo $row->email;?></td>
						<td><?php echo $row->role->title;?></td><td><?php echo $row->status->title;?></td>
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;"><span class="label label-default">Deleted</span></td>
											<td style="width:90px;"><small><?php echo date("d M Y", strtotime($row->deleted));?></small></td>
										<?php endif;?>
										<td class="hidden-print">
											<button class="btn btn-success btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/restore/trash").$queryString;?>">Restore</button>
											<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/force-delete").$queryString;?>">Delete</button>
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
							        <li><a href="<?php echo site_url($pathController."/restoreTrash").$queryString;?>" class="btnAboutTrash">Restore</a></li>
							        <li><a href="<?php echo site_url($pathController."/deletePermanently").$queryString;?>" class="btnAboutTrash">Delete permanently</a></li>
							      </ul>
							    </div>

							</div>
							<div class="col-xs-6">

								<!--Button to print this current page-->
								<button type="button" class="btn btn-default btn-xs hidden-print pull-right" id="btn-print" title="Print current page" style="margin-right:6px;">
							    	<span class="glyphicon glyphicon-print"></span> Print
							    </button>

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
									<option value="<?php echo site_url($pathController.'/trash/10').$queryString;?>" <?php echo 10==$limit?"selected":"";?>>Limit</option>
									<?php $i=20;while($i<101):?>
										<option value="<?php echo site_url($pathController.'/trash/'.$i).$queryString;?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
									<?php $i+=10;endwhile;?>
									<?php $i=100;while($i<501):?>
										<option value="<?php echo site_url($pathController.'/trash/'.$i).$queryString;?>" <?php echo $i==$limit?"selected":"";?>><?php echo $i;?></option>
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