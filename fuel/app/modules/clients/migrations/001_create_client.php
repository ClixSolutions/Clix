<?php

namespace Fuel\Migrations;

class Create_client
{
    public function up()
    {
        \DBUtil::create_table('client', array(
            'id'            => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'name'          => array('constraint' => 255, 'type' => 'varchar'),
            'status'        => array('constraint' => 11,  'type' => 'int'),
            'join_date'     => array('type' => 'date'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('client');
    }
}