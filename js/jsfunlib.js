// Show prog-submenu on click
$(document).ready(function(){
	$('.prog-menu>ul>li').click(function(){
		var img = $(this).children('span').children('img');
		var ul = $(this).children('ul');
		if('none' === ul.css('display')){
			img.attr('src', '../../../../img/arrow_down.png');
			ul.slideDown();
		}
		else{
			img.attr('src', '../../../../img/arrow_right.png');
			ul.slideUp();
		}
	});
});

// function for up button
$(document).ready(function(){
	$(window).scroll(function(){
		if($(window).scrollTop() < 50){
			$('.up-btn').fadeOut();
		}
		else{
			$('.up-btn').fadeIn();
		}
	});
	$('.up-btn').click(function(){
		$('html').scrollTo(0, 800, {queue:true});
	});
});

// function for zebra table style (IE8 штоб ты сдох!!)
$(document).ready(function(){
	$('table tr:nth-of-type(2n)').css('background-color', '#fff');
});

function showDiv(chb1, div, chb2, form){
	var cke = $('.ckeditor').attr('name');
	if('checked' === $(chb1).attr('checked')){
		$(div).fadeIn();
		$('#btn_div').fadeIn();		
		$(chb2).attr('disabled', 'disable');
	}
	else{
		$(div).fadeOut();
		$('#btn_div').fadeOut();		
		$(chb2).removeAttr('disabled');
	}
}

// function for showing add form
$(document).ready(function(){
	$('input[type="radio"]').click(function(){
		if(this.checked){
			$('#addNewsForm').fadeIn();
		}
		else{
			$('#addNewsForm').fadeOut();
		}
	});
	console.log($('#addNews').checked);
});

// this function used in updating pages.
// It fills name of page and page content accourdingly to selected page.
$(document).ready(function(){
	$('#updPageId').change(function(){
		$.ajax({
			type: "POST",
			url: "/pages/ajax.php",
			data: "page_id="+$("#updPageId").val(),
			dataType: "json",
			success: function(data){
				if(false === data){
					$("#pagedata").fadeOut();
					$("#pName").val("");
					CKEDITOR.instances.pContent.setData("");
				}
				else{
					$("#pagedata").fadeIn();
					$("#pName").val(data.name);
					CKEDITOR.instances.pContent.setData(data.page_content);                        
				}
			}
		});
	return false;
	});
});

// this function used in updating subpages.
// It fills name of parrent page, subpage and subpage content accourdingly to selected page.
$(document).ready(function(){
	$('#updSubpageId').change(function(){
		$.ajax({
			type: "POST",
			url: "/pages/ajax.php",
			data: "subpage_id="+$("#updSubpageId").val(),
			dataType: "json",
			success: function(data){
				if(false === data){
					$("#subpagedata").fadeOut();
					$("#parrentId").val("");
					$("#spName").val("");
					CKEDITOR.instances.spContent.setData("");
				}
				else{
					$("#subpagedata").fadeIn();
					$("#parrentId").val(data.page_id);
					$("#spName").val(data.name);
					CKEDITOR.instances.spContent.setData(data.page_content);
				}
			}
		});
	return false;
	});
});
