<div class="form-group">
					<label for="input_{content:key}">{content:fieldLabel}</label>
					<div class="radio-list">
						<?php foreach($all{content:fkModel} as $row):?>
							<label for="{content:key}_<?php echo $row->{content:fieldPrimary};?>">
								<div class="radio">
										<input type="radio" id="{content:key}_<?php echo $row->{content:fieldPrimary};?>" name="{content:modelName}[{content:key}]" value="<?php echo $row->{content:fieldPrimary};?>" class="iradio" <?php echo ($row->{content:fieldPrimary}==$model->{content:key}?"checked":"");?>>
								</div>
								<?php echo $row->{content:fieldTitle};?>
							</label>
						<?php endforeach;?>
					</div>
					<div class="help-block"></div>
				</div>

				