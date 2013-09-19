<?php

namespace Invoice;

class Model_Invoice
{

    // Creates a blank invoice and returns the Invoice ID
    public static function createInvoice()
    {
        list($insert_id, $rows_affected) = \DB::insert('invoices')->set(array(
            'created' => date('Y-m-d'),
        ))->execute();

        return $insert_id;
    }

    // Loads an already created Invoice
    public static function loadInvoice($id=null)
    {
        $results = \DB::select('*')->from('invoices')->where('id', $id)->execute();
        return $results[0];
    }

    // Save the invoice
    public static function saveInvoice($id=null, $details=null)
    {
        $result = \DB::update('invoices')->set($details)->where('id', $id)->execute();
    }

}