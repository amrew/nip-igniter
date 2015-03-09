<table class="table table-hover">
	<thead>
		<tr><th>Menu name</th><th>view</th><th>create</th><th>update</th><th>delete</th><th>trash</th><th>restore</th><th>delete permanent</th></tr>
	</thead>
	<tbody>
		<?php foreach($menus as $row):?>
			<?php $privilege = $this->Privilege->first(array("menu_id"=>$row->id, "role_id"=>$role_id));?>
			<tr>
				<td>
					<?php echo $row->title;?>
					<input type="hidden" name="menu_id" value="<?php echo $row->id;?>">
				</td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][view]" value="1" <?php echo !empty($privilege) && ($privilege->view == 1)?"checked":"";?>></td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][create]" value="1" <?php echo !empty($privilege) && ($privilege->create == 1)?"checked":"";?>></td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][update]" value="1" <?php echo !empty($privilege) && ($privilege->update == 1)?"checked":"";?>></td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][delete]" value="1" <?php echo !empty($privilege) && ($privilege->delete == 1)?"checked":"";?>></td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][trash]" value="1" <?php echo !empty($privilege) && ($privilege->trash == 1)?"checked":"";?>></td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][restore]" value="1" <?php echo !empty($privilege) && ($privilege->restore == 1)?"checked":"";?>></td>
				<td><input type="checkbox" class="icheck" name="menu[<?php echo $row->id;?>][delete_permanent]" value="1" <?php echo !empty($privilege) && ($privilege->delete_permanent == 1)?"checked":"";?>></td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>

<input type="hidden" name="privilege" value="true">