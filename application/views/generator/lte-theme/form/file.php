<div class="form-group">
					<label for="input_{content:key}">{content:fieldLabel}</label>
					<input type="file" class="form-control" id="input_{content:key}" name="{content:key}">
					<div class="help-block"><a href="<?php echo base_url().$model->{content:key};?>"><?php echo basename($model->{content:key});?></a></div>
					<div class="help-block"></div>
				</div>

				