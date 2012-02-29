 <?php
 /**
  * @package MeetingRooms
  */
  require_once(strtr(realpath(dirname(dirname(__FILE__))), '\\', '/').'/mrrequests.class.php');
  class mrRequests_mysql extends mrRequests {}
  ?>