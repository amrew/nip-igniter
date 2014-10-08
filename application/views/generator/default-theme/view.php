<table class="table table-hover">
	<tr class="info">
		<td width="120">{content:primaryLabel}</td>
		<td width="20">:</td>
		<td><?php echo $model->{content:primary};?></td>
	</tr>
	
	{content:tbody_view}
	<?php if($this->Model->getTimestamps()):?>
	<tr>
		<td>Created</td>
		<td>:</td>
		<td><?php echo date("d M Y H:i:s",strtotime($model->{content:createdField}));?></td>
	</tr>
	<tr>
		<td>Updated</td>
		<td>:</td>
		<td><?php echo $model->{content:updatedField}?date("d M Y H:i:s",strtotime($model->{content:updatedField})):"-";?></td>
	</tr>
	<?php endif;?>
</table>