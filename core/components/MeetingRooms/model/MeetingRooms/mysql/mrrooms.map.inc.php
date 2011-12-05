<?php
$xpdo_meta_map['mrRooms']= array (
  'package' => 'MeetingRooms',
  'version' => '1.1',
  'table' => 'mr_rooms',
  'fields' => 
  array (
    'name' => '',
    'address' => '',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'address' => 
    array (
      'dbtype' => 'tinytext',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'indexes' => 
  array (
    'name' => 
    array (
      'alias' => 'name',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'name' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'composites' => 
  array (
    'Requests' => 
    array (
      'class' => 'mrRequests',
      'local' => 'id',
      'foreign' => 'room',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
    'Resources' => 
    array (
      'class' => 'mrResources',
      'local' => 'id',
      'foreign' => 'room',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
