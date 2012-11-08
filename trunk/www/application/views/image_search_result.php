<div class="itemResultHolder ui-draggable" style="position: relative;">
	<div class="productImgContainer">
		<a class="<?= $google_id; ?> productImgAnchor" target="blank" href="<?= $item_anchor_url; ?>">
			<img class="<?= $google_id; ?>" src="<?= $item_thumb_url; ?>">
		</a>
	</div>
	<h3>
		<?= $item_price; ?>
	</h3>
	<h5 class="alert-success">
		<?= $inventory_status; ?>
	</h5>
	<h4>
		<?= $vendor_domain; ?>
	</h4>
	<p class="itemResultTitle">
		<?= $item_title; ?>
	</p>
	<input type="hidden" value="<?= $google_id; ?>" class="itemGoogleId">
</div>

