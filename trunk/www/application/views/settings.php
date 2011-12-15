<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//exit;
?>
<div class="page container">
	<div class="page-header content">
    <h1>Account: <small> Modify your account settings</small></h1>
  </div>
	<form name="Account" action="/user/modifyUserInfo" method="post" class="form-stacked" id="modifyUserInfoForm">
		<fieldset>
			<legend>General Settings</legend>
			<input type="hidden" name="user_id" id="user_id" value="<?php echo USER_USER_ID; ?>" />
			<div class="clearfix">
				<label>First Name: </label>
				<div class="input">
					<input type="text" name="first_name" id="first_name" value="<?php echo USER_FIRST_NAME; ?>" />
				</div>				
			</div>
			<div class="clearfix">
				<label>Last Name: </label>
				<div class="input">
					<input type="text" name="last_name" id="last_name" value="<?php echo USER_LAST_NAME; ?>" />
				</div>				
			</div>
			<div class="clearfix">
				<label>Email: </label>
				<div class="input">
					<input class="" type="text" name="email_address" id="email_address" value="<?php echo USER_EMAIL_ADDRESS; ?>" />
				</div>				
			</div>
			<div class="clearfix">
				<label>Username: </label>
				<div class="input">
					<input class="" type="text" name="username" id="username" value="<?php echo USER_USERNAME; ?>" />
				</div>				
			</div>
		</fieldset>
		
	</form>
	<div class="actions">
            <button type="submit" data-loading-text="Saving Changes..." value="Save changes" class="btn primary" id="modifyUserInfoSubmit" >Save Changes</button>
			&nbsp;
			<button class="btn" type="reset">Cancel</button>
	</div>
</div>