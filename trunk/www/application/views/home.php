<?php

?>
<div class="homepage_container container">
	<div class="page-header">

	</div>
	<div class="container">
		<ul class="data-grid">
			<?php foreach ($grid as $c): ?>
				<li>
					<?php
					$title = str_word_count($c['title'], 1);
					$word_count = count($title);
					if ($word_count >= 3)
						$count = 2;
					else
						$count = $word_count - 1;
//					$image_size = getimagesize($c['preview_image']);
//					if(empty($c['preview_image']) || !$image_size || $c['preview_image']=='') $c['preview_image']= base_url().'images/grid_default_tradebook_thumbnail.png';
					?>
					<div class="grid-item-image">
						<a href="/user/<?php echo $c['username']; ?>">
							<span class="teammark">
	<?php echo $c['username']; ?>
							</span>
						</a>
						<a href="#">
							<img width="100%" src="<?php echo $c['preview_image']; ?>" alt="preview_image" />
						</a>
					</div>
					<div class="small_user_icon idea_info">
						<div class="profile_icon">
							<a href="/user/<?php echo $c['username']; ?>">
								<img width="20" title="BUSINS" src="<?php echo $c['avatar_image_url']; ?>" alt="<?php echo $c['username']; ?>">
							</a>
						</div>
						<div class="profile_link">
							<a class="title" href="/trade/wanted/<?php echo $c['want_id']; ?>">
								<?php
								for ($i = 0; $i <= $count; $i++)
								{
									echo $title[$i] . " ";
								}
								?>
							</a>
						</div>
						<a title="<?php echo $c['title']; ?>" class="oneline" href="/trade/wanted/<?php echo $c['want_id']; ?>">
							$<?php echo $c['price']; ?>
						</a>
					</div>

				</li>


			<?php endforeach; ?>
		</ul>
		<div class="row">
			<div class="span3">	</div>
		</div>
	</div>
</div>