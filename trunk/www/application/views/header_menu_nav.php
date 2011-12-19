<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="topbar-wrapper" style="z-index: 5;">	
	<div class="topbar" data-dropdown="dropdown" >	
		<div class="topbar-inner">
			<div class="container">
				<!--				<h3>-->
				<a href="/home" class="logoAnchor">
					<span class="hiliteTBBlue" style="margin-right: -7px;">trade</span>
					<span class="hiliteTBGray">book</span>
					<img src="<?php echo base_url(); ?>images/tradebook_mini_trademark.png" alt="tradebook" />
				</a>
				<!--				</h3>-->
				<ul class="nav">
					<li class="active"><a href="/home">Home</a></li>
					<li><a href="/about">About <strong><span class="hiliteTBBlue">t</span><span class="hiliteTBGray">b</span></strong></a></li>
					<li><a href="/postjob">Post a Job</a></li>
					<li><a href="/lookforwork">Look for work</a></li>
					<?php
					if (!$this->session->userdata('is_logged_in'))
					{
						?>
						<li class="dropdown login_signup_logout_links" data-dropdown="dropdown" >
							<a href="#" class="dropdown-toggle">
								Account
							</a>
							<ul class="dropdown-menu">
								<li><a href="/login" id="loginLink">Login</a></li>
								<li><a href="/login/signup" id="signupLink">Signup</a></li>

							</ul>
						</li>								
						<?php
					}
					else
					{
						?>
						<li class="dropdown login_signup_logout_links">
							<a href="#" class="dropdown-toggle">
								<?php
								$user_info = $this->membershipModel->getUserInfoArray();
								echo $user_info['user_info']['username'];
								?>
							</a>
							<ul class="dropdown-menu">
								<li><a href="/user/settings">General Settings</a></li>
								<li><a href="/user/addwish">Add Wish Items</a></li>
								<li><a href="/user/things2trade">Add Trade Items</a></li>
								<li class="divider"></li>
								<li><a href="/login/logout" id="logoutLink">Logout</a></li>
							</ul>
						</li>
						<?php
					}
					?>

				</ul>
				<form class="pull-right" action="">
					<input type="text" placeholder="Search" />
				</form>
			</div>
		</div>
	</div>
</div>

<!--Modals below-->
<div class="modal-backdrop fade in hide"></div>
<div id="userConnectModal" class="modal hide fade">
	<div id="loginModal">
		<div class="modal-header">
			<a class="close" href="#" style="margin-top: -8px;">×</a>
			<h3><span class="hiliteTBBlue" style="margin-right: -9px;">trade</span>
				<span class="hiliteTBGray">book</span>
				<img src="<?php echo base_url(); ?>images/tradebook_mini_trademark.png" alt="tradebook" /></h3>
		</div>
		<div class="modal-body">
			<div id="login-modal-error-message" class="alert-message error hide">
				<p></p>
			</div>
			<?php echo form_open('login/login'); ?>
			<div class="clearfix">
				<label>Username/Email: </label>
				<div class="input">
					<input type="text" name="username" id="username" value="" />
				</div>				
			</div>			
			<div class="clearfix">
				<label>Password: </label>
				<div class="input">
					<input type="password" name="password1" id="password1" value="" />
				</div>				
			</div>		
			</form>
		</div>
		<div class="modal-footer">
			<a class="btn primary" href="#" id="loginSubmit">Login</a>
			<a class="btn secondary" id="closeLoginModal" href="#" id="loginCancel">Cancel</a>
		</div>
	</div>


	<div id="signupModal" class="hide">
		<div class="modal-header">
			<a class="close" href="#" style="margin-top: -20px;">×</a>
			<h3>
				<span class="hiliteTBBlue" style="margin-right: -9px;">trade</span>
				<span class="hiliteTBGray">book</span>
				<img src="<?php echo base_url(); ?>images/tradebook_mini_trademark.png" alt="tradebook" />
			</h3>
		</div>
		<div class="modal-body">
			<div class="alert-message success hide">

				<p>
					<strong>Well done!</strong>
					You successfully read this alert message. 
					Cum sociis natoque penatibus et magnis dis parturient montes, 
					nascetur ridiculus mus. Maecenas faucibus mollis interdum.
				</p>
				<div class="alert-actions" style="text-align: right;">
					<a href="#" class="btn small">Take this action</a> 
					<a href="#" class="btn small">Or do this</a>
				</div>
			</div>
			<?php
			$attributes = array(
				'id' => 'signupForm',
				'class' => 'simpleForm'
				);
			echo form_open('/login/signupSubmit', $attributes);
			echo form_fieldset();
			foreach ($this->site_model->signupFormArray() as $inp)
			{
				?>
				<div class="clearfix">
					<label style="text-transform: capitalize;font-weight: bold;"><?php echo str_replace('_', ' ', $inp['name']); ?>: </label>
					<div class="input">

						<?php echo form_input($inp); ?>
					</div>				
				</div>					
				<?php
			}
			?>
				<input type="submit" style="display: none;" />
			</form>
			<div id="signup-modal-error-message" class="alert-message hide">				
				<p></p>				
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" data-loading-text="Saving Changes..." value="Save changes" class="btn primary" id="userRegistration" >Signup</button>
			&nbsp;
			<button class="btn" id="closeRegistration" type="reset">Cancel</button>
		</div>

	</div>	
</div>
<!--Modals above-->
