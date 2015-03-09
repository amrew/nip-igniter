<div class="form-group">
					<label for="input_{content:key}">{content:fieldLabel}</label>
					<select name="{content:modelName}[{content:key}]" class="form-control">
						<option value="">
							Choose
						</option>
						<?php foreach($all{content:fkModel} as $row):?>
						<option value="<?php echo $row->{content:fieldPrimary};?>" <?php echo ($row->{content:fieldPrimary}==$model->{content:key}?"selected":"");?>>
							<?php echo $row->{content:fieldTitle};?>
						</option>
						<?php endforeach;?>
					</select>
					<div class="help-block"></div>
				</div>

				