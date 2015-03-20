<table class="table table-hover">
	<tr class="info">
		<td width="120">Id</td>
		<td width="20">:</td>
		<td><?php echo $model->id;?></td>
	</tr>
	
	<tr>
		<td>Title</td>
		<td>:</td>
		<td><?php echo $model->title;?></td>
	</tr>
<tr>
		<td>Description</td>
		<td>:</td>
		<td><?php echo $model->description;?></td>
	</tr>
<tr>
		<td>Slug</td>
		<td>:</td>
		<td><?php echo $model->slug;?></td>
	</tr>
<tr>
		<td>Type</td>
		<td>:</td>
		<td><?php echo $model->type;?></td>
	</tr>

	<?php if($this->Model->getTimestamps()):?>
	<tr>
		<td>Created</td>
		<td>:</td>
		<td><?php echo date("d M Y H:i:s",strtotime($model->created));?></td>
	</tr>
	<tr>
		<td>Updated</td>
		<td>:</td>
		<td><?php echo $model->updated?date("d M Y H:i:s",strtotime($model->updated)):"-";?></td>
	</tr>
	<?php endif;?>
</table>