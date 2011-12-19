/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(
	function() {
		
		var siteBaseUrl		= 'http://citradebook.com';
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
			
		$('#addwishitemURLAnchor').click(
			function()
			{
				$('#addwishitemManual').toggleClass('hide');
				$('#add_wish_item_manually').toggleClass('hide');
				$('form[name="addwishitemURL"]').toggleClass('hide');
				$('#addwishitemManualAnchor').toggleClass('hide');
				$('#addwishitemURLAnchor').toggleClass('hide');
				
			});
				
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
	});
