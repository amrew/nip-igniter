<div class="form-group">
					<label for="input_{content:key}">{content:fieldLabel}</label>
					<?php foreach($all{content:fkModel} as $row):?>
						<div class="radio">
							<input type="radio" id="{content:key}_<?php echo $row->{content:fieldPrimary};?>" name="{content:modelName}[{content:key}]" value="<?php echo $row->{content:fieldPrimary};?>" class="iradio" <?php echo ($row->{content:fieldPrimary}==$model->{content:key}?"checked":"");?>>
							<label for="{content:key}_<?php echo $row->{content:fieldPrimary};?>"><?php echo $row->{content:fieldTitle};?></label>
						</div>
					<?php endforeach;?>
					<div class="help-block"></div>
				</div>

				