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
		<td>Url</td>
		<td>:</td>
		<td><?php echo $model->url;?></td>
	</tr>
<tr>
		<td>Parent Menu</td>
		<td>:</td>
		<td><?php echo $model->menu->title;?></td>
	</tr>
<tr>
		<td>Controller</td>
		<td>:</td>
		<td><?php echo $model->controller;?></td>
	</tr>
<tr>
		<td>Params</td>
		<td>:</td>
		<td><?php echo $model->params;?></td>
	</tr>
<tr>
		<td>Order</td>
		<td>:</td>
		<td><?php echo $model->order;?></td>
	</tr>
<tr>
		<td>Icon</td>
		<td>:</td>
		<td><?php echo $model->icon;?></td>
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