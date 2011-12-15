<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="container">

	<div class="page-header content">
		<h1>TradeManager <small>manage your wish lists here</small></h1>
	</div>
<div id="success_message" class="alert-message success hide">
        <a href="#" class="close">×</a>
        <p><strong>Well done!</strong> You successfully <a href="#">added</a> a wish item.</p>
</div>
<div id="error_message" class="alert-message error hide">
        <a href="#" class="close">×</a>
        <p><strong>Not So Fast!</strong> You must completely fill out the form </p>
</div>
<form id="addwishitemURL" name="addwishitemURL" action="" method="post">
	<fieldset>
		<input type="hidden" name="form_action" id="action" value="add_item_URL" />
		<legend>Add a wish item using a URL:</legend>
		<div class="clearfix">
			<label>URL: </label>
			<div class="input">
				<input type="text" name="wishURL" id="wishURL" value="" />
			</div>
		</div>
		<div class="clearfix">
				<button class="btn primary" data-loading-text="Saving Item..." id="add_item_URL_submit">Fetch Item</button>
			</div>
		
	</fieldset>
	
</form>
<form id="addwishitemManual" name="addwishitemManual" class="hide">
	<fieldset>
		<input type="hidden" name="form_action" id="action" value="add_item_manually" />
		<input type="hidden" name="user_id" id="user_id" value="<?php echo 1; ?>" />
		<legend>Add a wish item manually:</legend>
		<div class="clearfix">
			<label>Title: </label>
			<div class="input">
				<input type="text" name="itemTitle" id="itemTitle" value="" />
			</div>
		</div>
		<div class="clearfix">
			<label>Price: </label>
			<div class="input">
				<input type="text" name="itemPrice" id="itemPrice" value="" />
			</div>
		</div>
		<div class="clearfix">
			<label>Description: </label>
			<div class="input">
				<textarea name="itemDescription" id="itemDescription" cols="10" rows="5"></textarea>
			</div>
		</div>
		<div class="clearfix">
			<label>Image: </label>
			<div class="input">
				<input type="text" name="itemImage" id="itemImage" value="" />
			</div>
		</div>
		<div class="clearfix">
			<label>Work Trade: </label>
			<div class="input">
			
				<select name="workTrade" id="itemWorkTrade">
					<option value="Select a service">Select A Service...</option>
					<?php foreach($userServices as $us): ?>
					<option value="<?php echo $us['service_id']; ?>"><?php echo $us['service_name']; ?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
			<div class="clearfix">
				<button class="btn primary" data-loading-text="Saving Item..." id="add_item_manually_submit">Save Item</button>
			</div>
	</fieldset>
</form>
	<a href="#" id="addwishitemURLAnchor" class="label hide">Add a wish item using URL</a>
	<a href="#" id="addwishitemManualAnchor" class="label">Add a wish item manually</a>	
	<div id="url_success_prompt">
		
	</div>
</div>