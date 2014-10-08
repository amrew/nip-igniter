<div id="main-content">
	<ol class="breadcrumb breadcrumb-arrow">
		<li><a href="<?php echo $callback;?>"><i class="glyphicon glyphicon-circle-arrow-left"></i> Back</a></li>
		<li class="active"><span><?php echo $model->id?"Edit Record":"New Record";?></span></li>
	</ol>
	
	<div id="ajax-message" class="alert alert-info hide"></div>

	<form role="form" action="<?php echo current_url();?>" id="form-edit" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-7">

				<input type="hidden" name="callback" value="<?php echo $callback;?>">

				<div class="form-group">
					<label for="input_username">Username</label>
					<input type="text" class="form-control" id="input_username" name="User[username]" value="<?php echo $model->username;?>" placeholder="Enter Username...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_password">Password</label>
					<input type="password" class="form-control" id="input_password" name="password" value="" placeholder="Enter Password...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_email">Email</label>
					<input type="email" class="form-control" id="input_email" name="User[email]" value="<?php echo $model->email;?>" placeholder="Enter Email...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_role_id">Role</label>
					<select name="User[role_id]" class="input-selecter">
						<option value="">
							Choose
						</option>
						<?php foreach($allRole as $row):?>
						<option value="<?php echo $row->id;?>" <?php echo ($row->id==$model->role_id?"selected":"");?>>
							<?php echo $row->title;?>
						</option>
						<?php endforeach;?>
					</select>
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_status_id">Status</label>
					<?php foreach($allStatus as $row):?>
						<div class="radio">
							<input type="radio" id="status_id_<?php echo $row->id;?>" name="User[status_id]" value="<?php echo $row->id;?>" class="iradio" <?php echo ($row->id==$model->status_id?"checked":"");?>>
							<label for="status_id_<?php echo $row->id;?>"><?php echo $row->title;?></label>
						</div>
					<?php endforeach;?>
					<div class="help-block"></div>
				</div>

				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-large" id="btnSubmit">Submit</button>
				</div>
				
				<div class="progress progress-striped active hide">
			    	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			    	</div>
			    </div>

			</div>

			<div class="col-md-6">
				<!--Another field-->
			</div>
		</div>

	</form>
</div>

<script type="text/javascript">
$(function(){

  submitForm();

  var progress = $('.progress');
  var bar = $('.progress-bar');
	
  function submitForm(){
    $("#form-edit").on('submit', function(event) {
      event.preventDefault();
      var currentForm = $(this);
      
      currentForm.ajaxSubmit({
      	beforeSerialize:function(){
      		if(typeof(CKEDITOR) != "undefined"){
	      		for ( instance in CKEDITOR.instances ){
	        		CKEDITOR.instances[instance].updateElement();
	        	}
        	}
      	},
        beforeSend: function() {
		      $("#btnSubmit").button("loading");

		      progress.removeClass('hide');
		      var percentVal = '0%';
		      bar.width(percentVal);

		      $(".help-block").html("").parents("div.form-group").removeClass('has-error');
		    },
		    uploadProgress: function(event, position, total, percentComplete) {
		      var percentVal = percentComplete + '%';
		      bar.width(percentVal);
		    	//console.log(percentVal, position, total);
		    },
        dataType: 'json',
        success : function(rs){
          var percentVal = '100%';
        	bar.width(percentVal);
          
          $("#btnSubmit").button("reset");
          if(rs.status == 1){
          	$("#ajax-message").removeClass('hide').html(rs.message);

          	if(typeof(rs.crop) != 'undefined'){
          		$("#main-content").html(rs.crop);
          	}else{
            	window.location.href = '<?php echo $callback;?>';
          	}
          }else{
          	progress.addClass('hide');

          	var array = rs.message;

          	if(typeof(array) == "object"){
	          	for(var key in array){
	          		if(array[key]!=""){
		          		$('[name="'+key+'"]')
		          			.parents('div.form-group')
		          			.addClass("has-error")
		          			.find('div.help-block')
		          			.html(array[key]);
		          		}
	          	}
          	}else{
          		$("#ajax-message").removeClass('hide').html(rs.message);
          	}
          }
        },
        error: function(){
        	setErrorMessage("Application Error",'danger');
        }
      });
      
    });
  }

});
</script>