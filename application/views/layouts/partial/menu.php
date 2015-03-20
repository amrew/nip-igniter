<?php
	$ci = &get_instance();
	$ci->load->model("Menu");

	$menus = $ci->Menu->all(array("order_by"=>"parent_menu_id asc, order asc"));
	$parent_menu_id = array();
?>

<?php foreach($menus as $row){
    if($row->parent_menu_id == 0){
	   $parent_menu_id[$row->id] = $row;
    }
}?>

<?php function tree($menus, $parent_id = 0){?>
    
    <?php foreach($menus as $key => $menu):?>

        <?php if($parent_id == $menu->parent_menu_id):?>
            <?php if(hasSubmenu($menus, $menu->id)):?>
                <?php $temp_menu = $menus; unset($temp_menu[$key])?>
                
                <li class="treeview 
                    <?php foreach($menus as $i=>$m):?>
                        <?php if($m->parent_menu_id == $menu->id):?>
                            <?php isActive($m->controller, $m->params);?>
                        <?php endif;?>
                    <?php endforeach;?>
                ">
                    <a href="#">
                        <i class="<?php echo $menu->icon;?>"></i>
                        <span><?php echo $menu->title;?></span>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                    	<?php tree($temp_menu, $menu->id);?>
                    </ul>
                </li>
            <?php else:?>
                <li><a href="<?php echo site_url($menu->url);?>"><?php echo $menu->title;?></a></li>
            <?php endif;?>
        <?php endif;?>

    <?php endforeach;?>

<?php } 

function hasSubmenu($menus, $parent_id){
    $exists = FALSE;
    foreach($menus as $row){
        if($row->parent_menu_id == $parent_id){
            $exists = TRUE;
            break;
        }
    }
    return $exists;
}

tree($menus, 0);
?>