<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a href="/" class="brand"><span class="hiliteTBBlue">trade</span><span class="hiliteTBGray">book</span></a>
			<div class="nav-collapse">
				<ul class="nav">
					<li class="active"><a href="/">Home</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="loginLink">Login</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li class="nav-header">Nav header</li>
							<li><a href="#">Separated link</a></li>
							<li><a href="#">One more separated link</a></li>
						</ul>
					</li>
				</ul>
				<form action="" class="navbar-search pull-left">
					<input type="text" placeholder="Search" class="search-query span2">
				</form>
				<ul class="nav pull-right">
					<li>
						<?php	if(isset($is_logged_in)) : ?>
						<a href="/user"><?=$user_info['username'];?></a>
						<?php else: ?>
						<a href="#" class="loginLink">Login</a>
					</li>
					<li class="divider-vertical"></li>
					<li>
						<a href="#" class="signupLink">Sign-up</a>
					</li>
					<?php endif; ?>
					<li class="divider-vertical"></li>
					<?php if(isset($is_logged_in)) : ?>
					<li class="dropdown">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#">Account <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/user/addwish">Add Items to wish list</a></li>
							<li><a href="#">Another action</a></li>
							<li><a href="#">Something else here</a></li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a></li>
						</ul>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="subnav">
    <ul class="nav nav-pills">
      <li class="active"><a href="#global">Global styles</a></li>
      <li class=""><a href="#gridSystem">Grid system</a></li>
      <li class=""><a href="#fluidGridSystem">Fluid grid system</a></li>
      <li class=""><a href="#gridCustomization">Customizing</a></li>
      <li class=""><a href="#layouts">Layouts</a></li>
      <li><a href="#responsive">Responsive design</a></li>
    </ul>
  </div>
<!--Modals below-->

<div class="modal-backdrop fade in hide"></div>
<div id="createPackageModal" class="modal hide fade">
	<div class="modal-header">
		<h3>Create Package</h3>
	</div>
</div>
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
			<?php echo form_open('login/login', array('class' => 'login')); ?>
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
			<div class="form-actions">
				<button class="btn btn-primary" type="submit">Save changes</button>
				<button class="btn cancel">Cancel</button>
			</div>
		</div>
		</form>

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
