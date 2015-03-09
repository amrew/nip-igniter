<div class="col-md-10 col-md-offset-1 article-block">
	<h3 style="margin-top:0;"><?php echo $model->title;?></h3>
	<div class="blog-tag-data">
		<?php if(!empty($model->image)):?>
		<img src="<?php echo $model->pathImage;?>" class="img-responsive" alt="">
		<?php endif;?>
		<hr>
		<div class="row">
			<div class="col-md-6">
				<ul class="list-inline blog-tags">
					<li>
						<i class="fa fa-tags"></i>
						<a href="#"><?php echo $model->category->title;?></a>
					</li>
					<li>
						<i class="fa fa-info"></i>
						<a href="#"><?php echo $model->status->title;?></a>
					</li>
				</ul>
			</div>
			<div class="col-md-6 blog-tag-data-inner">
				<ul class="list-inline">
					<li>
						<i class="fa fa-calendar"></i>
						<a href="#">
						<?php echo $model->date();?> </a>
					</li>
					<!-- <li>
						<i class="fa fa-comments"></i>
						<a href="#">
						38 Comments </a>
					</li> -->
				</ul>
			</div>
		</div>
	</div>
	<!--end news-tag-data-->
	<div>
		<?php echo $model->content;?>
	</div>
</div>

<div class="clearfix"></div>
<!-- 
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
		<td>Content</td>
		<td>:</td>
		<td><?php echo $model->content;?></td>
	</tr>
<tr>
		<td>Slug</td>
		<td>:</td>
		<td><?php echo $model->slug;?></td>
	</tr>
<tr>
		<td>Category</td>
		<td>:</td>
		<td><?php echo $model->term->title;?></td>
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
<tr>
		<td>Author</td>
		<td>:</td>
		<td><?php echo $model->user->username;?></td>
	</tr>
<tr>
		<td>Image</td>
		<td>:</td>
		<td><img width="170" src="<?php echo base_url().$model->thumb;?>"></td>
	</tr>
<tr>
		<td>Parent</td>
		<td>:</td>
		<td><?php echo $model->post->title;?></td>
	</tr>
<tr>
		<td>Order</td>
		<td>:</td>
		<td><?php echo $model->order;?></td>
	</tr>
<tr>
		<td>View Count</td>
		<td>:</td>
		<td><?php echo $model->view_count;?></td>
	</tr>
<tr>
		<td>Comment Count</td>
		<td>:</td>
		<td><?php echo $model->comment_count;?></td>
	</tr>
<tr>
		<td>Allow Comment</td>
		<td>:</td>
		<td><?php echo $model->allow_comment;?></td>
	</tr>
<tr>
		<td>Meta Title</td>
		<td>:</td>
		<td><?php echo $model->meta_title;?></td>
	</tr>
<tr>
		<td>Meta Description</td>
		<td>:</td>
		<td><?php echo $model->meta_description;?></td>
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
</table> -->