<?php
//*
//load assets/components/MeetingRooms/js/mgr/MeetingRooms.js
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/MeetingRooms.js');
$modx->regClientStartupScript($mrManager->config['jsUrl'].'mgr/Widgets/rooms.combobox.js');
//*/
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
	MeetingRooms.config = '.$modx->toJSON($mrManager->config).';
});
</script>');

return '';