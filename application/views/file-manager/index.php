<!-- BEGIN PAGE BREADCRUMB -->
<ul class="page-breadcrumb breadcrumb">
  <li>
    <a href="<?php echo site_url("admin/dashboard");?>">Home</a>
    <i class="fa fa-circle"></i>
  </li>
  <li>
    File manager
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
            File Manager
          </span>
        </div>
        <div class="tools">
          <a href="" class="collapse" data-original-title="" title="">
          </a>
        </div>
      </div>
      <div class="portlet-body form" id="main-content">        
        <div class="form-body">
          <iframe src="<?php echo site_url('file-manager?getpartial=true');?>" style="width:100%;height:430px;border:none"></iframe>
        </div>
      </div>
    </div>

  </div>
</div>