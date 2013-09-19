<?php

namespace Fuel\Migrations;

class Create_invoice
{
    public function up()
    {
        \DBUtil::create_table('invoices', array(
            'id'           => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
            'client_id'    => array('constraint' => 11, 'type' => 'int'),
            'created'      => array('type' => 'date'),
            'status'       => array('constraint' => 11, 'type' => 'int'),
            'value'        => array('constraint' => '7,2', 'type' => 'float'),
            'totalValue'   => array('constraint' => '7,2', 'type' => 'float'),
            'totalPaid'    => array('constraint' => '7,2', 'type' => 'float'),
            'dueDate'      => array('type' => 'date'),
        ), array('id'));
    }

    public function down()
    {
        \DBUtil::drop_table('invoices');
    }
}