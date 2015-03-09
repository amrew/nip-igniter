<td>
					<select name="{content:fieldName}" class="form-control input-search">
						<option value="">All</option>
						<?php foreach($all{content:modelName} as $row):?>
							<option value="<?php echo $row->{content:fieldPrimary};?>"
								<?php if(isset($_GET['keywords']['{content:fieldName}'])):?>
									<?php echo $_GET['keywords']['{content:fieldName}']==$row->{content:fieldPrimary}?"selected":"";?>
								<?php endif;?>
							><?php echo $row->{content:fieldTitle};?></option>
						<?php endforeach;?>
					</select>
				</td>
				