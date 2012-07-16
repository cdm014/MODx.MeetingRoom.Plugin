<?php
/**
 * @package MeetingRooms
 */
$xpdo_meta_map['mrRequests']= array (
  'package' => 'MeetingRooms',
  'version' => '1.1',
  'table' => 'mr_requests',
  'fields' => 
  array (
    'name' => '',
    'libraryCard' => '',
    'email' => '',
    'phone' => '',
    'group' => '',
    'meetingType' => '',
    'start' => NULL,
    'end' => NULL,
    'requestNumber' => '',
    'room' => 0,
    'status' => 0,
    'notes' => NULL,
    'adults' => 0,
    'children' => 0,
    'teens' => 0,
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
    'libraryCard' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '14',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => true,
      'default' => '',
    ),
    'phone' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '14',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'group' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'meetingType' => 
    array (
      'dbtype' => 'tinytext',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'start' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'end' => 
    array (
      'dbtype' => 'datetime',
      'phptype' => 'datetime',
      'null' => false,
    ),
    'requestNumber' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '30',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
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
    'status' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'notes' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => true,
    ),
    'adults' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'children' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
    'teens' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
  ),
  'indexes' => 
  array (
    'libraryCard' => 
    array (
      'alias' => 'libraryCard',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'libraryCard' => 
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
    'start' => 
    array (
      'alias' => 'start',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'start' => 
        array (
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'requestNumber' => 
    array (
      'alias' => 'requestNumber',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'requestNumber' => 
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
    'ResourceRequest' => 
    array (
      'class' => 'mrRequestedResource',
      'local' => 'id',
      'foreign' => 'request',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
