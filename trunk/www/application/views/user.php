<div class="container-fluid" style="margin-top: 13px;">
    <div class="row-fluid">
		<div class="span2" style="margin-left: 0	">
			<div class="well sidebar-nav">
				<ul class="nav nav-list">
					<li class="userAvatarSidebar">
						<img src="<?= $userInfoArray['user_info']['gravatarAvatarURL']; ?>" alt="<?= $userInfoArray['user_info']['first_name'] . ' ' . $userInfoArray['user_info']['last_name']; ?>" />
					</li>
					<li class="nav-header">Actions</li>
					<li class="active"><a href="<?= base_url().'user/'; ?>">Profile</a></li>
					<li><a href="#" class="earnXP">Redeem XP</a></li>
					<li><a href="<?= base_url().'user/linkAccountRequest'; ?>" data-toggle="modal" data-target="#myModal" data-success="linkAccountsSuccess" class="linkAccounts">Link Accounts</a></li>
					<li><a href="<?= base_url().'user/manage_xp'; ?>" data-toggle="modal" data-target="#myModal">Manage Trades</a></li>
					<li><a href="<?= base_url().'user/deleted_items'; ?>" >View Deleted Items</a></li>
					<li class="nav-header">Help</li>
					<li><a href="#">Earn XP</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
				</ul>
			</div><!--/.well -->
        </div>
		<div class="content span9" style="margin-left: 20px; padding: 0;">
			<div class="progressBarContainer userHeader">
				<ul>
					<li>
						<h1><?= $userInfoArray['user_info']['first_name'] . ' ' . $userInfoArray['user_info']['last_name']; ?> <small><?= $userInfoArray['user_info']['username']; ?></small></h1>
						<div style="margin-bottom: 0px;" class="progress progress-info progress-striped">

							<div style="width: <?= $progress['rank']['percent']; ?>%" class="bar"></div>
						</div>
						<div class="progressValues">
							<span style="float:left;" class="currentXpValue"><?= $progress['xp']['xp_value']; ?>xp</span>
							<span style="float:right;" class="currentXpThreshold"><?= number_format($progress['rank']['threshold']); ?>xp</span>
						</div>
					</li>
				</ul>
			</div>
			<?php if ($wants !== false): ?>
				<ul class="wishList">
					<?php foreach ($wants as $want) : ?>
						<li>
							<a data-dismiss="modal" class="close " type="button" style="z-index: 9999; padding: 4px 10px; background: none repeat scroll 0% 0% rgb(221, 221, 221); border: 1px solid rgb(170, 170, 170);">×</a>
							<input type="hidden" name="wishId" class="wishId" value="<?= $want['id']; ?>" />
							<div class="wishListImgContainer">
								<?php
								if (empty($want['preview_image']))
								{
									$want['preview_image'] = base_url() . 'images/green_box.png';
								}
								?>
								<img src="<?= $want['preview_image']; ?>" alt="" />
							</div>
							<div class="wishListDataContainer">

								<p>
									<span class="wishPrice alert-success alert">$<?= number_format($want['price'], 2); ?></span>
									<a href="#" class="btn btn-success" style="float:right"><i class=" icon-plus-sign icon-white"></i> Checkout</a>
								</p>
								<p class="wishTitle"><?= $want['title']; ?></p>
								<br />
								<p class="wishDescription"><?= $want['description']; ?></p>
							</div>
							<div class="itemProgressContainer">

								<div class="progressValues">
									<span style="" class="currentXpValue"><?= $progress['xp']['xp_value']; ?>xp</span>
									<span style="" class="currentXpThreshold"><?= number_format($want['xp_value']); ?>xp</span>
								</div>
								<div style="margin-bottom: 9px;" class="item progress progress-success progress-striped" rel="tooltip" title="<?= $want['percent']; ?>%">
									<div style="width: <?= $want['percent']; ?>%" class="bar"></div>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
    </div>
</div>