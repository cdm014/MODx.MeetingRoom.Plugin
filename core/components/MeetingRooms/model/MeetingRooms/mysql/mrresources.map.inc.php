<?php
$xpdo_meta_map['mrResources']= array (
  'package' => 'MeetingRooms',
  'version' => '1.1',
  'table' => 'mr_resources',
  'fields' => 
  array (
    'name' => '',
    'max_amount' => 1,
    'room' => 0,
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
    'max_amount' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
    ),
    'room' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'resourceByRoom' => 
    array (
      'alias' => 'resourceByRoom',
      'primary' => false,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'name' => 
        array (
          'length' => '255',
          'collation' => 'A',
          'null' => false,
        ),
        'room' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'room' => 
    array (
      'alias' => 'room',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'room' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
  'aggregates' => 
  array (
    'Room' => 
    array (
      'class' => 'mrRooms',
      'local' => 'room',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'composites' => 
  array (
    'RequestedResources' => 
    array (
      'class' => 'mrRequestedResource',
      'local' => 'id',
      'foreign' => 'resource',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
