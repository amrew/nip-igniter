<div class="user-panel">
    <div class="pull-left image">
    	<?php if(!empty($user->picture)):?>
	        <img src="<?php echo base_url().$user->picture;?>" class="img-circle" alt="User Image" />
	    <?php else:?>
	        <img src="<?php echo base_url();?>public/theme/admin-lte/img/avatar3.png" class="img-circle" alt="User Image" />
    	<?php endif;?>
    </div>
    <div class="pull-left info">
        <p>Hello, <?php echo $user->username;?></p>

        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $user->role->title;?></a>
    </div>
</div>