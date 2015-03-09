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
													<span class="badge badge-default badge-roundless">Updated</span>
												<?php else:?>
													<span class="badge badge-default badge-roundless">Created</span>
												<?php endif;?>
											</td>
											<td style="width:90px;">
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
												<a href="<?php echo site_url("{$pathController}/view/{$row->{content:primary}}");?>" type="button" class="btn btn-info btn-xs show-modal" style="margin-right:0;"><i class="fa fa-eye"></i> View</a>
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

							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
							</script>