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
	<div class="userCollection">
		<?php	
			//	echo '<span class="label warning">Admin</span>';		
			if(isset($userInfoArray['isAdmin']) && $userInfoArray['isAdmin']== 1)
			{
				echo '<span class="label important">Admin</span>';		
			}
			if(isset($userInfoArray['user_info']['user2Collection'][1]['collection_id']) && $userInfoArray['user_info']['user2Collection'][1]['collection_id']==2)
			{
				echo '<span class="label warning">Moderator</span>';
			}
			if(isset($userInfoArray['user_info']['user2Collection'][2]['collection_id']) && $userInfoArray['user_info']['user2Collection'][2]['collection_id']==3)
			{
				echo '<span class="label success">User</span>';
			}
		?>		
	</div>
  </div>
	<form name="Account" action="/user/update" method="post" class="form-stacked simpleForm" id="modifyUserInfoForm">
		<fieldset>
			<legend>General Settings</legend>
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $userInfoArray['user_info']['user_id']; ?>" />
			<div id="settingsUpdate-message" class="alert-message hide">
				<p></p>
			</div>
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
				  <?php	  foreach ($services as $serv): ?>
					  
                <li>
                  <label>
                    <input type="checkbox" value="<?php echo $serv['id']; ?>" id="<?php echo $serv['id']; ?>" name="tradeService">
                    <span><?php echo $serv['service_name']; ?></span>
                  </label>
                </li>
				<?php endforeach; ?>

              </ul>
              <span class="help-block">
                <strong>Note:</strong> Labels surround all the options for much larger click areas and a more usable form.
              </span>
            </div>
          </div>
			<div class="actions">
					<button type="submit" data-loading-text="Saving Changes..." value="Save changes" class="btn primary" id="modifyUserInfoSubmit" >Save Changes</button>
					&nbsp;
					<button class="btn" type="reset">Cancel</button>
			</div>			
		</fieldset>
		
	</form>

</div>