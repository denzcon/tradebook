/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(
	function() {
		var pages_max		= 20;
		var siteBaseUrl		= 'http://tradebook.dev';
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
				$.ajax( {
					url: "/user/searchWishAjax",
					type: 'POST',
					data: $('#itemSearch'),
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
			
		$('#loginLink').click(
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
			
			
		$('#loginSubmit').click(
			function()
			{
				
				if ( !$('#username').val() || !$('#password1').val())
				{
					$('#login-modal-error-message p').text('You have not completed the form');
					$('#login-modal-error-message').fadeIn().delay(messageDelay).fadeOut();					
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
		$('#pagesLoginSubmit').click(
			function()
			{
				
				if ( !$('#pageUsername').val() || !$('#pagePassword1').val())
				{
					$('#login-modal-error-message p').text('You have not completed the form');
					$('#login-modal-error-message').fadeIn().delay(messageDelay).fadeOut();
					
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
			
		function loginSuccess( response ) 
		{
			//			  response = $.trim( response );
			if(response['is_logged_in']=== true)
			{
				$('#userConnectModal').modal('hide');
				location.reload();						
			}
			else
			{
				$('#login-modal-error-message p').text('Your login information is incorrect. Please try again');
				$('#login-modal-error-message').show();
			}
			console.log(response['is_logged_in']);
		}	
			
		$('#signupLink').click(
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
		$("#packageBar").click(function(){
			$(this).toggleClass("bury");
			$(this).toggleClass("expose");
		});
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
			console.log(pages);
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
				
				var price = item['product']['inventories'][0]['price'];
				var title = item['product']['title'];
				code = $("<img/>").attr("src", firstImage);
				var current = $('<div class="itemResultHolder"></div>').html(code).appendTo("#resultsContainer");
				var viewPrice = $("<h3></h3>").text('$'+price.toFixed(2)).appendTo(current);
				var supplier_name = $('<br /><h4><span class="supplier_name"></span></h4>').text(supplier_name).appendTo(current);
				$('<p class="itemResultTitle"></p>').text(title).appendTo(current);
				
			//				$(code).appendTo("#resultsContainer");
			//				console.log(item['product']['images'][0]['link']);
			});
			$(".itemResultHolder").draggable({
				revert: "invalid"
			});
			var package_qty_input = '<input type="text" class="input-micro" value="1">';
			$('.input-micro').click(function()
			{
				console.log('x');
				$('#packageBar').event.preventDefault();
			});
			$( "#packageBar" ).droppable({
				hoverClass: "alert-error",
				activeClass: "alert-success",
				drop: function( event, ui ) {
					var content = package_qty_input+' x '+ui.draggable.find('.itemResultTitle').text();
					$( this )
					.addClass( "ui-state-highlight" )
					.removeClass("alert-info")
					.find( "p" )
					.append(content);
					ui.draggable.hide();
				}
			});
		}
		$("#createPackageAnchor").click(function()
		{
			$("#createPackageModal").modal();
		});
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
		//			$( ".data-grid .dropzone" ).droppable({
		//				drop: function( event, ui ) {
		//					$( this )
		//					.addClass( "ui-state-highlight" )
		//					.find( "p" )
		//					.html( "Dropped!" );
		//				}
		//			});
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

		
	});
