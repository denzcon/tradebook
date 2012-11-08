<div class="modal-header" style="height:70px">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 style="display:block;">Manage XP <small>on connected accounts</small></h4>
	<h1 class="manage_xp_header_user_xp_value"><small style="font-size:12px;">you have: </small><span><?= $current_xp[0]['xp_value'];  ?></span>xp</h1>
</div>
<div class="modal-body manage_xp">
	<?php if (isset($users) AND is_array($users)): ?>
		<table class="table">
			<thead>
				<tr class="tbl-header">
					<th>Username</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Actions</th>
					<th>XP</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<?php foreach ($user as $k => $v): ?>
						
								<?php if ($k == 'xp_value'): ?>
							<td>
								<span>
									<input type="text" name="addXP" id="addXP" value="0" style="color: rgb(0, 136, 204); font-weight: bold; width: 36px;" class="scrollable_input"/>
									<i style="float: right;" class="icon icon-arrow-up "></i>
									<i style="float: right; clear: right; margin-top: -24px;" class="icon icon-arrow-down"></i>
								</span>
							</td>
								<?php endif; ?>
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