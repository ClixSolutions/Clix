<?php

namespace Fuel\Migrations;

class Create_client_sip_rate
{
    public function up()
    {
        \DBUtil::create_table('client_sip_rate', array(
            'id'             => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'client_id'      => array('constraint' => 11,  'type' => 'int'),
            'start_date'     => array('type' => 'date'),
            'end_date'       => array('type' => 'date'),
            'mobile_rate'    => array('constraint' => '7,5', 'type' => 'float'),
            'landline_rate'  => array('constraint' => '7,5', 'type' => 'float'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('client_sip_rate');
    }
}