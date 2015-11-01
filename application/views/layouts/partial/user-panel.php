<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="glyphicon glyphicon-user"></i>
        <span><?php echo $user->username;?> <i class="caret"></i></span>
    </a>
    <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header bg-light-blue">
            <?php if(!empty($user->picture)):?>
                <img src="<?php echo base_url().$user->picture;?>" class="img-circle" alt="User Image" />
            <?php else:?>
                <img src="<?php echo base_url();?>public/theme/admin-lte/img/avatar3.png" class="img-circle" alt="User Image" />
            <?php endif;?>
            <p>
                <?php echo $user->username;?> - <?php echo $user->role->title;?>
                <small>Member since <?php echo date("d M Y", strtotime($user->created));?></small>
            </p>
        </li>
        
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="<?php echo site_url("profile");?>" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="<?php echo site_url("auth/logout");?>" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>