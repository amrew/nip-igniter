<section class="content-header">
    <h1><?php echo $pageTitle;?></h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
        <!-- left column -->
        <div class="col-md-12">
        	<div class="box box-success">
                
                <div class="box-body">
                	<!--Show ajax message here-->
					<div id="ajax-message"></div>
					
					<form role="form" action="<?php echo current_url();?>" id="form-edit" method="post">
						<div class="form-group">
							<select class="form-control" name="role_id" id="selectRoleId" style="width:300px">
								<option value="">Pilih Role</option>
								<?php foreach($roles as $row):?>
									<option value="<?php echo $row->id;?>"><?php echo $row->title;?></option>
								<?php endforeach;?>
							</select>
						</div>

						<div id="role-settings"></div>

						<div>
							<button type="submit" class="btn btn-primary btn-large">Save</button>
						</div>

					</form>

                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
	$(function(){
		$("#selectRoleId").on("change", function(){
			var role_id = $(this).val();
			$.ajax({
				beforeSend : function(){
					showLoading();
				},
				type: "post",
				url : "<?php echo site_url($pathController.'/edit');?>",
				data : "role_id="+role_id,
				dataType : "html",
				success : function(result){
					$("#role-settings").html(result);

					$('.icheck').iCheck({
				      checkboxClass: 'icheckbox_flat',
				    });
				}, 
				error: function(){
					setErrorMessage("Application Error",'danger');
				}
			}).always(function(){
				hideLoading();
			});
		});

		submitForm();

		function submitForm(){
			$("#form-edit").on('submit', function(event) {
			  event.preventDefault();
			  var currentForm = $(this);
			  
			  currentForm.ajaxSubmit({
			  	beforeSend: function() {
				    showLoading();

				},
			    dataType: 'json',
			    success : function(rs){
			      if(rs.status == 1){
			      	notify(rs);
			        window.location.href = '<?php echo current_url();?>';
			      }else{
			      	notify(rs);
			      }
			      hideLoading();
			    },
			    error: function(){
			    	setErrorMessage("Application Error",'danger');
			    	hideLoading();
			    }
			  });
			  
			});
		}
	})
</script>