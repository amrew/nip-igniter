<table class="table table-hover">
	<tr class="info">
		<td width="120">Id</td>
		<td width="20">:</td>
		<td><?php echo $model->id;?></td>
	</tr>
	
	<tr>
		<td>Post</td>
		<td>:</td>
		<td><?php echo $model->post->title;?></td>
	</tr>
<tr>
		<td>Name</td>
		<td>:</td>
		<td><?php echo $model->name;?></td>
	</tr>
<tr>
		<td>Email</td>
		<td>:</td>
		<td><?php echo $model->email;?></td>
	</tr>
<tr>
		<td>Website</td>
		<td>:</td>
		<td><?php echo $model->website;?></td>
	</tr>
<tr>
		<td>Message</td>
		<td>:</td>
		<td><?php echo $model->message;?></td>
	</tr>
<tr>
		<td>Type</td>
		<td>:</td>
		<td><?php echo $model->type;?></td>
	</tr>
<tr>
		<td>Status</td>
		<td>:</td>
		<td><?php echo $model->status->title;?></td>
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