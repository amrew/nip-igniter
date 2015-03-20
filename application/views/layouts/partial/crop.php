<div>
	<h4>Crop Image</h4>

	<div class="ajax-message" class="alert alert-info hide"></div>
	
	<form method="post" action="<?php echo site_url($pathController."/submit-crop".$queryString);?>" id="form-cropping"  enctype="multipart/form-data">
		<input type="hidden" id="x" name="x" value="">
		<input type="hidden" id="y" name="y" value="">
		
		<input type="hidden" id="x_width" name="x_width" value="">
		<input type="hidden" id="y_height" name="y_height" value="">
		
		<input type="hidden" id="img_width" name="img_width" value="">
		<input type="hidden" id="img_height" name="img_height" value="">
		
		<input type="hidden" id="img_path" name="img_path" value="<?php echo $path;?>">
		
		<input type="hidden" name="is_thumb" value="<?php echo $is_thumb;?>">

		<input type="hidden" id="scale_width" name="scale_width" value="<?php echo $scale_width;?>">
		<input type="hidden" id="scale_height" name="scale_height" value="<?php echo $scale_height;?>">
		
		<div class="form-group">
			<img id="jcrop-target" src="<?php echo base_url().$path;?>" class="img-responsive img-thumbnail">
		</div>

		<input type="hidden" id="is_skip" name="is_skip" value="false">
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary" id="btn-cropping">Crop Now!</button> or 
			<button type="submit" class="btn btn-primary" id="btn-skip">Skip this section</button>
		</div>
		
		<div class="progress progress-striped active hide">
		  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
		  </div>
		</div>
	</form>
</div>

<script type="text/javascript">
var progress = $('.progress');
var bar = $('.progress-bar');

$(function(){
	$('#jcrop-target').Jcrop({
		aspectRatio: <?php echo $scale_width;?> / <?php echo $scale_height;?>,
		setSelect:   [ 100, 100, 50, 50 ],
		onChange: showCoords,
		onSelect: showCoords,
	});

	submitForm();
});
function showCoords(c)
{
	$('#x').val(c.x);
	$('#y').val(c.y);
	
	$('#x_width').val(c.w);
	$('#y_height').val(c.h);

	$("#img_width").val($("#jcrop-target").width());
	$("#img_height").val($("#jcrop-target").height());
};

function submitForm(){
$("#btn-skip").on("click", function(){
	$("#is_skip").val("true");
	console.log($("#is_skip").val());
});

$("#form-cropping").on('submit', function(event) {
  event.preventDefault();
  var currentForm = $(this);
  
  currentForm.ajaxSubmit({
    beforeSend: function() {
	      $("#btn-cropping").button("loading");

	      progress.removeClass('hide');
	      var percentVal = '0%';
	      bar.width(percentVal);

	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	      var percentVal = percentComplete + '%';
	      bar.width(percentVal);
	    },
    dataType: 'json',
    success : function(rs){
      var percentVal = '100%';
    	bar.width(percentVal);

      $("#btn-cropping").button("reset");
      
      $("#ajax-message").removeClass('hide').html(rs.message);

      if(rs.status == 1){
        window.location.href = '<?php echo $redirect_url;?>';
      }

    },
    error: function(){
    	setErrorMessage("Application Error",'danger');
    }
  });
  
});
}
</script>