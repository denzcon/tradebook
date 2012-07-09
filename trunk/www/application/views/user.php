<div class="container-fluid">
    <div class="row-fluid">
		<div class="page-header">
			<h1>My <span class="hiliteTBBlue">trade</span><span class="hiliteTBGray">book</span></h1>
		</div>
		<div class="span3">
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
		<div class="content span8">
			
			<div class="span3">
				<ul>
					<?php foreach ($wants as $want) : ?>
						<li><?= $want['title']; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
    </div>
</div>