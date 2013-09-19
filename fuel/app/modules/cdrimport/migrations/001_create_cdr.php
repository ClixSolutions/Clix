<?php

namespace Fuel\Migrations;

class Create_cdr
{
    public function up()
    {
        \DBUtil::create_table('cdr', array(
            'id'                => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'received'          => array('type' => 'date'),
            'calls_made'        => array('constraint' => 11, 'type' => 'int'),
            'total_cost'        => array('constraint' => '7,2', 'type' => 'float'),
            'status'            => array('constraint' => 11, 'type' => 'int'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('cdr');
    }
}