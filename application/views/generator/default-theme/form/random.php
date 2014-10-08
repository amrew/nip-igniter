<div class="form-group" style="position:relative">
					<label for="input_{content:key}">{content:fieldLabel}</label>
					<input type="text" class="form-control" id="input_{content:key}" name="{content:modelName}[{content:key}]" value="<?php echo $model->{content:key};?>" placeholder="Enter {content:fieldLabel}...">
					<button type="button" class="btn btn-info btn-absolute btn-random" data-type="{content:type}" data-length="{content:length}" data-target="#input_{content:key}">Random</button>
					
					<div class="help-block"></div>
				</div>

				