<div class="container">
	<form id="form-main" class="form-submit" role="form" action="<?php echo site_url($controller.'/get-settings');?>">
		<div class="form-generator">
			<h3 class="logo">Nip Igniter</h3>
			
			<div id="ajax-response"></div>

			<input type="text" class="form-control input-custom" id="inputTableName" name="table_name" placeholder="Table Name..." required autofocus>
		    
		    <div class="checkbox">
            	<input type="checkbox" class="icheck-dark" id="checkIsCrud" name="is_crud" checked>
            	<label for="checkIsCrud">Generate CRUD</label>
            </div>

            <div class="clearfix">
	            <button id="btnGenerate" class="btn-dark pull-left" type="submit" data-loading-text="Please wait...">Generate</button> 
	            <span class="or pull-left">or</span>
	            <button data-url="<?php echo site_url($controller.'/get-create');?>" id="btnCreateTable" class="btn-dark-green pull-right" type="button" data-loading-text="Please wait...">Create Table</button>
	        </div>

	        <div class="trigger">
		        <a href="#" id="trigger-settings" data-toggle="tooltip" data-placement="right" title="Settings">
		        	<img src="<?php echo base_url();?>public/img/settings-icon.png">
		        </a>
	    	</div>

	        <div class="settings well">
	        	<div class="content-settings">
		        	<div class="checkbox">
		            	<input type="checkbox" class="icheck-dark" name="is_timestamps" id="checkIsTimestamps" checked>
		            	<label for="checkIsTimestamps">Timestamps</label>
		            </div>
		            <div class="form-group">
		            	<input class="form-control" name="created_field" id="inputCreatedField" placeholder="'created' field" value="created" data-toggle="tooltip" data-placement="right" title="Timestamps field for 'created at'">
		            	<input class="form-control" name="updated_field" id="inputUpdatedField" placeholder="'updated' field" value="updated" data-toggle="tooltip" data-placement="right" title="Timestamps field for 'updated at'">
		            	<input class="form-control" name="deleted_field" id="inputDeletedField" placeholder="'deleted' field" value="deleted" data-toggle="tooltip" data-placement="right" title="Timestamps field for 'deleted at'">
		            </div>
		            <div class="checkbox">
		            	<input type="checkbox" class="icheck-dark"  name="is_softdelete" id="checkIsSoftDelete" checked>
		            	<label for="checkIsSoftDelete">SoftDelete</label>
		            </div>
		        </div>
	        </div>

        </div>
	</form>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-global" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" style="border-radius:0">
			<!--Modal Header-->
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
				<h4 class="modal-title" id="myModalLabel">Specific Configuration</h4>
			</div>
			<!--Modal Body-->
			<div class="modal-body" id="modal-body"></div>
			<!--Modal Footer-->
			<div class="modal-footer"></div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(function(){
	var docHeight = $(document).height();
    var formHeight = $(".form-generator").height();
    
    $(".form-generator").css("margin-top",(docHeight - formHeight - 90)/3);

    $('[data-toggle="tooltip"]').tooltip();

    $('.icheck-dark').iCheck({
      checkboxClass: 'icheckbox_flat icheckbox_flat_custom',
    });
	
	$(".settings").hide();

	$('.form-submit').unbind('submit').on('submit', function(e){
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
					$('#modal-body').html(rs.view);
					$(".selecter_1").selecter("refresh");
					$("#modal-global").modal("show");
				}else{
					$('#ajax-response').append('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
				}
				btn.button('reset');
			},
			error: function(){

			}
		});

	});

	$("#trigger-settings").on("click", function(e){
		e.preventDefault();
		$(".settings").slideToggle();
	});

	$("#btnCreateTable").on("click", function(e){
		e.preventDefault();
		var btn = $(this);
		var url = btn.attr("data-url");

		var mainInput = $("#inputTableName");
		var tableName = mainInput.val();

		if(tableName == ""){
			$('#ajax-response').append('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> The table name is required</div>');
			return;
		}

		var serialize = $("#form-main").serialize();
		
		$.ajax({
			beforeSend: function(){
				$('#ajax-response').html("");
				btn.button('loading');
			},
			url: url,
			type: 'post',
			dataType: 'json',
			data: serialize,
			timeout: 10000,
			success: function(rs){
				if(rs.status == 1){
					$('#modal-body').html(rs.view);
					$(".selecter_1").selecter("refresh");
					$("#modal-global").modal("show");
				}else{
					$('#ajax-response').append('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
				}
				btn.button('reset');
			},
			error: function(){

			}
		});
	});

	$.get('<?php echo site_url("generator/get-table-list");?>', function(data){
	    $("#inputTableName").typeahead({ source:data });
	},'json');

});
</script>