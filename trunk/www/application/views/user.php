<div class="container-fluid" style="margin-top: 13px;">
    <div class="row-fluid">
		<div class="span1" style="margin-left: 0	">
			<div class="well sidebar-nav">
				<ul class="nav nav-list">
					<li><span><img src="<?= $user_info['gravatarAvatarURL']; ?>" alt="<?= $user_info['first_name'] . ' ' . $user_info['last_name']; ?>" /></span></li>
					<li class="nav-header">Sidebar</li>
					<li class="active"><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li class="nav-header">Sidebar</li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li class="nav-header">Sidebar</li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
					<li><a href="#">Link</a></li>
				</ul>
			</div><!--/.well -->
        </div>
		<div class="content span11" style="margin-left: 20px; padding: 22px;">
			<div class="progressBarContainer">
				<ul>
					<li>
						<h1><?= $user_info['first_name'] . ' ' . $user_info['last_name']; ?> <small><?= $user_info['username']; ?></small></h1>
						<div style="margin-bottom: 9px;" class="progress progress-info progress-striped">

							<div style="width: <?= $progress['rank']['percent']; ?>%" class="bar"></div>
						</div>
						<div class="progressValues">
							<span style="float:left;" class="currentXpValue"><?= $progress['xp']['xp_value']; ?>xp</span>
							<span style="float:right;" class="currentXpThreshold"><?= $progress['rank']['threshold']; ?>xp</span>
						</div>
					</li>
				</ul>
			</div>
			<?php if ($wants !== false): ?>
				<ul class="wishList">
					<?php foreach ($wants as $want) : ?>
						<li>
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

								<span class="wishPrice alert-success">$<?= $want['price']; ?></span>
								<br />
								<span class="wishTitle"><?= $want['title']; ?></span>
								<br />
								<p class="wishDescription"><?= $want['description']; ?></p>
							</div>
							<div class="progressValues">
								<span style="" class="currentXpThreshold"><?= $want['xp_value']; ?>xp</span>
							</div>
								<div style="margin-bottom: 9px;" class="progress progress-success progress-striped">
									<div style="width: <?= $want['percent']; ?>%" class="bar"></div>
								</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
    </div>
</div>