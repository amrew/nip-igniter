<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
  <li>
    <a href="<?php echo site_url("admin/dashboard");?>">Home</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <a href="<?php echo $callback;?>"><?php echo $model;?></a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    <?php echo $model->id?'Edit Record':'New Record';?>
  </li>
</ul>

<div id="ajax-message" class="alert alert-info hide"></div>

<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<form role="form" action="<?php echo current_url()."?type={$type}";?>" id="form-edit" method="post" enctype="multipart/form-data">
	  <div class="col-md-7">
	    <div class="portlet light">
	      <div class="portlet-title">
	        <div class="caption">
	          <span class="caption-subject font-green-sharp bold uppercase">
	          <?php echo $model->id?'<i class="fa fa-edit"></i> Edit Record':'<i class="fa fa-plus-circle"></i> New Record';?>
	          </span>
	          <span class="caption-helper"><i class="label label-<?php echo $model->status_id==1?'success':'warning';?>"><?php echo $model->status->title;?></i></span>
	        </div>
	        <div class="tools">
	          <a href="" class="collapse" data-original-title="" title="">
	          </a>
	        </div>
	      </div>
	      <div class="portlet-body form" id="main-content">        
	        <div class="form-body">
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
	            
	        </div>
	        
	      </div>
	    </div>

	    <div class="portlet light">
	      <div class="portlet-title">
	        <div class="caption">
	          <span class="caption-subject font-green-sharp bold uppercase">
	          	Images
	          </span>
	        </div>
	        <div class="tools">
	          <a href="" class="collapse" data-original-title="" title="">
	          </a>
	        </div>
	      </div>
	      <div class="portlet-body form" id="main-content">        
	        <div class="form-body">
	            
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
	        
	      </div>
	    </div>

	  </div>
	  <div class="col-md-5">
	  	<div class="portlet light">
	      <div class="portlet-title">
	        <div class="caption">
	          <span class="caption-subject font-green-sharp bold uppercase">
	          	Category &amp; Tags
	          </span>
	        </div>
	        <div class="tools">
	          <a href="" class="collapse" data-original-title="" title="">
	          </a>
	        </div>
	      </div>
	      <div class="portlet-body form" id="main-content">        
	        <div class="form-body">
	            
	            <div class="form-group">
					<label for="input_category_id">Category</label>
					<select name="Post[category_id]" class="form-control select2me input-sm">
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
					<label for="input_category_id">Tag</label><br>

					<?php $currentTag = $model->getTags();?>

					<select name="tags[]" id="input_tag_category" multiple style="width:100%;">
						
						<?php foreach($allTag as $row):?>
						<option value="<?php echo $row->id;?>" <?php echo in_array($row->id, $currentTag)?"selected":"";?>>
							<?php echo $row->title;?>
						</option>
						<?php endforeach;?>

					</select>
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<input type="text" id="new_tag" placeholder="Add new tag" class="form-control pull-left" style="width:200px;">
							<a href="#" id="btn-submit-tag" class="btn btn-info pull-left" style="margin-left:4px;">Add</a>
						</div>
					</div>
					<div class="help-block"></div>
				</div>

				<hr>

				<div class="form-group">
					<label for="input_parent_id">Parent</label>
					<select name="Post[parent_id]" class="form-control select2me input-sm">
						<option value="">
							Choose
						</option>
						<?php foreach($allPost as $row):?>
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

	      </div>
	    </div>

	    <div class="portlet light">
	      <div class="portlet-title">
	        <div class="caption">
	          <span class="caption-subject font-green-sharp bold uppercase">
	          	Settings
	          </span>
	        </div>
	        <div class="tools">
	          <a href="" class="collapse" data-original-title="" title="">
	          </a>
	        </div>
	      </div>
	      <div class="portlet-body form" id="main-content">        
	        <div class="form-body">
	            
				<div class="form-group">
					<label for="input_allow_comment">Allow Comment</label>
					<input type="checkbox" class="form-control" id="input_allow_comment" name="Post[allow_comment]" value="1" <?php echo ($model->allow_comment == 1 || $model->allow_comment === NULL) ? "checked":"";?> placeholder="Enter Allow Comment...">
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
					<label for="input_meta_title">Publish Date</label>
					<input type="text" class="form-control date-picker" id="input_publish_date" name="Post[publish_date]" value="<?php echo $model->publish_date;?>" placeholder="Enter Publish Date...">
					<div class="help-block"></div>
				</div>

				<input type="hidden" id="input_hidden_status_id" name="Post[status_id]" value="<?php echo $model->status_id;?>">

	        </div>
	        <div class="form-actions">
	          <div class="form-group">
	            <button type="submit" class="btn btn-primary btn-large" id="btnSubmit">Publish</button>
	            <button type="submit" class="btn btn-warning btn-large" id="btnDraft">Draft</button>
	          </div>
	          
	          <div class="progress progress-striped active hide">
	              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
	              </div>
	            </div>
	        </div>
	        
	      </div>
	    </div>

	  </div>
	</form>
</div>

<script type="text/javascript">
$(function(){
  var progress = $('.progress');
  var bar = $('.progress-bar');

  $("#input_tag_category").select2();
  
  $("#btnSubmit").on("click", function(e){
  	e.preventDefault();
  	$("#input_hidden_status_id").val(1);
  	$("#form-edit").submit();
  });

  $("#btnDraft").on("click", function(e){
  	e.preventDefault();
  	$("#input_hidden_status_id").val(2);
  	$("#form-edit").submit();
  });

  submitTags();
  submitForm();  
  
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
                  $('[name*="'+key+'"]')
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

  function submitTags(){
  	$("#new_tag").on("keydown", function(e){
  		if(e.keyCode == 13){
  			e.preventDefault();
  			return false;
  		}
  	});

  	$("#btn-submit-tag").on("click", function(e){
  		e.preventDefault();

  		var value = $("#new_tag").val();
  		if(value == ""){
  			return;
  		}

  		$.ajax({
  			url : "<?php echo site_url('admin/term/edit?type=tag');?>",
  			data : "Term[title]="+value+"&quick=true",
  			type : "post",
  			dataType : "json",
  			beforeSubmit : function(){
  				showLoading();
  			},
  			success : function(rs){
  				if(rs.status == 1){
  					var el = $('#input_tag_category');
					var temp = el.select2('val'); // save current value

					temp.push(rs.data.id); // append new one
					
					var newOptions = rs.tags;
					el.select2('destroy').html(newOptions).select2().select2('val', temp);

					$("#new_tag").val("");
  				}
  			},
  			error : function(){
  				setErrorMessage("Application Error",'danger');
  			}
  		});
  	})
  }

});
</script>