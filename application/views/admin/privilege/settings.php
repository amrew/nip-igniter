<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb hidden-print">
	<li>
		<a href="<?php echo site_url("admin/dashboard");?>">Home</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="#">Master Data</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		Privilege Settings
	</li>
</ul>

<div id="ajax-message" class="alert alert-info hide"></div>

<!-- END PAGE BREADCRUMB -->
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
	      <div class="portlet-title">
	        <div class="caption">
	          <span class="caption-subject font-green-sharp bold uppercase">
	          	Privilege Settings
	          </span>
	        </div>
	        <div class="tools">
	          <a href="" class="collapse" data-original-title="" title="">
	          </a>
	        </div>
	      </div>
	      <div class="portlet-body form" id="main-content">
	      	<div class="form-body">
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
						<button type="submit" class="btn btn-info btn-circle">Save</button>
					</div>

				</form>
	      	</div>
	      </div>

	</div>
</div>

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