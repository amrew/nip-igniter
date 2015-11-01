<table class="table table-hover">
	<tr class="info">
		<td width="120">Id</td>
		<td width="20">:</td>
		<td><?php echo $model->id;?></td>
	</tr>
	
	<tr>
		<td>Username</td>
		<td>:</td>
		<td><?php echo $model->username;?></td>
	</tr>
<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?php echo $model->nama;?></td>
	</tr>
<tr>
		<td>Email</td>
		<td>:</td>
		<td><?php echo $model->email;?></td>
	</tr>
<tr>
		<td>Role</td>
		<td>:</td>
		<td><?php echo $model->role->title;?></td>
	</tr>
<tr>
		<td>Status</td>
		<td>:</td>
		<td><?php echo $model->status->title;?></td>
	</tr>
<tr>
		<td>Picture</td>
		<td>:</td>
		<td><img width="170" src="<?php echo base_url().$model->picture;?>"></td>
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