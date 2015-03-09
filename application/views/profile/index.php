<div class="row">
	<div class="col-md-2 col-sm-3">
		<div class="">
			<img src="<?php echo base_url().$model->picture;?>" class="img-thumbnail img-responsive">
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<table class="table">
			<tr><td><strong>Username</strong></td><td><?php echo $model->username;?></td></tr>
			<tr><td><strong>Email</strong></td><td><?php echo $model->email;?></td></tr>
			<tr><td><strong>Role</strong></td><td><?php echo $model->role->title;?></td></tr>
			<tr><td><strong>Status</strong></td><td><span class="label label-success"><?php echo $model->status->title;?></span></td></tr>
		</table>
		<div class="alert alert-info">
			<a href="<?php echo site_url("profile/edit");?>" class="btn btn-info">Edit</a>
		</div>
	</div>
</div>