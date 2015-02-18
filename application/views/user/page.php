							<?php if(empty($rows)):?>
								<tr>
									<td colspan="8" style="text-align:center">No data found.</td>
								</tr>
							<?php else:?>

								<?php foreach($rows as $i => $row):?>
									<tr id="tr-<?php echo $row->id;?>">
										<td>
											<div class="checkbox" style="margin:0">
								              	<input type="checkbox" class="each-checkbox icheck hidden-print" name="check" value="<?php echo $row->id;?>">
								            	<label>
								            		<?php echo ($offset+1)?>
								            	</label>
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
											<!-- Split button -->
											<div class="btn-group">
												<a href="<?php echo site_url("{$pathController}/view/{$row->id}");?>" type="button" class="btn btn-info btn-xs show-modal">View</a>
													<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
													</button>
												<ul class="dropdown-menu" role="menu" style="min-width:50px;">
													<li><a href="<?php echo site_url("{$pathController}/edit/{$row->id}");?>">Edit</a></li>
													<li><a href="#" class="btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/delete");?>">Delete</button></li>
												</ul>
											</div>
										</td>
									</tr>
								<?php $offset++;endforeach;?>

							<?php endif;?>

							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
							</script>