<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="html/x-mustache-template" id="customImageSearchResultsTmpl">
	<div class="itemResultHolder">
		<div class="productImgContainer">
			<a href="{{imageLink}}" class="{{googleId}} productImgAnchor" target="blank">
				<img src="{{src}}" class="{{googleId}}" />
			</a>
		</div>
		<h3>test</h3>
		<h5 class="alert-success">www.domain.com</h5>
		<h4>image</h4>
		<p class="itemResultTitle">description</p>
		<input type="hidden" value="{{googleId}}" class="itemGoogleId" />
	</div>
</script>
<script type="html/x-mustache-template" id="customSearchResultsTmpl">
	<div class="itemResultHolder">
		<div class="productImgContainer">
			<a href="{{productLink}}" class="{{googleId}} productImgAnchor" target="blank">
				<img src="{{thumbImage}}" class="{{googleId}} " />
			</a>
		</div>
		<h5 class="alert-success">{{displayLink}}</h5>
		<h4>{{title}}</h4>
		<h5><small>{{price}}</small></h5>
		<p class="itemResultTitle">{{description}}</p>
		<input type="hidden" value="{{googleId}}" class="itemGoogleId" />
	</div>
</script>
<script type="html/x-mustache-template" id="shoppingSearchResultsTmpl">
	<div class="itemResultHolder ui-draggable" style="position: relative;">
		<div class="productImgContainer">
			<a class="{{googleId}} productImgAnchor" target="blank" href="{{productLink}}"><img class="{{googleId}}" src="{{src}}"></a>
		</div>
		<h3>${{price}}</h3>
		<h5 class="alert-success">
			inStock
		</h5>
		<h4>{{displayLink}}</h4>
		<p class="itemResultTitle">
			{{description}}
		</p>
		<input type="hidden" value="{{googleId}}" class="itemGoogleId">
	</div>
</script>
<div class="container-fluid">

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
					<form name="namePackage" action="user/save_package_data" class="namePackage" method="post">
						<input type="hidden" name="package_name_id" id="package_name_id" class="package_name_id" value="<?=$package_id; ?>" />
						<a href="#" class="createPackageAnchor" style="float: left"><?= $package_name; ?></a>
						<div class="package_color_picker" style="">
							<input type="text" name="package_color_input" class="package_color_input simple_color" value="" />
						</div>
						
						<a href="#" class="hide done" style="vertical-align: text-top; line-height: 12px;"><img src="<?= base_url(); ?>images/done_square.png" alt="" /></a>
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
					<input type="text" name="itemSearch" id="itemSearch" value="<?= isset($search_query) ? $search_query : 'prevost'; ?>" />
					<?php if(isset($search_query)): ?>
					<input type="hidden" name="search_forward" id="search_forward" value="1" />
					<?php endif; ?>
				</div>
				<div class="controls">
					<label class="radio">
						<input type="radio" name="searchType" value="1" >
						Shopping
					</label>
					<label class="radio">
						<input type="radio" name="searchType" value="2" checked>
						Custom Search
					</label>
					<label class="image_search">
						<input type="checkbox" name="image_search" id="image_search" value="1" />
						images only
					</label>
				</div>
				<div class="controls">
					<label class="radio">
						<input type="radio" checked="" value="relevancy" id="sortOptions1" name="sortOptions">
						Sort by Relevance
					</label>
					<label class="radio">
						<input type="radio"  value="price" id="sortOptions2" name="sortOptions">
						Sort by Price
					</label>
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
	<div class="sort_actions">
		<a href="#" class="btn btn-success"><i class="icon-arrow-down icon-white"></i> Price</a>
	</div>
	<div class="pagination hide">
		<ul>
			<li><a href="#">Prev</a></li>


		</ul>
	</div>

	<div id="resultsContainer">
	</div>
</div>
