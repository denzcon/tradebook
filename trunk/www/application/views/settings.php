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
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $userInfoArray['user_info']['user_id']; ?>" />
			<div class="clearfix">
				<div id="settingsGravatarHolder">
					<div class="editGravatarBtn hide">
						<img src="<?php echo base_url();?>images/edit_pencil.png" alt="edit your image" />
					</div>
					<img src="http://www.gravatar.com/avatar/<?php echo md5( strtolower( trim( $userInfoArray['user_info']['email_address']) ) ); ?>?s=200" alt="<?php echo $userInfoArray['user_info']['first_name'].' '.$userInfoArray['user_info']['last_name'];?> " />					
				</div>
			</div>
			<div class="clearfix">
				<label>First Name: </label>
				<div class="input">
					<input type="text" name="first_name" id="first_name" value="<?php echo $userInfoArray['user_info']['first_name']; ?>" />
				</div>				
			</div>
			<div class="clearfix">
				<label>Last Name: </label>
				<div class="input">
					<input type="text" name="last_name" id="last_name" value="<?php echo $userInfoArray['user_info']['last_name']; ?>" />
				</div>				
			</div>
			<div class="clearfix">
				<label>Email: </label>
				<div class="input">
					<input class="" type="text" name="email_address" id="email_address" value="<?php echo $userInfoArray['user_info']['email_address']; ?>" />
				</div>				
			</div>
			<div class="clearfix">
				<label>Username: </label>
				<div class="input">
					<input class="" type="text" name="username" id="username" value="<?php echo $userInfoArray['user_info']['username']; ?>" />
				</div>				
			</div>
			
			<div class="clearfix">
            <label id="optionsCheckboxes">List of options</label>
            <div class="input">
              <ul class="inputs-list">
                <li>
                  <label>
                    <input type="checkbox" value="option1" name="optionsCheckboxes">
                    <span>Option one is this and that&mdash;be sure to include why it’s great</span>
                  </label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" value="option2" name="optionsCheckboxes">
                    <span>Option two can also be checked and included in form results</span>
                  </label>
                </li>
                <li>
                  <label>
                    <input type="checkbox" value="option2" name="optionsCheckboxes">
                    <span>Option three can&mdash;yes, you guessed it&mdash;also be checked and included in form results. Let's make it super long so that everyone can see how it wraps, too.</span>
                  </label>
                </li>
                <li>
                  <label class="disabled">
                    <input type="checkbox" disabled="" value="option2" name="optionsCheckboxes">
                    <span>Option four cannot be checked as it is disabled.</span>
                  </label>
                </li>
              </ul>
              <span class="help-block">
                <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
              </span>
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