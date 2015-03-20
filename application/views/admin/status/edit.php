<section class="content-header">
    <h1><?php echo $model;?></h1>
</section>
<ol class="breadcrumb">
	<li><a href="<?php echo $callback;?>"><i class="fa fa-chevron-circle-left"></i> Back</a></li>
	<li class="active"><span><?php echo $model->id?'<i class="fa fa-edit"></i> Edit Record':'<i class="fa fa-plus-circle"></i> New Record';?></span></li>
</ol>

<!-- Main content -->
<section class="content">
	<div class="row">
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

					<form role="form" action="<?php echo current_url();?>" id="form-edit" method="post" enctype="multipart/form-data">
						<input type="hidden" name="callback" value="<?php echo $callback;?>">

						<div class="form-group">
					<label for="input_title">Title</label>
					<input type="text" class="form-control" id="input_title" name="Status[title]" value="<?php echo $model->title;?>" placeholder="Enter Title...">
					<div class="help-block"></div>
				</div>

				
						
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-large" id="btnSubmit">Submit</button>
						</div>
						
						<div class="progress progress-striped active hide">
					    	<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
					    	</div>
					    </div>

					</form>
				</div>
            </div><!-- /.box -->

        </div><!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-5">
            
        </div><!--/.col (right) -->
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

});
</script>