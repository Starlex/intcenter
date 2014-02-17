// focus on login input in authorization form
$(document).ready(function(){
	$('#login').focus();
});

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

// function for zebra table style (IE8 чтоб ты сдох!!)
$(document).ready(function(){
	$('table tr:nth-of-type(2n)').css('background-color', '#fff');
});

// function for showing add/update/delete form
$(document).ready(function(){
	$('.radio input[type="radio"]').click(function(){
		if(this.checked){
			var formID = '#'+this.id+'Form';
			$(formID).slideDown().siblings('form').hide();
		}
	});
});

// using ajax to get data from DB for updating content
$(document).ready(function(){
	$('.selectContent').change(function(){
		var id = $(this).children('option:selected').val();
		if('' === id){
			$(this).parent('label').siblings().children('textarea').val('');
			$(this).parent('label').siblings().children('input[type="text"]').val('');
			$(this).parent('label').siblings().children('select').prop('selectedIndex', 0);
			$(this).parent('label').siblings().children('input[type="checkbox"]').removeAttr('checked');
		}
		var type = $(this).data('type');
		$.ajax({
			type: 'POST',
			url: '/pages/ajax.php',
			data: 'id='+id+'&type='+type,
			dataType: 'json',
			success: function(data){
				switch(data.formID){
					case '#updatePageForm':
						CKEDITOR.instances[data.tareaName].setData(data.content);
						break;
					case '#updateNewsForm':
						$(data.formID+' textarea[name="title"]').val(data.name);
						if(1 === parseInt(data.isSummer)){
							$(data.formID+' input[name="isSummer"]').attr('checked', 'checked');
						}
						$(data.formID+' textarea[name="annotation"]').val(data.annotation);
						CKEDITOR.instances[data.tareaName].setData(data.content);
						break;
					case '#updateProgramForm':
						$(data.formID+' select[name="prog_cat_id"] option').each(function(){
							if( this.value === data.cat_id ){
								$(this).attr('selected', 'selected');
							}
						});
						$(data.formID+' input[name="target_audience"]').val(data.target_audience);
						$(data.formID+' textarea[name="title"]').val(data.name);
						CKEDITOR.instances[data.tareaName].setData(data.content);
						break;
					default:
						console.log('Ух-ох. Что-то пошло не так.');
						break;
				}
			},
			error: function(obj, err){
				console.log(obj.status+' '+err);
			}
		})
	return false;
	});
});









// this function used in updating pages.
// It fills name of page and page content accourdingly to selected page.
/*$(document).ready(function(){
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
});*/