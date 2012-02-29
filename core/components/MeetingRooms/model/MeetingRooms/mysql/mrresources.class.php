 <?php
 /**
  * @package MeetingRooms
  */
  require_once(strtr(realpath(dirname(dirname(__FILE__))), '\\', '/').'/mrresources.class.php');
  class mrResources_mysql extends mrResources {}
  ?>