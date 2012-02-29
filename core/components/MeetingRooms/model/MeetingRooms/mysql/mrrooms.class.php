 <?php
 /**
  * @package MeetingRooms
  */
  require_once(strtr(realpath(dirname(dirname(__FILE__))), '\\', '/').'/mrrooms.class.php');
  class mrRooms_mysql extends mrRooms {}
  ?>