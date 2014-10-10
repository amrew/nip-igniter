<div class="container">
	<form id="form-main" class="form-submit" role="form" action="<?php echo site_url($controller.'/get-settings');?>">
		<div class="form-generator">
			<h3 class="logo">Table list</h3>
			
			<div id="ajax-response"></div>

			<ul class="list-group">
				<?php foreach($tableList as $i => $value):?>
					<li class="list-group-item">
						<strong style="margin-right:14px;"><?php echo $i+1;?>. </strong>
						<a href="<?php echo site_url(str_replace("_", "-", $value));?>" style="color:#333;"><?php echo $value;?></a>
						<a href="#" class="btn btn-danger btn-xs btn-delete pull-right" data-name="<?php echo $value;?>" data-toggle="tooltip" data-placement="right" title="Delete this table">
							<span class="glyphicon glyphicon-remove"></span>
						</a>
					</li>
				<?php endforeach;?>
			</ul>

			<div class="trigger">
		        <span class="glyphicon glyphicon-list-alt" style="font-size:48px;"></span>
		    </div>
        </div>
	</form>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-global" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="border-radius:0">
			<!--Modal Header-->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Delete <span id="labelTableName" style="color:#da4453"></span> table</h4>
			</div>
			<!--Modal Body-->
			<div class="modal-body" id="modal-body">
				<form class="form-submit" action="<?php echo site_url("generator/delete-table");?>" method="post">
					<input type="hidden" class="inputTableName" name="table_name" value="">
					<input type="hidden" name="mode" value="only-crud">
					<p>Please choose this!</p>
					<div class="text-center">
						<button class="btn btn-warning btn-block" type="submit">Delete CRUD</button>
						<div style="height:10px;"></div>
						
					</div>
				</form>
				<form class="form-submit" action="<?php echo site_url("generator/delete-table");?>" method="post">
					<input type="hidden" class="inputTableName" name="table_name" value="">
					<input type="hidden" name="mode" value="table-crud">
					<div class="text-center">
						<button class="btn btn-danger btn-block" type="submit">Delete Table and CRUD</button>
					</div>
				</form>
				
			</div>
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

	$(".btn-delete").on("click", function(){
		var name = $(this).attr("data-name");
		$(".inputTableName").val(name);
		$("#labelTableName").html(name);

		$("#modal-global").modal("show");
	});

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
					$('#ajax-response').append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
					setTimeout(function(){ window.location.href="<?php echo current_url();?>"},1000);
				}else{
					$('#ajax-response').append('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
				}

				$("#modal-global").modal("hide");
				btn.button('reset');
			},
			error: function(){
				$('#ajax-response').append('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> Application Error</div>');
			}
		});

	});

});
</script>