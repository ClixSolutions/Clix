<?php

namespace Fuel\Migrations;

class Create_bonus
{
    public function up()
    {
        \DBUtil::create_table('bonus', array(
            'id'            => array('constraint' => 11,  'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'date'          => array('type' => 'date'),
            'user'          => array('constraint' => 11,  'type' => 'int'),
            'status'        => array('constraint' => 15,  'type' => 'varchar'),
            'gbp'           => array('constraint' => '7,5', 'type' => 'float'),
            'cd'            => array('constraint' => '7,5', 'type' => 'float'),
            'comments'      => array('constraint' => 255,  'type' => 'varchar'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('bonus');
    }
}