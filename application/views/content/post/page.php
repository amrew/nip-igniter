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
										
										<td><?php echo $row->title;?></td>
						<td><?php echo $row->term->title;?></td><td><?php echo $row->status->title;?></td>
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;">
												<?php if($row->updated != null && $row->updated != $row->created):?>
													<span class="label label-default">Updated</span>
												<?php else:?>
													<span class="label label-default">Created</span>
												<?php endif;?>
											</td>
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

							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
							</script>