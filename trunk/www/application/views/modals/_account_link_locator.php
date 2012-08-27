<div class="user_info_container">
	<div class="selected_user_avatar">
		<img src="<?= (int) is_null($avatar_image_url) == 0 ? 'http://www.gravatar.com/avatar/' . md5($email_address) . '?s=110' : $avatar_image_url; ?>" alt="<?= $first_name . ' ' . $last_name; ?>" />
	</div>
	<div class="selected_user_data">
		<ul>
			<li><label>Username: </label> <div><?= $username; ?></div></li>
			<li><label>First Name: </label> <div><?= $first_name; ?></div></li>
			<li><label>Last Name: </label> <div><?= $last_name; ?></div></li>
			<li><label>Email Address: </label> <div><?= $email_address; ?></div></li>
			<li>
				<form name="linkAccountTo" action="" method="post">
					<input type="hidden" name="linkedUserId" id="linkedUserId" value="<?= $id; ?>" />
					<button href="#" class="btn btn-info">Link This Account</button>
				</form>
			</li>
		</ul>
	</div>
</div>