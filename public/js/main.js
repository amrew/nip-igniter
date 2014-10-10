var currentController;
var currentUrl;
var baseUrl;

$(function(){
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
	});

	$("#btn-print").on('click', function(e){
		e.preventDefault();
		window.print();
	});

	$('.input-selecter').selecter();

	$('#select-limit').selecter({
		customClass : 'custom-selecter pull-right hidden-print',
		callback: selectCallback
	});

	$(".btn-random").on("click", function(e){
		e.preventDefault();
		var type 	 = $(this).attr("data-type");
		var length 	 = $(this).attr("data-length");
		var targetId = $(this).attr("data-target");

		var target   = $(targetId);

		var string   = "";
		if(type == "numeric"){
			string = getRandomNumeric(parseInt(length));
		} else {
			string   = getRandomString(parseInt(length));
		}

		target.val(string);
	});

	searching();
	
	sorting();

	aboutTrash();

	init();

	hideLoading();
});

function init(){
	$('.icheck').iCheck({
      checkboxClass: 'icheckbox_flat',
    });

    $("#all-checkbox").on('ifChecked', function(e){
		$(".each-checkbox").iCheck('check');
	//	$("#actionDiv").removeClass('hide');
	});
	$("#all-checkbox").on('ifUnchecked', function(e){
		$(".each-checkbox").iCheck('uncheck');
	//	$("#actionDiv").addClass('hide');
	});

	pagination();
	
	showModal();
	
	buttonAction();
}

function selectCallback(value, index){
	window.location.href=value;
}
function showLoading(){
	$("#loading").show();
}

function hideLoading(){
	$("#loading").hide();
}

function pagination(){
	$("#page-container .pagination li a").unbind('click').on('click', function(event) {
		event.preventDefault();
		var currentLink = $(this);

		if(currentLink.attr('href')==undefined)
			return;
		
		$.ajax({
			beforeSend: function(){
				showLoading();
			},
			url: currentLink.attr('href'),
			type: 'post',
			dataType: 'json',
			success : function(rs){
				$("#table-body").html(rs.view);
				$("#page-container").html(rs.pagination);
				window.history.pushState({}, 'Pagination',currentLink.attr('href'));

				hideLoading();
				init();
			}
		}).fail(function(data, status){
			if(status == "error"){
				setErrorMessage("Application error...","danger");
			}else if(status == "timeout"){
				setErrorMessage("Connection timeout","warning");
			}else if(status == "parsererror"){
				setErrorMessage("Parse Error","warning");
			}

			hideLoading();
		});
		
	});
}

function sorting(){
	$(".sorting").unbind('click').on('click', function(e){
		e.preventDefault();

		var currentA = $(this);
		var field = currentA.attr('data-field');
		var direction = currentA.attr('data-direction');

		$('.sorting').attr('data-direction','asc');
		$('.sorting span').removeClass().addClass('glyphicon glyphicon-sort');

		if(direction == 'asc'){
			currentA.attr('data-direction','desc');
			currentA.find('span').removeClass().addClass("glyphicon glyphicon-sort-by-alphabet");
		}else{
			currentA.attr('data-direction','asc');
			currentA.find('span').removeClass().addClass("glyphicon glyphicon-sort-by-alphabet-alt");
		}

		var newParam = 'sorting='+field+'&direction='+direction;
		if(tempKeywords == '' || tempKeywords == '?search=true'){
			newParam = '?'+newParam;
		}else{
			newParam = tempKeywords+'&'+newParam;
		}
		
		$.ajax({
			beforeSend: function(){
				showLoading();
			},
			url: currentUrl + newParam,
			type: 'post',
			dataType: 'json',
			success : function(rs){
				$("#table-body").html(rs.view);
				$("#page-container").html(rs.pagination);
				window.history.pushState({}, 'Pagination', currentUrl + newParam);

				hideLoading();
				init();
			}
		}).fail(function(data, status){
			if(status == "error"){
				setErrorMessage("Application error...","danger");
			}else if(status == "timeout"){
				setErrorMessage("Connection timeout","warning");
			}else if(status == "parsererror"){
				setErrorMessage("Parse Error","warning");
			}

			hideLoading();
		});
	});
}

var tempKeywords = "";
function actionSearch(type){
	var inputSearchs = $(".input-search");
	var keywords = "?search=true";

	inputSearchs.each(function(index){
		var input = $(this);
		var name = input.attr("name");
		var value = input.val();
		if(value != ""){
			keywords += "&keywords["+name+"]="+value;
		}
	});

	var globalValue = $(".input-global-search").val();
	if(globalValue != ""){
		keywords += "&keyword="+globalValue;
	}

	if(keywords == tempKeywords){
		return;
	}
	
	tempKeywords = keywords;
	
	if(type=="input"){
		if(keywords == "?search=true"){
			return;
		}
	}

	$.ajax({
		beforeSend: function(){
			showLoading();
		},
		url: currentUrl + keywords,
		dataType : 'json',
		success : function(rs){
			$("#table-body").html(rs.view);
			$("#page-container").html(rs.pagination);
			$('#loading').addClass('hide');
			window.history.pushState({}, 'Pagination', currentUrl + keywords);

			hideLoading();
			init();
		}
	}).fail(function(data, status){
		if(status == "error"){
			setErrorMessage("Application error...","danger");
		}else if(status == "timeout"){
			setErrorMessage("Connection timeout","warning");
		}else if(status == "parsererror"){
			setErrorMessage("Parse Error","warning");
		}

		hideLoading();
	});
}

function searching(){
	
	$('input.input-search, .input-global-search').typing({
	    start: function (event, $elem) {
	    
	    },
	    stop: function (event, $elem) {
	        actionSearch("select");
	    },
	    delay: 300
	});

	$("input.input-search, .input-global-search").on('blur', function(event) {
		actionSearch("input");
	});

	$("select.input-search").unbind('change').on('change', function(event) {
		actionSearch("select");
	});
}

function setErrorMessage(message, type){

	if(type == "warning"){
		swal("Owh shit!", message, "warning");
		//$("#error-message").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+message+'</div>').find(".alert").addClass("animated fadeInDown");
	}else if(type == "danger"){
		swal("Oh My God!", message, "error");		
		//$("#error-message").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+message+'</div>').find(".alert").addClass("animated fadeInDown");
	}else if(type == "success"){
		swal("Wow, Good job!", message, "success");
		//$("#error-message").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+message+'</div>').find(".alert").addClass("animated fadeInDown");
	}else if(type == "info"){
		swal("Attention, please.", message, "info");
		//$("#error-message").html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+message+'</div>').find(".alert").addClass("animated fadeInDown");
	}else if(type == "no-privilege"){
		swal("Sorry :(", message, "warning");
		//$("#error-message").html('<div class="alert alert-default"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+message+'</div>').find(".alert").addClass("animated fadeInDown");
	}
}

function showModal(){
	$(".show-modal").unbind('click').on('click', function(event) {
		event.preventDefault();		
		var currentBtn = $(this);
		
		$.ajax({
			beforeSend: function(){
				showLoading();
			},
			url: currentBtn.attr("href"),
			type: 'post',
			success : function(content, status, xhr){
				var json = null;
				var is_json = true;

		    	try {
		    		json = $.parseJSON(content);
		        } catch(err) {
		        	is_json = false;
		        }

				if(is_json == false){
					$("#modal-body").html(content);
					$("#modal-global").modal('show');
				}else{
					setErrorMessage(json.message,"no-privilege");
				}
				
				hideLoading();
			}
		}).fail(function(data, status){
			if(status == "error"){
				setErrorMessage("Application error...","danger");
			}else if(status == "timeout"){
				setErrorMessage("Connection timeout","warning");
			}else if(status == "parsererror"){
				setErrorMessage("Parse Error","warning");
			}

			hideLoading();
		});
		
	});
}

function buttonAction(){
	$(".btn-action").unbind('click').on('click', function(event) {
		event.preventDefault();
		var currentBtn = $(this);
		
		$.ajax({
			beforeSend: function(){
				showLoading();
			},
			url: currentBtn.attr('data-url'),
			dataType : "json",
			type: 'post',
			data: {id: currentBtn.attr('data-id')},
			success : function(rs){
				if(rs.status == 404){
					setErrorMessage(rs.message,"no-privilege");
				}else{
					$("#ajax-message").html('<div class="alert alert-'+rs.param+'"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'+rs.message+'</div>');
					
					if(rs.operation != null){
						if(rs.operation == 'delete'){
							$("#tr-"+currentBtn.data('id')).hide();
						}else if(rs.operation == 'restore'){
							$("#tr-"+currentBtn.data('id')).show();
						}
					}
				}

				hideLoading();
				buttonAction();
			}
		}).fail(function(data, status){
			if(status == "error"){
				setErrorMessage("Application error...","danger");
			}else if(status == "timeout"){
				setErrorMessage("Connection timeout","warning");
			}else if(status == "parsererror"){
				setErrorMessage("Parse Error","warning");
			}

			hideLoading();
		});
	});
}

function aboutTrash(){
	
	$(".btnAboutTrash").unbind("click").on("click", function(e){
		e.preventDefault();
		var link = $(this).attr("href");

		var checkbox = $(".each-checkbox:checked");
		
		var string = '';
		var index = 0;
		var primaries = [];

		checkbox.each(function(){
			if(index == 0){
				string += 'primary[]=' + $(this).val();
			}else{
				string += '&primary[]=' + $(this).val();
			}
			primaries.push($(this).val());

			index++;
		});

		if(string !== ''){

			$.ajax({
				beforeSend: function(){
					showLoading();
				},
				url: link,
				type: 'post',
				dataType: 'json',
				data : string,
				success : function(rs){
					if(rs.status == 404){
						setErrorMessage(rs.message,"no-privilege");
					}else{
						for(var i in primaries){
							$("#tr-"+primaries[i]).hide();
						}

						$("#ajax-message").html('<div class="alert alert-'+rs.param+'"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>'+rs.message+'</div>');
					}
					hideLoading();
					init();
				}
			}).fail(function(data, status){
				if(status == "error"){
					setErrorMessage("Application error...","danger");
				}else if(status == "timeout"){
					setErrorMessage("Connection timeout","warning");
				}else if(status == "parsererror"){
					setErrorMessage("Parse Error","warning");
				}

				hideLoading();
			});
		}
	});
}

function getRandomString(length) {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < length; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

function getRandomNumeric(length) {
    var text = "";
    var possible = "0123456789";

    for( var i=0; i < length; i++ ){
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}