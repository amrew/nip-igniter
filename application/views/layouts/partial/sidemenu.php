<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
	<li class="start ">
		<a href="<?php echo site_url("dashboard");?>">
		<i class="icon-home"></i>
		<span class="title">Dashboard</span>
		</a>
	</li>
	<li class="
			<?php isMenuActive('PostController', 'type=post');?>
			<?php isMenuActive('TermController', 'type=category');?>
			<?php isMenuActive('TermController', 'type=tag');?>
		">
		<a href="javascript:;">
		<i class="icon-notebook"></i>
		<span class="title">Post</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li><a href="<?php echo site_url("admin/post?type=post");?>"><i class="fa fa-list"></i> Post List</a></li>
			<li><a href="<?php echo site_url("admin/post/edit?type=post");?>"><i class="fa fa-plus"></i> New Post</a></li>

			<li><a href="<?php echo site_url("admin/term?type=category");?>"><i class="fa fa-list-ol"></i> Category</a></li>
			<li><a href="<?php echo site_url("admin/term?type=tag");?>"><i class="fa fa-tags"></i> Tag</a></li>
		</ul>
	</li>
	<li class="
			<?php isMenuActive('PostController', 'type=page');?>
		">
		<a href="javascript:;">
		<i class="fa fa-file-o"></i>
		<span class="title">Page</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li><a href="<?php echo site_url("admin/post?type=page");?>"><i class="fa fa-list"></i> Page List</a></li>
			<li><a href="<?php echo site_url("admin/post/edit?type=page");?>"><i class="fa fa-plus"></i> New Page</a></li>
		</ul>
	</li>
	<li class="
			<?php isMenuActive('CommentController', 'type=content');?>
		">
		<a href="<?php echo site_url('admin/comment?type=content');?>">
		<i class="fa fa-comment-o"></i>
		<span class="title">Comments</span>
		</a>
	</li>
	<li class="
			<?php isMenuActive('MediaController', 'type=photo');?>
			<?php isMenuActive('MediaController', 'type=video');?>
			<?php isMenuActive('MediaController', 'type=file');?>
			<?php isMenuActive('TermController', 'type=photo');?>
			<?php isMenuActive('TermController', 'type=video');?>
			<?php isMenuActive('TermController', 'type=file');?>
			<?php isMenuActive('FileManagerController');?>
		">
		<a href="javascript:;">
		<i class="icon-social-youtube"></i>
		<span class="title">Media &amp; Files</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li class="
					<?php isMenuActive('MediaController', 'type=photo');?>
					<?php isMenuActive('TermController', 'type=photo');?>
				">
				<a href="javascript:;">
				<i class="icon-picture"></i> Photos <span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li>
						<a href="<?php echo site_url('admin/media?type=photo');?>"><i class="icon-list"></i> Photo List</a>
					</li>
					<li>
						<a href="<?php echo site_url("admin/term?type=photo");?>"><i class="fa fa-list-ol"></i> Photo Category</a>
					</li>
				</ul>
			</li>
			<li class="
					<?php isMenuActive('MediaController', 'type=video');?>
					<?php isMenuActive('TermController', 'type=video');?>
				">
				<a href="javascript:;">
				<i class="icon-control-play"></i> Videos <span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li>
						<a href="<?php echo site_url('admin/media?type=video');?>"><i class="icon-list"></i> Video List</a>
					</li>
					<li>
						<a href="<?php echo site_url("admin/term?type=video");?>"><i class="fa fa-list-ol"></i> Video Category</a>
					</li>
				</ul>
			</li>
			<li class="
					<?php isMenuActive('MediaController', 'type=file');?>
					<?php isMenuActive('TermController', 'type=file');?>
				">
				<a href="javascript:;">
				<i class="icon-docs"></i> Files <span class="arrow"></span>
				</a>
				<ul class="sub-menu">
					<li>
						<a href="<?php echo site_url('admin/media?type=file');?>"><i class="icon-list"></i> File List</a>
					</li>
					<li>
						<a href="<?php echo site_url("admin/term?type=file");?>"><i class="fa fa-list-ol"></i> File Category</a>
					</li>
				</ul>
			</li>
			<li class="<?php isMenuActive('FileManagerController');?>"><a href="<?php echo site_url('file-manager');?>"><i class="fa fa-folder-o"></i> File Manager</a></li>
		</ul>
	</li>
	<li class="
			<?php isMenuActive('PostController', 'type=forum');?>
			<?php isMenuActive('CommentController', 'type=forum');?>
			<?php isMenuActive('TermController', 'type=forum');?>
		">
		<a href="javascript:;">
		<i class="icon-speech"></i>
		<span class="title">Forums</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li><a href="<?php echo site_url("admin/post?type=forum");?>"><i class="fa fa-list"></i> Forum List</a></li>
			<li><a href="<?php echo site_url("admin/post/edit?type=forum");?>"><i class="fa fa-plus"></i> New Page</a></li>
			<li><a href="<?php echo site_url("admin/comment/?type=forum");?>"><i class="fa fa-comment"></i> Comment</a></li>
			<li><a href="<?php echo site_url("admin/term/?type=forum");?>"><i class="fa fa-list-ol"></i> Category</a></li>
		</ul>
	</li>
	<li class="
			<?php isMenuActive('UserController');?>
			<?php isMenuActive('RoleController');?>
			<?php isMenuActive('StatusController');?>
			<?php isMenuActive('MenuController');?>
			<?php isMenuActive('PrivilegeController');?>
		">
		<a href="javascript:;">
		<i class="icon-users"></i>
		<span class="title">Users &amp; Privileges</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li><a href="<?php echo site_url('/admin/user');?>"><i class="fa fa-users"></i> User</a></li>
			<li><a href="<?php echo site_url('/admin/role');?>"><i class="fa fa-gavel"></i> Role</a></li>
			<li><a href="<?php echo site_url('/admin/status');?>"><i class="fa fa-list"></i> Status</a></li>
			<li class="divider"></li>
			<li><a href="<?php echo site_url('/admin/menu');?>"><i class="fa fa-bars"></i> Menu</a></li>
			<li><a href="<?php echo site_url('/admin/privilege');?>"><i class="fa fa-lock"></i> Privilege</a></li>
		</ul>
	</li>
	<li class="<?php isMenuActive('GeneratorController');?>">
		<a href="javascript:;">
		<i class="fa fa-gears"></i>
		<span class="title">Settings</span>
		<span class="arrow "></span>
		</a>
		<ul class="sub-menu">
			<li><a href="<?php echo site_url('/admin/user');?>"><i class="fa fa-gear"></i> General</a></li>
			<li><a href="<?php echo site_url('generator');?>"><i class="fa fa-flask"></i> Generator</a></li>
		</ul>
	</li>
</ul>