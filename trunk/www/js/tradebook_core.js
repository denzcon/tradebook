/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(
	function() {
		var pages_max		= 10;
		var siteBaseUrl		= 'http://xphero.me';
		var messageDelay	= 6000;
			
		$('#addwishitemManualAnchor').click(
			function()
			{
				$('#addwishitemManual').toggleClass('hide');
				$('#add_wish_item_manually').toggleClass('hide');
				$('form[name="addwishitemURL"]').toggleClass('hide');
				$('#addwishitemManualAnchor').toggleClass('hide');
				$('#addwishitemURLAnchor').toggleClass('hide');
				
			});
			
		$('#addwishitemSearchAnchor').click(
			function()
			{
				$('#addwishitemURL').toggleClass('hide');
				$('#addwishitemSearch').toggleClass('hide');
				$('#add_wish_item_manually').toggleClass('hide');
				$('form[name="addWishItemSearch"]').toggleClass('hide');
				$('#addwishitemManualAnchor').toggleClass('hide');
				$('#addwishitemURLAnchor').toggleClass('hide');
				$('#addwishitemSearchAnchor').toggleClass('hide');
				
			});
		$('#addwishitemURLAnchor').click(
			function()
			{
				$('#addwishitemManual').toggleClass('hide');
				$('#add_wish_item_manually').toggleClass('hide');
				$('form[name="addwishitemURL"]').toggleClass('hide');
				$('#addwishitemManualAnchor').toggleClass('hide');
				$('#addwishitemURLAnchor').toggleClass('hide');
				
			});
				
		$('#add_item_search_submit').click(
			function()
			{
				search();
			});
		$('#addWishItemSearch').submit(function(){
			search();
			return false;
		});
		
		function search()
		{
			if ( !$('#itemSearch').val() ) {
				$('#error_message').fadeIn().delay(messageDelay).fadeOut();
				return false;

			} else {		
				var data = 'itemSearch='+$('#itemSearch').val()+'&sort='+$("input[@name=optionsRadios]:checked").val();
				$.ajax( {
					url: "/user/searchWishAjax",
					type: 'post',
					data: data,
					success: searchFinished,
					dataType: "json"
				} );
				return false;
			}
		}
		$('#add_item_manually_submit').click(
			function()
			{
				if ( !$('#itemTitle').val() || !$('#itemPrice').val() || !$('#itemImage').val() || !$('#itemWorkTrade').val() ) {
					$('#error_message').fadeIn().delay(messageDelay).fadeOut();
					return false;

				} else {				
					$.ajax( {
						url: "/user/addWishAjax",
						type: 'POST',
						data: $('#addwishitemManual').serialize(),
						success: submitFinished
					} );
					return false;
				}
			});
			
		$('#add_item_URL_submit').click(
			function()
			{
				if ( !$('#wishURL').val() )
				{				  
					// No; display a warning message and return to the form
					$('#error_message').fadeIn().delay(messageDelay).fadeOut();
					return false;
				} 
				else 
				{				
					$.ajax( {
						url: "/user/addWishURLAjax",
						type: 'POST',
						data: $('#addwishitemURL').serialize(),
						success: submitFinishedURL
					} );
					return false;
				}
			});
			
		function submitFinishedURL( response ) 
		{
			response = $.trim( response );
			$('#add_item_URL_submit').fadeOut().delay(messageDelay).fadeIn();			  
		//			  $('#url_success_prompt').html(response);
		}
			
		function submitFinished( response ) 
		{
			response = $.trim( response );
			$('#add_item_manually_submit').fadeOut().delay(messageDelay).fadeIn();
			  
			if ( response == "success" ) {
				$('#success_message').fadeIn().delay(messageDelay).fadeOut();
				$('#itemTitle').val( "" );
				$('#itemPrice').val( "" );
				$('#itemDescription').val( "" );
				$('#itemImage').val( "" );
				$('#content').delay(messageDelay+500).fadeTo( 'slow', 1 );

			} else {
				// Form submission failed: Display the failure message,
				// then redisplay the form
				$('#failureMessage').fadeIn().delay(messageDelay).fadeOut();
				$('#contactForm').delay(messageDelay+500).fadeIn();
			}		
		}
			
		$('.loginLink').click(
			function()
			{
				$('#signupModal').hide();
				$('#loginModal').show();
				$('#userConnectModal').modal({
					keyboard: true,
					backdrop: true					
				})				
				return false;
			});
			
			
		$('form.login').submit(function(event)
		{
			event.preventDefault();
			if ( !$('#username').val() || !$('#password1').val())
			{
				$('#login-modal-error-message p').text('You have not completed the form');
				$('#login-modal-error-message').addClass('alert-error');
				$('#login-modal-error-message').addClass('alert');
				$('#login-modal-error-message').fadeIn();	
			} 
			else 
			{				
				$.ajax( {
					url: "/login/validate_credentials",
					type: 'POST',
					data: $('#loginModal form').serialize(),
					dataType: 'json',
					success: loginSuccess
				} );
					
			}				
		});
		$('#closeLoginModal').click(
			function()
			{
				$('#userConnectModal').modal('hide');
			})
		function loginSuccess( response ) 
		{
			console.log(response.is_logged_in);
			//			  response = $.trim( response );
			if(response.is_logged_in)
			{
				$('#userConnectModal').modal('hide');
				window.location.href = "/about";
			}
			else
			{
				$('#login-modal-error-message p').text('Your login information is incorrect. Please try again');
				$('#login-modal-error-message').addClass('alert-error');
				$('#login-modal-error-message').addClass('alert');
				$('#login-modal-error-message').show();
			}
		}	
			
		$('.signupLink').click(
			function()
			{
				$('#signupModal').fadeIn();
				$('#loginModal').hide();
				$('#userConnectModal').modal({
					keyboard: true,
					backdrop: true					
				})
				return false;
			});
		$('#closeRegistration').click(
			function()
			{
				$('#userConnectModal').modal('hide');
			});
			
		$('#userRegistration').click(
			function()
			{
				$('#signupForm').trigger('submit');
				return false;
			});
			
		function createUserResponse(response)
		{
				
			var $form = $('#signupForm');
			if(response['status']==false)
			{
				$.each(response['errors'],function(key,val)
				{
					var $input = $('input[name='+key+']',$form);
					var $container = $input.closest('div.clearfix');
					$container.addClass('error');
					$input.addClass('error').after($('<span>').addClass('help-inline').text(val));
					$('#signup-modal-error-message p').text(response['message']);
					$('#signup-modal-error-message').addClass('error');
					$('#signup-modal-error-message').fadeIn();
				});				
			}
			else
			{
				$('#signup-modal-error-message p').html(response['message']);
				$('#signup-modal-error-message').hide();
				//				$('#signupForm').fadeOut();
				$('#signupModal #signupForm').hide();
				$('#signupModal .modal-footer').hide();
				$('#signupModal .modal-body .alert-message').removeClass('hide');
				$('#signupModal .modal-body .alert-message p').text(response['message']);
				$('#signup-modal-error-message').addClass('success');
				$('#signup-modal-error-message').show();
			}
		}
			
		$('#logoutLink').click(
			function()
			{
				var data = [];
				$.ajax( {
					url: "/login/logout",
					type: 'POST',
					data: data,
					success: logoutSuccess
				} );
				return false;				
			});
			
		function logoutSuccess(response)
		{
			location.reload();
		}
			
		function searchFinished(json, $form)
		{
			if(json['status']==false)
			{
				$.each(json['errors'],function(key,val)
				{
					var $input = $('input[name='+key+']',$form);
					var $container = $input.closest('div.clearfix');
					
					$container.addClass('error');
					$input.addClass('error').after($('<span>').addClass('help-inline').text(val));
					$('#settingsUpdate-message p').text(json['message']);
					$('#settingsUpdate-message').addClass('error');					
					$('#settingsUpdate-message').fadeIn();
				});				
			}
			else
			{
				var items = json['data']['items'];
				renderSearch(items, json.pagination);
				var result_count =json.data.currentItemCount;
				//				console.log(result_count)
				var total_count = json.data.totalItems;
				$('.total_count').text(addCommas( total_count));
				if(result_count>10)
				{
					$('.pagination').show();
				}
				else
				{
					$('.pagination').hide();						
				}
				$('.result_count').text(result_count);
				$('.result_header').toggleClass('hide');
				$('#settingsUpdate-message p').html(json['message']);
				$('#settingsUpdate-message').hide();
				$('#userConnectModal').modal('hide');
				//				$('#signupForm').fadeOut();
				//				$('#modifyUserInfoForm').hide();
				//				$('#signupModal .modal-footer').hide();
				$('#settingsUpdate-message').removeClass('hide');
				$('#settingsUpdate-message p').text(json['message']);
				$('#settingsUpdate-message').addClass('success');
				$('#settingsUpdate-message').show();
			}				
		}
		$(".itemResultHolder").hasClass("ui-draggable-dragging");
		function renderSearch(items, options)
		{
			//			console.log(options);
			var code ='';
			var viewPrice = '';
			$("#resultsContainer").html("");
			var list = '';
			
			if(options.page_count > 20)
			{
				var pages = pages_max;
			}
			else
			{
				var pages = options.pages;
			}
			$('.pagination ul').html('');
			for (i = 1; i < pages; i++) {
				$('.pagination ul').append(
					$('<li>').append(
						$('<a>').attr('href', '#').append(i)
						)
					);
			}
			
			$('.pagination ul').append('<li><a href="#">Next</a></li>');
			//			console.log(list);
			//			$('.pagination').html(list);
			$.each(items, function(i, item)
			{
				var supplier_name = item.product.author.name;
				var firstImage = item['product']['images'][0]['link'];
				var productLink = item.product.link;
				var googleId = item.product.googleId;
				var price = item['product']['inventories'][0]['price'];
				var availability = item['product']['inventories'][0]['availability'];
				var anchor = item.product.link;
				var title = item['product']['title'];
				code = $('<img class="'+item.product.googleId+'" />').attr("src", firstImage);
				var current = $('<div class="itemResultHolder"></div>').html(code).appendTo("#resultsContainer");
				var anchorMarkup = $('<a href="'+productLink+'" target="blank" class="'+item.product.googleId+' productImgAnchor"></a>');
				var viewPrice = $("<h3></h3>").text(price.toFixed(2)).appendTo(current);
				$('img.'+item.product.googleId).wrap(anchorMarkup);
				$('a.'+item.product.googleId).wrap('<div class="productImgContainer" />');
				var viewPrice = $('<h5 class="alert-success"></h5>').text(availability).appendTo(current);
				
				$('<h4><span class="supplier_name"></span></h4>').text(supplier_name).appendTo(current);
				$('<p class="itemResultTitle"></p>').text(title).appendTo(current);
				$('<input type="hidden" />').attr('value', googleId).addClass('itemGoogleId').appendTo(current);
			});
			$(".itemResultHolder").draggable({
				revert: "invalid"
			});
			
			var package_remove_button = '<a href="#" class="btn btn-danger remove"><i class="icon-trash icon-white"></i> Remove</a>';
			$('.input-micro').click(function()
			{
				console.log('x');
				$('#packageBar').event.preventDefault();
			});
			$( "#packageBar" ).droppable({
				hoverClass: "alert-error",
				activeClass: "alert-success",
				drop: function( event, ui ) {
					$('#success_message').fadeIn().delay(messageDelay).fadeOut();
					var package_qty_input = '<li><span class="packageItemDataContainer"><span class="price alert-success pull-left">'+ui.draggable.find('h3').text()+'</span><input class="itemGoogleId" type="hidden" value="'+ui.draggable.find('input.itemGoogleId').attr('value')+'" /><input class="itemLink" type="hidden" value="'+ui.draggable.find('a').attr('href')+'" /><input class="imagePreview" type="hidden" value="'+ui.draggable.find('img').attr('src')+'" /><input type="text" class="input-micro quantity" value="1" style="margin-bottom: 0;">';
					var content = package_qty_input+'<span class="packageBarItemDescription">'+ui.draggable.find('.itemResultTitle').text()+'</span></span>'+package_remove_button+'</li>';
					$('.packageDefaultMessage').remove();
					$( this )
					.addClass( "ui-state-highlight" )
					.removeClass("alert-info")
					.find( "ul" )
					.append(content);
					ui.draggable.hide();
					$('#packageBar .buttonContainer').removeClass('hide');
					$('a.remove').click(function()
					{
						$(this).parent().remove();
					});
					
				}
			});
		}
		$('button.savePackageDropped').click(function(event)
		{
			event.preventDefault();
			$(this).fadeOut();
			var data ='';
			$('#packageBarContentContainer ul li').each(function(i, items_list)
			{
				var price = $(items_list).find('span.price').text();
				var title = $(items_list).find('span.packageBarItemDescription').text();
				var quantity = $(items_list).find('input.quantity').val();
				var image_path = $(items_list).find('input.imagePreview').val();
				var link = encodeURIComponent($(items_list).find('.itemLink').val());
				var googleId = $(items_list).find('input.itemGoogleId').val();
				data +='price['+i+']='+price+'&title['+i+']='+title+'&quantity['+i+']='+quantity+'&preview_image['+i+']='+image_path+'&url['+i+']='+link+'&google_id['+i+']='+googleId+'&';
			});
			$.ajax( {
				url: '/user/save_package_data',
				type: 'post',
				data: data,
				dataType: 'json',
				success: function()
				{
					$('.packageBarHolder').slideUp('slow');
				}
			} );
		});
		$(".createPackageAnchor").click(function(event)
		{
			var text = $('.createPackageAnchor').text();
			if(text == 'Create a Package')
			{
				var value = '';
			}
			else
			{
				var value = text;
			}
			var input = $('<input type="text" class="span2 packageName" value="'+value+'">')
			var currentHtml = $('form.namePackage').html();
			$('form.namePackage').prepend(input);
			$('.createPackageAnchor').text('');
			$('input.packageName').focus();
			$('a.done').show();
			$('input.packageName').blur(function()
			{
				savePackageName();
			});
			$('form.namePackage').submit(function(event)
			{
				event.preventDefault();
				savePackageName();
			})
		});
		function savePackageName()
		{
			console.log('trying to save package name');
			var data = {
				packageName: $('input.packageName').val()
			};
			$.ajax({
				url:'/user/save_package_name',
				type: 'post',
				data: data,
				dataType: 'json',
				success: function(json){
					$('.createPackageAnchor').html('');
					$('input.packageName').remove();
					$('form.namePackage a.createPackageAnchor').text(json.package_name_from_session)
					$('a.done').hide();
				}
			})
		}
		function simpleFormResponse(json, $form)
		{
			if(json['status']==false)
			{
				$.each(json['errors'],function(key,val)
				{
					var $input = $('input[name='+key+']',$form);
					var $container = $input.closest('div.clearfix');
					
					$container.addClass('error');
					$input.addClass('error').after($('<span>').addClass('help-inline').text(val));
					$('#settingsUpdate-message p').text(json['message']);
					$('#settingsUpdate-message').addClass('error');					
					$('#settingsUpdate-message').fadeIn();
				});				
			}
			else
			{
				
				$('#settingsUpdate-message p').html(json['message']);
				$('#settingsUpdate-message').hide();
				$('#userConnectModal').modal('hide');
				//				$('#signupForm').fadeOut();
				//				$('#modifyUserInfoForm').hide();
				//				$('#signupModal .modal-footer').hide();
				$('#settingsUpdate-message').removeClass('hide');
				$('#settingsUpdate-message p').text(json['message']);
				$('#settingsUpdate-message').addClass('success');
				$('#settingsUpdate-message').show();
			}				
		}



		$('form.simpleForm').submit(
			function()
			{
				// reset form
				var $form = $(this);
				var $input = $('input[name]',$form).not('[type=hidden]').removeClass('error');
				$input.closest('div.clearfix').removeClass('error');
				$('span.help-inline').remove();
				$('#settingsUpdate-message p').text('');
				$('#settingsUpdate-message').removeClass('error').hide();
				
				$.ajax( {
					url: $form.attr('action'),
					type: 'POST',
					data: $form.serialize(),
					dataType: 'json',
					success: function(json){
						simpleFormResponse(json,$form);
					}
				} );
				return false;				
			});

		$('.resetButton').click(
			function()
			{
				
			});
			
		function successMessage(msg)
		{
			$html ="";
		}
		
		$('#settingsGravatarHolder').hover(
			function()
			{
				$('#settingsGravatarHolder .editGravatarBtn').fadeIn();

			
			},
			function()
			{
				$('#settingsGravatarHolder .editGravatarBtn').fadeOut();			
			});

		$('.editGravatarBtn').click(
			function()
			{
			
			});
		
		$(function() {
			$(".itemResultHolder").draggable();
			$( ".data-grid li" ).draggable({
				revert: "invalid"
			});
		});
		function addCommas(nStr)
		{
			nStr += '';
			x = nStr.split('.');
			x1 = x[0];
			x2 = x.length > 1 ? '.' + x[1] : '';
			var rgx = /(\d+)(\d{3})/;
			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + ',' + '$2');
			}
			return x1 + x2;
		}

		$('form.navbar-search').submit(function(e)
		{
			e.preventDefault();
		});
		$('.modal-header a.close, .form-actions button.cancel').click(function()
		{
			$('#userConnectModal').modal('hide');
		});
	});
