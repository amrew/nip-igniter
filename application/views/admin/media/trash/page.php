							<?php if(empty($rows)):?>
								<tr>
									<td colspan="7" style="text-align:center">No data found.</td>
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
						<td><?php echo $row->term->title;?></td><td><?php echo $row->status->title;?></td>
										<?php if($this->Model->getTimestamps()):?>
											<td style="width:60px;"><span class="label label-default">Deleted</span></td>
											<td style="width:85px;"><small><?php echo date("d M Y", strtotime($row->deleted));?></small></td>
										<?php endif;?>
										<td class="hidden-print">
											<button class="btn btn-success btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/restore/trash?type={$type}");?>">Restore</button>
											<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->id;?>" data-url="<?php echo site_url("{$pathController}/force-delete?type={$type}");?>">Delete</button>
										</td>
									</tr>
								<?php $offset++;endforeach;?>

							<?php endif;?>
							
							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
								tempKeywords = '?type=<?php echo $type;?>';
							</script>