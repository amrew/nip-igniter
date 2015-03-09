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
  <div class="col-md-7">
    <div class="portlet light">
      <div class="portlet-title">
        <div class="caption">
          <span class="caption-subject font-green-sharp bold uppercase">
          <?php echo $model->id?'<i class="fa fa-edit"></i> Edit Record':'<i class="fa fa-plus-circle"></i> New Record';?>
          </span>
        </div>
        <div class="tools">
          <a href="" class="collapse" data-original-title="" title="">
          </a>
        </div>
      </div>
      <div class="portlet-body form" id="main-content">
        <form role="form" action="<?php echo current_url()."?type={$type}";?>" id="form-edit" method="post" enctype="multipart/form-data">
        <div class="form-body">
            <input type="hidden" name="callback" value="<?php echo $callback;?>">

            <div class="form-group">
					<label for="input_post_id">Post</label>
					<select name="Comment[post_id]" class="form-control">
						<option value="">
							Choose
						</option>
						<?php foreach($allPost as $row):?>
						<option value="<?php echo $row->id;?>" <?php echo ($row->id==$model->post_id?"selected":"");?>>
							<?php echo $row->title;?>
						</option>
						<?php endforeach;?>
					</select>
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_name">Name</label>
					<input type="text" class="form-control" id="input_name" name="Comment[name]" value="<?php echo $model->name;?>" placeholder="Enter Name...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_email">Email</label>
					<input type="email" class="form-control" id="input_email" name="Comment[email]" value="<?php echo $model->email;?>" placeholder="Enter Email...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_website">Website</label>
					<input type="text" class="form-control" id="input_website" name="Comment[website]" value="<?php echo $model->website;?>" placeholder="Enter Website...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_message">Message</label>
					<textarea class="form-control" id="input_message" name="Comment[message]" placeholder="Enter Message..."><?php echo $model->message;?></textarea>
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_type">Type</label>
					<input type="text" class="form-control" id="input_type" name="Comment[type]" value="<?php echo $model->type;?>" placeholder="Enter Type...">
					<div class="help-block"></div>
				</div>

				<div class="form-group">
					<label for="input_status_id">Status</label>
					<div class="radio-list">
						<?php foreach($allStatus as $row):?>
							<label for="status_id_<?php echo $row->id;?>">
								<div class="radio">
										<input type="radio" id="status_id_<?php echo $row->id;?>" name="Comment[status_id]" value="<?php echo $row->id;?>" class="iradio" <?php echo ($row->id==$model->status_id?"checked":"");?>>
								</div>
								<?php echo $row->title;?>
							</label>
						<?php endforeach;?>
					</div>
					<div class="help-block"></div>
				</div>

				
            
        </div>
        <div class="form-actions">
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-large" id="btnSubmit">Submit</button>
          </div>
          
          <div class="progress progress-striped active hide">
              <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-5"></div>
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