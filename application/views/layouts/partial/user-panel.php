<?php $user = user();?>

<!-- BEGIN USER LOGIN DROPDOWN -->
<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
<li class="dropdown dropdown-user dropdown-dark">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
    <span class="username username-hide-on-mobile">
    <?php echo $user->username;?> </span>
    <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
    <?php if(!empty($user->picture)):?>
        <img src="<?php echo base_url().$user->picture;?>" class="img-circle" alt="User Image" width="41" />
    <?php else:?>
        <img alt="" class="img-circle" src="<?php echo $assets_url;?>assets/admin/layout4/img/avatar9.jpg"/>
    <?php endif;?>
    </a>
    <ul class="dropdown-menu dropdown-menu-default">
        <li>
            <a href="<?php echo site_url("profile");?>">
            <i class="icon-user"></i> My Profile </a>
        </li>
        <li>
            <a href="page_calendar.html">
            <i class="icon-calendar"></i> My Calendar </a>
        </li>
        <li>
            <a href="inbox.html">
            <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
            3 </span>
            </a>
        </li>
        <li>
            <a href="page_todo.html">
            <i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
            7 </span>
            </a>
        </li>
        <li class="divider">
        </li>
        <li>
            <a href="extra_lock.html">
            <i class="icon-lock"></i> Lock Screen </a>
        </li>
        <li>
            <a href="<?php echo site_url("auth/logout");?>">
            <i class="icon-key"></i> Log Out </a>
        </li>
    </ul>
</li>
<!-- END USER LOGIN DROPDOWN -->