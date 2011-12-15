<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="container span9">

	<div id="loginModal">
		<div class="modal-header">
			<h3>
				Login
			</h3>
		</div>
		<div class="modal-body">
			<div id="login-modal-error-message" class="alert-message error hide">
				<p></p>

			</div>
			<?php echo form_open('login/login'); ?>
			<div class="clearfix">
				<label>Username/Email: </label>
				<div class="input">
					<input type="text" name="pageUsername" id="pageUsername" value="" />
				</div>				
			</div>			
			<div class="clearfix">
				<label>Password: </label>
				<div class="input">
					<input type="password" name="pagePassword1" id="pagePassword1" value="" />
				</div>				
			</div>		
			<button class="btn primary" id="pageLoginSubmit">Login</button>
			</form>

		</div>
		<div class="modal-footer">
		</div>
	</div>
</div>