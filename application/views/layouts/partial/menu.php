<li style="background:blanchedalmond"><a href="#"><strong>MENU</strong></a></li>
<?php
	$ci = &get_instance();
	$ci->load->model("Menu");

	$rightmenus = array();
    $menus = $ci->Menu->all(array(
        "where"=>array("privilege.role_id"=>$this->Auth->role()),
        "order_by"=>"parent_menu_id asc, order asc",
        "left_join" => array(
            "privilege" => "privilege.menu_id = menu.id"
        ),
        "fields" => "menu.*, 
                    privilege.view,
                    privilege.create,
                    privilege.update,"
    ));
    foreach($menus as $menu){
        $rightmenus[$menu->id] = $menu;
    }

    // debug($rightmenus);die;

    // All menu
    $menus = $ci->Menu->all(array(
        "order_by"=>"parent_menu_id asc, order asc",
    ));

	$parent_menu_id = array();

    foreach($menus as $row){
        if($row->parent_menu_id == 0){
    	   $parent_menu_id[$row->id] = $row;
        }
    }
    
    function tree($menus, $parent_id = 0, $rightmenus){?>
    
    <?php foreach($menus as $key => $menu):?>

        <?php if($parent_id == $menu->parent_menu_id):?>
            <?php if(hasSubmenu($menus, $menu->id, $rightmenus)):?>
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
                    	<?php tree($temp_menu, $menu->id, $rightmenus);?>
                    </ul>
                </li>
            <?php else:?>
                <?php if(hasPrivilege($menu, $rightmenus)):?>
                    <li><a href="<?php echo site_url($menu->url);?>"><?php echo $menu->title;?></a></li>
                <?php endif;?>
            <?php endif;?>
        <?php endif;?>

    <?php endforeach;?>

<?php } 

function hasSubmenu($menus, $parent_id, $rightmenus){
    $exists = FALSE;
    foreach($menus as $row){
        if($row->parent_menu_id == $parent_id){
            if(hasPrivilege($row, $rightmenus)){
                $exists = TRUE;
                break;
            }
        }
    }
    return $exists;
}

function hasPrivilege($row, $rightmenus){
    // if(isset($rightmenus[$row->id])){
    //     return TRUE;
    // }else{
        foreach($rightmenus as $menu){

            $explode = explode('?', $menu->url);
            $mainUrl = isset($explode[0])?$explode[0]:$menu->url;
            
            if(strpos($row->url, $mainUrl)!== false){
                if(strpos($row->url, $mainUrl.'/edit') !== false && $menu->create == 0){
                    return FALSE;
                }else if($row->url == $mainUrl && $menu->view == 0){
                    return FALSE;
                }

                return TRUE;
            }
        }
        return FALSE;
    // }
}

tree($menus, 0, $rightmenus);
?>