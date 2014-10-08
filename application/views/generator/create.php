<form class="form-settings" method="post" action="<?php echo site_url($controller."/submit-create-table");?>">

	<div class="panel panel-default panel-custom">
	  <!-- Default panel contents -->
	  <div class="panel-heading">
	  	<h4><?php echo $title;?></h4>
	  </div>
	  <div class="panel-body">
	    <p>Please custom the input below.</p>

      <div class="ajax-error"></div>
	  </div>

	  <input type="hidden" name="Settings[tableName]" value="<?php echo $tableName;?>">
	  <input type="hidden" name="Settings[modelName]" value="<?php echo $modelName;?>">
    <?php foreach($ignoredField as $ignore):?>
      <input type="hidden" name="Settings[ignoredField][]" value="<?php echo $ignore;?>">
    <?php endforeach;?>
    <input type="hidden" name="Settings[isCrud]"       value="<?php echo $isCrud;?>">
		<input type="hidden" name="Settings[isTimestamps]" value="<?php echo $isTimestamps;?>">
		<input type="hidden" name="Settings[isSoftDelete]" value="<?php echo $isSoftDelete;?>">
		<input type="hidden" name="Settings[createdField]" value="<?php echo $createdField;?>">
		<input type="hidden" name="Settings[updatedField]" value="<?php echo $updatedField;?>">
		<input type="hidden" name="Settings[deletedField]" value="<?php echo $deletedField;?>">
    
	  <!-- Table -->
	  <table class="table table-bordered">
	    <thead>
        <tr>
          <th width="200">NAME</th>
          <th>TYPE</th>
          <th width="70">
          	<div class="checkbox" style="text-align:right">
              <label for="all-checkbox" style="font-weight:bold"><abbr title="Choose the fields that will shown in the grid">?</abbr></label> &nbsp
              <input type="checkbox" id="all-checkbox">
            </div>
          </th>
          <th width="50">
          </th>
        </tr>
      </thead>
      <tbody id="container-duplication">

    		<tr>
      		<td>
      			<input class="form-control" name="Field[0][name]" placeholder="Field name... " value="id" style="width:200px">
      		</td>
      		<td>

      			<select name="Field[0][type]" class="input-selecter">
								<option value="primary">Primary</option>
            </select>
						
      		</td>
      		<td align="right">
      			<div class="checkbox">
              <input type="checkbox" class="each-checkbox" name="Field[0][show]" value="1">
            </div>
      		</td>
          <td>
          
          </td>
      	</tr>

      </tbody>
      <tbody>
        <?php /*foreach($ignoredField as $ignore):?>
          <tr>
            <td>
              <input class="form-control" value="<?php echo $ignore;?>" readonly style="width:200px">
            </td>
            <td>

              <select class="input-selecter">
                  <option value="primary">DateTime</option>
              </select>
              
            </td>
            <td align="right">
              
            </td>
          </tr>
        <?php endforeach;*/?>
        <tr>
          <td colspan="3">
            <button id="btnDuplicate" class="btn-dark pull-right" type="button"><span class="glyphicon glyphicon-plus-sign"></span> Add More</button> 
          </td>
        </tr>

        <tr>
      		<td colspan="3">
      			<button class="btn-dark" type="submit" data-loading-text="Start to generate...">Submit</button> 
      			<button type="button" class="btn-dark-green" data-dismiss="modal">Cancel</button>
      		</td>
      	</tr>

      </tbody>
	  </table>

	</div>

</form>

<script type="text/javascript">
var index = 1;

$(function(){

	init();

  $('.form-settings').unbind('submit').on('submit', function(e){
    e.preventDefault();
    var form = $(this);
    var btn = form.find('button[type="submit"]');

    form.ajaxSubmit({
      beforeSubmit: function(){
        $('#ajax-response').html("");
        btn.button('loading');
      },
      type: 'post',
      dataType: 'json',
      timeout: 10000,
      success: function(rs){
        if(rs.status == 1){
          $("#modal-global").modal("hide");
          $('#ajax-response').append('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
          
          $('#modal-body').html("");
          setTimeout(function(){
            window.location.href="<?php echo site_url("generator");?>";
          },1000);
        }else{
          $('#ajax-response').append('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
        }
        btn.button('reset');
      },
      error: function(){

      }
    });

  });

  $("#btnDuplicate").on("click", function(e){
    e.preventDefault();

    $("#container-duplication").append(getTemplate(index));
    index++;

    init();
  });

});

function init(){
  $("#all-checkbox").on('ifChecked', function(e){
    $(".each-checkbox").iCheck('check');
  });

  $("#all-checkbox").on('ifUnchecked', function(e){
    $(".each-checkbox").iCheck('uncheck');
  });

  $('.input-selecter,.input-selecter-2,.input-selecter-3').selecter().selecter("refresh");

  $('.input-selecter-short').selecter({customClass:"margin-top"});

  $('#all-checkbox,.each-checkbox, .icheck').iCheck({
      checkboxClass: 'icheckbox_flat icheckbox_flat_custom',
      increaseArea: '20%'
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(".thumb-check").on('ifChecked', function(e){
    var checkbox = $(this);
    
    var parent = checkbox.parents('div#image');
    parent.find('#image-thumb').removeClass('hide');

    var status = parent.find(".crop-check").is(":checked");
    if(status){
      parent.find('#image-crop').addClass('hide');
    }
  });
  $(".thumb-check").on('ifUnchecked', function(e){
    var checkbox = $(this);
    
    var parent = checkbox.parents('div');
    parent.find('#image-thumb').addClass('hide');

    var status = parent.find(".crop-check").is(":checked");
    if(status){
      parent.find('#image-crop').removeClass('hide');
    }
  });

  $(".crop-check").on('ifChecked', function(e){
    var checkbox = $(this);
    
    var parent = checkbox.parents('div#image');

    var status = parent.find(".thumb-check").is(":checked");
    if(!status){
      parent.find('#image-crop').removeClass('hide');
    }
  });
  $(".crop-check").on('ifUnchecked', function(e){
    var checkbox = $(this);
    
    var parent = checkbox.parents('div');
    parent.find('#image-crop').addClass('hide');
  });

  $('.input-selecter').unbind('change').on('change', function(){
    var select = $(this);
    var value = select.val();

    var parent = select.parents('td');
    var divBelongsTo = parent.find('#belongsto');
    var divImage = parent.find('#image');
    var divFileType = parent.find('#filetype');
    var textSettings = parent.find("#textSettings");
    var divRandom = parent.find("#random");

    if(value == 'text' || value == 'email' || value == 'number'){
      textSettings.removeClass('hide');
    }else{
      textSettings.addClass('hide');
    }

    if(value == 'select' || value == 'radio'){
      divBelongsTo.removeClass('hide');
    }else{
      divBelongsTo.addClass('hide');
    }

    if(value == 'image'){
      divFileType.find("input").val("gif|jpg|png");
      
      divFileType.removeClass('hide');
      divImage.removeClass('hide');
    }else{
      divImage.addClass('hide');
      divFileType.addClass('hide');
    }

    if(value == 'file' || value == 'image'){
      divFileType.removeClass('hide');
    }else{
      divFileType.addClass('hide');
    }

    if(value == 'file'){
      divFileType.find("input").val("*");
    }

    if(value == 'random'){
      divRandom.removeClass("hide");
    }else{
      divRandom.addClass("hide");
    }

  });

  $('.input-selecter-3').on('change', function(){
    var select = $(this);
    var value = select.val();

    var parent = select.parents('td');
    var divBelongsTo = parent.find('#belongsto');

    var option = select.find("option:selected");
    var primary = option.attr("data-primary");
    var properties = option.attr("data-properties");

    var arrProperties = properties.split(",");

    var opt = '<option value="">Choose Field as Option Label...</option>';

    divBelongsTo.find(".fk-id").val(primary);

    for(var i=0; i<arrProperties.length ; i++){
      opt += '<option value="'+arrProperties[i]+'">'+arrProperties[i]+'</option>';
    }

    divBelongsTo.find(".input-selecter-2").html(opt);
    divBelongsTo.find(".input-selecter-2").selecter("refresh").selecter("update");;
  });
  
  $(".btn-delete").unbind("click").on("click", function(e){
    e.preventDefault();

    var parent = $(this).parent("td").parent("tr");
    parent.remove();
  });

}

function getTemplate(index){
  var htmlTemplate = 
      '<tr>'+
        '<td>'+
          '<input class="form-control" name="Field['+index+'][name]" placeholder="Field name... " style="width:200px">'+
        '</td>'+

        '<td>'+
          '<select name="Field['+index+'][type]" class="input-selecter">'+
            '<optgroup label="Common">'+
              '<option value="text">Textbox</option>'+
              '<option value="number">Number</option>'+
              '<option value="password">Password</option>'+
              '<option value="email">Email</option>'+
              '<option value="date">Date</option>'+
              '<option value="textarea">Textarea</option>'+
              '<option value="ckeditor">CKEditor</option>'+
              '<option value="jqueryte">jQueryTe</option>'+
              '<option value="image">Image</option>'+
              '<option value="thumb">Thumbnail</option>'+
              '<option value="file">File</option></optgroup>'+
            '<optgroup label="Belongs To">'+
              '<option value="select">Select</option>'+
              '<option value="radio">Radio</option>'+
            '</optgroup>'+
            '<optgroup label="Other">'+
              '<option value="random">Random Value</option>'+
            '</optgroup>'+
          '</select>'+

          '<div id="textSettings" class="clearfix">'+
            '<input class="form-control pull-left" name="Field['+index+'][min_length]" placeholder="Min.length" style="width:100px;margin:5px 5px 0 0;" data-toggle="tooltip" title="Min.length">'+
            '<input class="form-control pull-left" name="Field['+index+'][max_length]" placeholder="Max.length" style="width:100px;margin:5px 5px 0 0;" data-toggle="tooltip" title="Max.length" value="255">'+
          '</div>'+

          '<div id="belongsto" class="hide" style="margin-top:6px;">'+
            '<select name="Field['+index+'][fk][model]" class="input-selecter-3">'+
              '<option value="">Choose Model Name</option>'+
              '<?php foreach($listModel as $eachModel):?>'+
                '<option value="<?php echo $eachModel['model'];?>" data-primary="<?php echo $eachModel['primary'];?>" data-properties="<?php echo $eachModel['properties'];?>"><?php echo $eachModel['model'];?></option>'+
              '<?php endforeach;?>'+
            '</select>'+
            '<input type="text" class="form-control fk-id" name="Field['+index+'][fk][id]" value="" placeholder="Model\'s Primary Key..." style="margin-top:6px;" data-toggle="tooltip" title="Model\'s Primary Key" readonly>'+
            
            '<select name="Field['+index+'][fk][label]" class="input-selecter-2">'+
              '<option value="">Choose Field as Option Label...</option>'+
            '</select>'+
          '</div>'+

          '<div id="image" class="hide">'+
            '<div class="checkbox" style="margin-top:6px;">'+
              '<input type="checkbox" class="icheck thumb-check" value="1" name="Field['+index+'][image][is_thumb]">'+
              '<label>Create thumb</label>'+
            '</div>'+

            '<div id="image-thumb" class="hide">'+
              '<input type="text" class="form-control" name="Field['+index+'][image][thumb]" value="" placeholder="Column to store thumb image..." style="margin-top:6px;">'+
              '<div class="clearfix" style="margin-top:6px;">'+
                '<input type="text" class="form-control pull-left" name="Field['+index+'][image][width]" placeholder="Width" style="width:40%;margin-right:6px;">'+
                '<input type="text" class="form-control pull-left" name="Field['+index+'][image][height]" placeholder="Height" style="width:40%">'+
              '</div>'+
            '</div>'+

            '<div class="checkbox" style="margin-top:6px;">'+
              '<input type="checkbox" class="icheck crop-check" value="1" name="Field['+index+'][image][is_crop]">'+
              '<label>Crop</label>'+
            '</div>'+

            '<div id="image-crop" class="clearfix hide">'+
              '<input type="text" class="form-control pull-left" name="Field['+index+'][image][scale_width]" placeholder="Scale width" style="width:40%;margin-right:6px;">'+
              '<input type="text" class="form-control pull-left" name="Field['+index+'][image][scale_height]" placeholder="Scale height" style="width:40%">'+
            '</div>'+
          '</div>'+

          '<div id="filetype" class="hide">'+
            '<input type="text" class="form-control" name="Field['+index+'][filetype]" value="" placeholder="File type... ex: png,zip,pdf" style="margin-top:6px;" data-toggle="tooltip" title="File type">'+
          '</div>'+

          '<div id="random" class="hide clearfix">'+
            '<input class="form-control pull-left" name="Field['+index+'][random][length]" placeholder="Length..." style="width:100px;margin:5px 5px 0 0;" data-toggle="tooltip" title="Length" value="10">'+
            '<select name="Field['+index+'][random][type]" class="input-selecter-short">'+
              '<option value="">Type</option>'+
              '<option value="string">String</option>'+
              '<option value="numeric">Numeric</option>'+
            '</select>'+
          '</div>'+

        '</td>'+
        
        '<td align="right">'+
          '<div class="checkbox">'+
            '<input type="checkbox" class="each-checkbox" name="Field['+index+'][show]" value="1" checked>'+
          '</div>'+
        '</td>'+

        '<td>'+
          '<button class="btn btn-sm btn-danger btn-delete" type="button">'+
            '<span class="glyphicon glyphicon-remove"></span>'+
          '</button>'+
        '</td>'+
      '</tr>';
  return htmlTemplate;
}
</script>