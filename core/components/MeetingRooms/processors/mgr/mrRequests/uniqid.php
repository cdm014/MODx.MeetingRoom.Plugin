<?php
$group = '';
$name = '';
$prefix = '';
if (!empty($scriptProperties['group'])) {
	$group = $scriptProperties['group'];
	$prefix = substr($group,0,7);
}
return uniqid($prefix,true);

