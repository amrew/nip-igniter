<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Profile</h3>
	</div>
	<div class="panel-body">
		<div class="col-md-4 text-center">
			<img src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=200" class="img-thumbnail img-responsive">
		</div>
		<div class="col-md-8">
			<div class="table-responsive">

				<table class="table">
					<tr><td><strong>Username</strong></td><td><?php echo $model->username;?></td></tr>
					<tr><td><strong>Email</strong></td><td><?php echo $model->email;?></td></tr>
					<tr><td><strong>Role</strong></td><td><?php echo $model->role->title;?></td></tr>
					<tr><td><strong>Status</strong></td><td><span class="label label-success"><?php echo $model->status->title;?></span></td></tr>
				</table>

			</div>
			<div class="well well-sm">
				<a href="" class="btn btn-info">Edit</a>
			</div>
		</div>
	</div>
</div>