<?php ?>
<style type="text/css">
	.fbJewel .jewelCount {
		border-radius: 2px 2px 2px 2px;
		color: #FFFFFF;
		font-size: 9px;
		font-weight: bold;
		overflow: hidden;
		padding-bottom: 1px;
		position: absolute;
		right: -1px;
		top: 0;
		z-index: 101;
	}
</style>
<div id="fbRequestsJewel" class="fbJewel">
	<a aria-owns="fbRequestsFlyout" aria-haspopup="true" data-target="fbRequestsFlyout" data-gt="{&quot;ua_id&quot;:&quot;jewel:requests&quot;}" name="requests" aria-labelledby="requestsCountWrapper" role="button" href="#" rel="toggle" class="jewelButton">
		<span id="requestsCountWrapper" class="jewelCount">
			<span id="requestsCountValue">0</span>
			<i class="accessible_elem"> Requests</i>
		</span>
	</a>
</div>
<div id="fbMessagesJewel" class="fbJewel">
	<a aria-owns="fbMessagesFlyout" aria-haspopup="true" data-target="fbMessagesFlyout" data-gt="{&quot;ua_id&quot;:&quot;jewel:mercurymessages&quot;}" name="mercurymessages" aria-labelledby="mercurymessagesCountWrapper" role="button" href="#" rel="toggle" class="jewelButton">
		<span id="mercurymessagesCountWrapper" class="jewelCount">
			<span id="mercurymessagesCountValue">0</span>
			<i class="accessible_elem"> Messages</i>
		</span>
	</a>
</div>
<div id="fbNotificationsJewel" class="fbJewel west hasNew">
	<a name="notifications" aria-labelledby="notificationsCountWrapper" role="button" href="#" rel="toggle" class="jewelButton">
		<span id="notificationsCountWrapper" class="jewelCount">
			<span id="notificationsCountValue">2</span>
			<i class="accessible_elem"> Notifications</i>
		</span>
	</a>
</div>
