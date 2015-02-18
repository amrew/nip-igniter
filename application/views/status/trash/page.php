							<?php if(empty($rows)):?>
								<tr>
									<td colspan="5" style="text-align:center">No data found.</td>
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
										
										<td><?php echo $row->title;?></td>
						
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

							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
							</script>