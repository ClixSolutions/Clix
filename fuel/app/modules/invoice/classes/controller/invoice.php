<?php

namespace Invoice;

class Controller_Invoice extends \Clients\Controller_Force
{


    public function action_index()
    {

        $testInvoice = Invoice::load(1);


        print_r($testInvoice);

        print_r($testInvoice->generate(Invoice::ARR));

        print "Hello";
    }

}