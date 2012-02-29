 <?php
 /**
  * @package MeetingRooms
  */
  require_once(strtr(realpath(dirname(dirname(__FILE__))), '\\', '/').'/mrrequestedresource.class.php');
  class mrRequestedResource_mysql extends mrRequestedResource {}
  ?>