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
            'notnull' => false
        ),
        'description'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'dns'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'email'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'org_name'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),
        'org_abbr'        => array(
            'type'    => 'text',
            'length'  => '255',
            'notnull' => false
        ),

    );

    $GLOBALS['DBPDO']->createTable('participants', $fields);
    $GLOBALS['DBPDO']->alterColumAutoIncrementAndPrimary('participants', 'participants_id');
}
?>
