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
											<td style="width:60px;"><span class="label label-default">Deleted</span></td>
											<td style="width:85px;"><small><?php echo date("d M Y", strtotime($row->deleted));?></small></td>
										<?php endif;?>
										<td class="hidden-print">
											<button class="btn btn-success btn-xs btn-action" data-id="<?php echo $row->{content:primary};?>" data-url="<?php echo site_url("{$pathController}/restore/trash");?>">Restore</button>
											<button class="btn btn-danger btn-xs btn-action" data-id="<?php echo $row->{content:primary};?>" data-url="<?php echo site_url("{$pathController}/force-delete");?>">Delete</button>
										</td>
									</tr>
								<?php $offset++;endforeach;?>

							<?php endif;?>
							
							<script type="text/javascript">
								currentUrl = '<?php echo current_url();?>';
							</script>