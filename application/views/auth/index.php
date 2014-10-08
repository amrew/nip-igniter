<div class="container">
	<form id="form-main" class="form-submit" role="form" action="<?php echo site_url($controller.'/login');?>">
		<div class="form-generator">
			<h3 class="logo">Sign In</h3>
			
			<div id="ajax-response">
				<?php
					$message = $this->session->flashdata('message');
					if(!empty($message)):
				?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>

						<?php echo $message;?>
					</div>
				<?php endif;?>
			</div>

			<input type="text" class="form-control input-custom" id="inputUserkey" name="userkey" placeholder="Username or Email..." required autofocus>
			<input type="password" class="form-control input-custom" id="inputPassword" name="password" placeholder="Password" required>
		    
		    <div class="clearfix" style="margin-top:24px;">			
	            <button id="btnGenerate" class="btn-dark pull-left" type="submit" data-loading-text="Please wait...">Login</button> 
	        	<span class="pull-right">
	        		<a href="<?php echo site_url("auth/forgot");?>">Forgot Password</a>
	        	</span>
	        </div>

	        <!--Remove this when your web on production mode-->
	        <?php if(!$this->db->table_exists("user")):?>
	        	<br><button id="btnInstall" class="btn-dark-green btn-full" type="submit" data-loading-text="Please wait...">Install example user data</button> 
	        	<script type="text/javascript">$("#btnGenerate").attr("disabled","true");</script>
	        <?php endif;?>
	        <!--//Remove this when your web on production mode-->

	        <div class="trigger">
		        <span class="glyphicon glyphicon-log-in" style="font-size:48px;"></span>
		    </div>

        </div>
	</form>
</div>

<!--Remove this when your web on production mode-->
<div class="modal fade" id="modal-install" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content" style="border-radius:0;text-align:center">
			<!--Modal Header-->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Hey, you!</h4>
			</div>
			<!--Modal Body-->
			<div class="modal-body" id="modal-body">
				<form class="form-install" action="<?php echo site_url("auth/install-example-user");?>" method="post">
					<input type="hidden" id="inputTableName" name="is_install" value="yes">
					<p>I will import some table for you</p>
					<button class="btn-dark" type="submit">Yes, please.</button>
				</form>
			</div>
			<!--Modal Footer-->
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<!--//Remove this when your web on production mode-->

<script type="text/javascript">
$(function(){
	var docHeight = $(document).height();
    var formHeight = $(".form-generator").height();
    
    $(".form-generator").css("margin-top",(docHeight - formHeight - 90)/3);

    $('[data-toggle="tooltip"]').tooltip();

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
					
					$('#ajax-response').append('<div class="alert alert-'+rs.param+'"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
					
					if(typeof(rs.callback) !== "undefined"){
						window.location.href=rs.callback;
					}
				}else{
					$('#ajax-response').append('<div class="alert alert-'+rs.param+'"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> '+rs.message+'</div>');
				}
				btn.button('reset');
			},
			error: function(){
				swal("Failed", "I think there is some error here. :(", "error");
			}
		});

	});
	
	/** Remove this when your web on production mode*/
	$("#btnInstall").on("click", function(e){
		e.preventDefault();		
		$("#modal-install").modal("show");
	});

	$(".form-install").on("submit", function(e){
		e.preventDefault();

		var form = $(this);
		var btn = form.find('button[type="submit"]');

		form.ajaxSubmit({
			beforeSubmit: function(){
				btn.button('loading');
			},
			type: 'post',
			dataType: 'json',
			timeout: 10000,
			success : function(rs){
				$("#modal-install").modal("hide");

				if(rs.status == 1){
					swal("Good job!", "Example user : username:admin || password:admin123", "success");
					$("#btnGenerate").removeAttr("disabled");
					$("#btnInstall").fadeOut();
				}else{
					swal("Failed", "I think there is some error here. :(", "error");
				}
			},
			error : function(){
				$("#modal-install").modal("hide");
				swal("Failed", "I think there is some error here. :(", "error");
			}
		});
	});
	/** //Remove this when your web on production mode*/

});
</script>