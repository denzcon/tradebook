<div class="container-fluid">
    <div class="row-fluid">
		<div class="page-header">
			<h1>My <span class="hiliteTBBlue">trade</span><span class="hiliteTBGray">book</span></h1>
		</div>
		<div class="span2">
			<div class="well sidebar-nav">
				<ul class="nav nav-list">
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
		<div class="content span9">
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
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
    </div>
</div>