<?php

namespace Fuel\Migrations;

class Create_client_server
{
    public function up()
    {
        \DBUtil::create_table('client_server', array(
            'id'                => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'client_id'         => array('constraint' => 11,  'type' => 'int'),
            'server_ip'         => array('constraint' => 255, 'type' => 'varchar'),
            'server_name'       => array('constraint' => 255, 'type' => 'varchar'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('client_server');
    }
}