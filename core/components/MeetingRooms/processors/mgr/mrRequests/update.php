<?php
//get request
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('MeetingRooms.request_err_ns'));
return $modx->error->failure('<pre>'.print_r($scriptProperties,true).'</pre>');