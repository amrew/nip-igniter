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
											<?php echo $row->parent->title;?>
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