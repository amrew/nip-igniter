<section class="content-header">
    <h1>Profile</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <!-- left column -->
        <div class="col-md-8">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <div class="box-body row">
	                <div class="col-md-4 text-center">
						<img src="<?php echo base_url().$model->picture;?>" class="img-thumbnail img-responsive">
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
							<a href="<?php echo site_url("profile/edit");?>" class="btn btn-info">Edit</a>
						</div>
					</div>
				</div>
            </div><!-- /.box -->

        </div><!--/.col (left) -->
        
    </div>   <!-- /.row -->
</section>