<?php

namespace Invoice;

class Invoice
{

    const HTML = "html";
    const ARR  = "array";
    const PDF  = "pdf";

    protected $_id;
    protected $_client_id;
    protected $_created;
    protected $_status;
    protected $_items;
    protected $_value;
    protected $_totalValue;
    protected $_payments;
    protected $_totalPaid;
    protected $_remaining;
    protected $_dueDate;




    // *****************
    // Setter Methods

    // The invoice has just been generated
    public function statusNew()
    {
        $this->_changeStatus(1);
        return $this;
    }

    // The invoice has been read by the client
    public function statusRead()
    {
        $this->_changeStatus(2);
        return $this;
    }

    // The invoice has received a partial payment
    public function statusPartialPaid()
    {
        $this->_changeStatus(3);
        return $this;
    }

    // The invoice has been paid in full
    public function statusFullyPaid()
    {
        $this->_changeStatus(4);
        return $this;
    }

    // The invoice is being contested
    public function statusContested()
    {
        $this->_changeStatus(-1);
        return $this;
    }

    // The invoice has baan abandoned
    public function statusAbandoned()
    {
        $this->_changeStatus(-2);
        return $this;
    }

    // The invoice was generated in error
    public function statusInvalid()
    {
        $this->_changeStatus(-3);
        return $this;
    }


    // *****************
    // Viewing Methods

    public function generate($style=Invoice::ARR)
    {
        switch ($style)
        {
            case Invoice::HTML:
                return $this->_returnHTML();
                break;
            case Invoice::ARR:
                return $this->_returnArray();
                break;
            case Invoice::PDF:
                return $this->_returnPDF();
                break;
            default:
                return $this->_returnArray();
                break;
        }
    }


    // *****************
    // Protected Methods

    // Changes the status of the invoice
    protected function _changeStatus($newStatus=null)
    {
        if (!is_null($newStatus))
        {
            $this->_status = $newStatus;
        }
        else
        {
            throw new \Exception("No new Status set.");
        }

        $this->_save();
        return $this;
    }

    // Creates an invoice from the given data
    protected function _create($content)
    {
        // Create a blank invoice
        $this->_id = Model_Invoice::createInvoice();
        $this->_import();
        return $this;
    }

    // Import the data from the database into the class
    protected function _import()
    {
        $loadedInvoice = Model_Invoice::loadInvoice($this->_id);

        $this->_client_id   = $loadedInvoice['client_id'];
        $this->_created     = $loadedInvoice['created'];
        $this->_status      = $loadedInvoice['status'];
        $this->_value       = $loadedInvoice['value'];
        $this->_totalValue  = $loadedInvoice['totalValue'];
        $this->_totalPaid   = $loadedInvoice['totalPaid'];
        $this->_dueDate     = $loadedInvoice['dueDate'];

        return $this;
    }

    // Saves any updates to the database
    protected function _save()
    {
        Model_Invoice::saveInvoice($this->_id, $this->generate(Invoice::ARR));
        return $this;
    }


    // *****************
    // Generate Methods

    // Return the invoice in formatted HTML
    protected function _returnHTML()
    {
        return "";
    }

    // Return the invoice in Array format
    protected function _returnArray()
    {
        return Array(
            'client_id'  => $this->_client_id,
            'created'    => $this->_created,
            'status'     => $this->_status,
            'value'      => $this->_value,
            'totalValue' => $this->_totalValue,
            'totalPaid'  => $this->_totalPaid,
            'dueDate'    => $this->_dueDate,
        );
    }

    // Return the filename of a generated PDF
    protected function _returnPDF()
    {
        return "";
    }


    // *****************
    // Load Methods

    // Load an invoice with the given ID
    public static function load($id=null)
    {
        return new Invoice(null, $id);
    }

    // Create a new invoice based on the content that is sent
    public function __construct($content=null, $invoiceID=null)
    {
        if (is_null($invoiceID))
        {
            $this->_create($content);
        }
        else
        {
            $this->_id = $invoiceID;
            $this->_import();
        }
        return $this;
    }

}