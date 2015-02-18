							<?php if(empty($rows)):?>
								<tr>
									<td colspan="{content:count}" style="text-align:center">No data found.</td>
								</tr>
							<?php else:?>

								<?php foreach($rows as $i => $row):?>
									<tr id="tr-<?php echo $row->{content:primary};?>">
										<td>
											<div class="checkbox" style="margin:0">
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
											<a class="btn btn-info btn-xs show-modal" href="<?php echo site_url("{$pathController}/view/{$row->{content:primary}}");?>">View</a>
											<a class="btn btn-info btn-xs" href="<?php echo site_url("{$pathController}/edit/{$row->{content:primary}}");?>">Edit</a>
											<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->{content:primary};?>" data-url="<?php echo site_url("{$pathController}/delete");?>">Delete</button>
										</td>
									</tr>
								<?php $offset++;endforeach;?>

							<?php endif;?>

							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
							</script>