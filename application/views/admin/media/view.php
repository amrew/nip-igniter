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
		<td>Url</td>
		<td>:</td>
		<td>
			<?php if(!empty($model->url) && @is_array(getimagesize($model->url))):?>
  				<a href="<?php echo $model->path;?>" target="_blank">
	  				<img src="<?php echo $model->path;?>" width="170">
	  			</a>
  			<?php elseif(!empty($model->url)):?>
            	<a href="<?php echo $model->path;?>" target="_blank"><?php echo basename($model->path);?></a>
        	<?php endif;?>
		</td>
	</tr>
<tr>
		<td>Category</td>
		<td>:</td>
		<td><?php echo $model->term->title;?></td>
	</tr>
<tr>
		<td>Status</td>
		<td>:</td>
		<td><?php echo $model->status->title;?></td>
	</tr>
<tr>
		<td>View Count</td>
		<td>:</td>
		<td><?php echo $model->view_count;?></td>
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