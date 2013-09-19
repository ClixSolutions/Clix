<?php

namespace Invoice;

class Controller_Invoice extends \Clients\Controller_Force
{


    public function action_index()
    {

        $testInvoice = Invoice::load(3);


        print_r($testInvoice);

        print_r($testInvoice->generate(Invoice::ARR));

        $testInvoice->statusFullyPaid();

        print_r($testInvoice->generate(Invoice::ARR));


        print "Hello";
    }

}