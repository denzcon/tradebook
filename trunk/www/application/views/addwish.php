<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
	$(function(){
		$(".itemResultHolder").click(function()
		{
			alert("test");
		})
	});
</script>
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
	<div class="packageBarHolder">
		<div id="packageBar" class="alert bury">
			<div class="packageBarController"></div>
			<div id="packageBarContentContainer">
				<h3 class="alert-heading">
					<img src="/images/package.png" alt="create a package" width="30px"  style="float: left"/>
					<form name="namePackage" action="save_package" class="namePackage" method="post">
						<a href="#" class="createPackageAnchor" style="float: left"><?= trim(trim($package_name), ' \t'); ?></a>
					</form>
				</h3>
				<form name="newPackage" action="" method="post">
					<ul>
						<li class="packageDefaultMessage">Drag items here to create package</li>
					</ul>
					<div class="buttonContainer hide">
						<button class="btn btn-small btn-primary savePackageDropped">Save Package</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="searchForm">

		<form id="addwishitemURL" name="addwishitemURL" action="" method="post" class="hide">
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
	</div>
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
						<?php foreach ($userServices as $us): ?>
							<option value="<?php echo $us['service_id']; ?>"><?php echo $us['service_name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
			<div class="clearfix">
				<button class="btn primary" data-loading-text="Saving Item..." id="add_item_manually_submit">Save Item</button>
			</div>
		</fieldset>
	</form>
	<form id="addWishItemSearch" action="#" name="addWishItemSearch" class="">
		<fieldset>
			<legend>Search For something</legend>
			<div class="clearfix">
				<label>Search: </label>
				<div class="input">
					<input type="text" name="itemSearch" id="itemSearch" value="" />
				</div>
			</div>
			<div class="clearfix">
				<a href="#" class="btn"  id="add_item_search_submit"><i class="icon-search"></i> Search</a>
			</div>
		</fieldset>
	</form>
	<div class="result_header hide">
		<h1>Found <span class="total_count"></span> results: Displaying <span class="result_count"></span></h1>
	</div>
	<a href="#" id="addwishitemSearchAnchor" class="label">Add a wish item using SearchURL</a>
	<a href="#" id="addwishitemURLAnchor" class="label hide">Add a wish item using URL</a>
	<a href="#" id="addwishitemManualAnchor" class="label hide">Add a wish item manually</a>	
	<div id="url_success_prompt">

	</div>
	<div class="pagination hide">
		<ul>
			<li><a href="#">Prev</a></li>


		</ul>
	</div>

	<div id="resultsContainer">

		<div class="itemResultHolder" draggable="true"></div>
	</div>
</div>
