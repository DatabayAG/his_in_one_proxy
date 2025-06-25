<#1>
<?php
if(!$GLOBALS['DBPDO']->tableExists('service_queue'))
{
    $fields = array(
        'service_id'     => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'data'         => array(
            'type'    => 'blob',
            'notnull' => false
        ),
        'func'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'receiver'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'unix_time'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'checksum'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'sent'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'lecture_id'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
    );

    $GLOBALS['DBPDO']->createTable('service_queue', $fields);
    $GLOBALS['DBPDO']->addIndex('service_queue', array('receiver'), 'rec');
    $GLOBALS['DBPDO']->addIndex('service_queue', array('checksum'), 'che');
    $GLOBALS['DBPDO']->alterColumAutoIncrementAndPrimary('service_queue', 'service_id');
}
?>
<#2>
<?php

if(!$GLOBALS['DBPDO']->tableExists('maintenance_queue'))
{
    $fields = array(
        'maintenance_id'     => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'data'         => array(
            'type'    => 'blob',
            'notnull' => false
        ),
        'func'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'receiver'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'unix_time'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
    );

    $GLOBALS['DBPDO']->createTable('maintenance_queue', $fields);
    $GLOBALS['DBPDO']->addIndex('maintenance_queue', array('receiver'), 'che');
    $GLOBALS['DBPDO']->alterColumAutoIncrementAndPrimary('maintenance_queue', 'maintenance_id');
}
?>
<#3>
<?php

if(!$GLOBALS['DBPDO']->tableExists('participants'))
{
    $fields = array(
        'participants_id'     => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'pid'         => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'mid'        => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'name'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'description'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'dns'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'email'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'org_name'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'org_abbr'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),

    );

    $GLOBALS['DBPDO']->createTable('participants', $fields);
    $GLOBALS['DBPDO']->alterColumAutoIncrementAndPrimary('participants', 'participants_id');
}
?>
<#4>
<?php
if(!$GLOBALS['DBPDO']->tableExists('link_queue'))
{
    $fields = array(
        'link_id'     => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'unit_id'     => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'term_type'   => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'term_year'        => array(
            'type'    => 'integer',
            'length'  => '4',
            'notnull' => true
        ),
        'description' => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'link'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'ecs_course_url' => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => true
        ),
        'checksum'    => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
            ),
        'sent'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
    );

    $GLOBALS['DBPDO']->createTable('link_queue', $fields);
    $GLOBALS['DBPDO']->addIndex('link_queue', array('unit_id'), 'uid');
    $GLOBALS['DBPDO']->alterColumAutoIncrementAndPrimary('link_queue', 'link_id');
}
?>
