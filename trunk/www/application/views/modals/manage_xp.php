<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4>Manage XP <small>on connected accounts</small></h4>
</div>
<div class="modal-body">
	<?php if (isset($users) AND is_array($users)): ?>
		<table class="table">
			<thead>
				<tr class="tbl-header">
					<th>Username</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>XP</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<?php foreach ($user as $k => $v): ?>
							<td>
								<?php if ($k == 'username'): ?>
								<a href="<?= base_url().'user/member/'.$v; ?>"><?= $v ?></a>
								<?php else: ?>
									<?= $v ?>
								<?php endif; ?>
							</td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>        
		</table>
	<?php endif; ?>
</div>
<div class="modal-footer">
	<a href="#" class="btn">Close</a>
	<a href="#" class="btn btn-primary">Save changes</a>
</div>