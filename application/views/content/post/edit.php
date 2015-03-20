<section class="content-header">
    <h1><?php echo $model;?></h1>
</section>
<ol class="breadcrumb">
	<li><a href="<?php echo $callback;?>"><i class="fa fa-chevron-circle-left"></i> Back</a></li>
	<li class="active"><span><?php echo $model->id?'<i class="fa fa-edit"></i> Edit Record':'<i class="fa fa-plus-circle"></i> New Record';?></span></li>
</ol>

<!-- Main content -->
<section class="content" id="main-content">
	<div class="row">
		<form role="form" action="<?php echo current_url().$queryString;?>" id="form-edit" method="post" enctype="multipart/form-data">
	        <!-- left column -->
	        <div class="col-md-7">
	            <!-- general form elements -->
	            <div class="box box-primary">
	                <div class="box-header">
	                    <h3 class="box-title"><?php echo $model->id?'<i class="fa fa-edit"></i> Edit Record':'<i class="fa fa-plus-circle"></i> New Record';?></h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	                <div class="box-body" id="main-content">
		                <div id="ajax-message" class="alert alert-info hide"></div>

							<input type="hidden" name="callback" value="<?php echo $callback;?>">

							<div class="form-group">
								<label for="input_title">Title</label>
								<input type="text" class="form-control" id="input_title" name="Post[title]" value="<?php echo $model->title;?>" placeholder="Enter Title...">
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_content">Content</label>
								<textarea class="form-control ckeditor" id="input_content" name="Post[content]" placeholder="Enter Content..."><?php echo $model->content;?></textarea>
								<div class="help-block"></div>
							</div>

							<?php if(!empty($model->slug)):?>
							<div class="form-group">
								<label for="input_slug">Slug</label>
								<input type="text" class="form-control" id="input_slug" name="Post[slug]" value="<?php echo $model->slug;?>" placeholder="Enter Slug...">
								<div class="help-block"></div>
							</div>
							<?php endif;?>

							<?php if(!empty($model->thumb)):?>
							<div class="form-group">
								<img src="<?php echo base_url().$model->thumb;?>" width="170">
							</div>
							<?php endif;?><div class="form-group">
								<label for="input_image">Image</label>
								<input type="file" class="form-control" id="input_image" name="image">
								<div class="help-block"></div>
							</div>

					</div>
	            </div><!-- /.box -->

	        </div><!--/.col (left) -->
	        <!-- right column -->
	        <div class="col-md-5">

	            <!-- general form elements -->
	            <div class="box box-primary">
	                <div class="box-header">
	                    <h3 class="box-title"><i class="fa fa-tags"></i> Category</h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	                <div class="box-body" id="main-content">
		                
							<div class="form-group">
								<label for="input_category_id">Category</label>
								<select name="Post[category_id]" class="form-control">
									<option value="">
										Choose
									</option>
									<?php foreach($allTerm as $row):?>
									<option value="<?php echo $row->id;?>" <?php echo ($row->id==$model->category_id?"selected":"");?>>
										<?php echo $row->title;?>
									</option>
									<?php endforeach;?>
								</select>
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_parent_id">Parent</label>
								<select name="Post[parent_id]" class="form-control">
									<option value="">
										Choose
									</option>
									<?php foreach($allPage as $row):?>
									<option value="<?php echo $row->id;?>" <?php echo ($row->id==$model->parent_id?"selected":"");?>>
										<?php echo $row->title;?>
									</option>
									<?php endforeach;?>
								</select>
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_order">Order</label>
								<input type="number" class="form-control" id="input_order" name="Post[order]" value="<?php echo $model->order;?>" placeholder="Enter Order...">
								<div class="help-block"></div>
							</div>

					</div>
	            </div><!-- /.box -->

	            <!-- general form elements -->
	            <div class="box box-primary">
	                <div class="box-header">
	                    <h3 class="box-title"><i class="fa fa-gears"></i> Settings</h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	                <div class="box-body" id="main-content">
		                	
							<div class="form-group">
								<label for="input_allow_comment">Allow Comment</label>
								<input type="checkbox" class="form-control" id="input_allow_comment" name="Post[allow_comment]" value="1" <?php echo $model->allow_comment == NULL || $model->allow_comment == 1?"checked":"";?> placeholder="Enter Allow Comment...">
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_meta_title">Meta Title</label>
								<input type="text" class="form-control" id="input_meta_title" name="Post[meta_title]" value="<?php echo $model->meta_title;?>" placeholder="Enter Meta Title...">
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_meta_description">Meta Description</label>
								<textarea class="form-control" id="input_meta_description" name="Post[meta_description]" placeholder="Enter Meta Description..."><?php echo $model->meta_description;?></textarea>
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_publish_date">Publish Date</label>
								<input type="text" class="form-control datepicker" id="input_publish_date" name="Post[publish_date]" value="<?php echo $model->publish_date?:date("Y-m-d");?>" placeholder="Enter Publish Date...">
								<div class="help-block"></div>
							</div>

							<div class="form-group">
								<label for="input_status_id">Status</label>
								<select name="Post[status_id]" class="form-control">
									<option value="">
										Choose
									</option>
									<?php foreach($allStatus as $row):?>
									<option value="<?php echo $row->id;?>" <?php echo ($row->id==$model->status_id?"selected":"");?>>
										<?php echo $row->title;?>
									</option>
									<?php endforeach;?>
								</select>
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
	            </div><!-- /.box -->

	        </div><!--/.col (right) -->
		</form>
    </div>   <!-- /.row -->
</section>

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
		          		$('[name="<?php echo $model;?>['+key+']"]')
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