<?php

namespace CDRImport;

class Cdr
{

    protected $_id;
    protected $_fileName;
    protected $_received;
    protected $_callsMade;
    protected $_totalCost;
    protected $_status;



    // *****************
    // Setter Methods

    public function statusNew()
    {
        $this->_setStatus(1);
        return $this;
    }

    public function statusImporting()
    {
        $this->_setStatus(2);
        return $this;
    }

    public function statusImportComplete()
    {
        $this->_setStatus(3);
        $this->_importCompleteEMail();
        return $this;
    }

    public function statusCompleted()
    {
        $this->_setStatus(4);
        return $this;
    }

    public function setDate($date)
    {
        $this->_received = $date;
        $this->_save();
    }

    public function importCompleteEMail()
    {
        $this->_importCompleteEMail();

    }

    protected function _importCompleteEMail()
    {
        $email = \Email::forge();

        $email->from('noreply@clixsolutions.co.uk', 'Clix Solutions');

        $email->to(array(
            'cdrcomplete@clixsolutions.co.uk'  => 'CDR Complete',
        ));

        $email->priority(\Email::P_HIGH);

        $email->subject('New CDR Imported');


        $email->html_body(\View::forge('emails/importcomplete', array(
            'cdrDate'   => $this->_received,
            'callsMade' => $this->_callsMade,
            'totalCost' => $this->_totalCost,
        )));

        $email->send();
    }


    // *****************
    // Protected Methods

    protected function _import()
    {
        $this->statusImporting()->_parseCDR()->statusImportComplete();
        return $this;
    }

    protected function _save()
    {
        Model_Cdr::Save_CDR($this->_id, array(
            'received' => $this->_received,
            'calls_made' => $this->_callsMade,
            'total_cost' => $this->_totalCost,
            'status' => $this->_status,
        ));
        return $this;
    }

    protected function _setStatus($status)
    {
        $this->_status = $status;
        $this->_save();
        return $this;
    }

    protected function _load()
    {
        $results = Model_Cdr::Load_CDR($this->_id);

        $this->_received = $results['received'];
        $this->_callsMade = $results['calls_made'];
        $this->_totalCost = $results['total_cost'];
        $this->_status = $results['status'];
        return $this;
    }


    protected function _parseCDR()
    {
        $allData = \Format::forge(\File::read(DOCROOT."public/uploads/cdr/".$this->_fileName, true), 'csv')->to_array();


        $recordNumber = 0;
        $totalCost = 0;
        foreach ($allData as $data)
        {
            $recordNumber++;
            if ($recordNumber > 1)
            {
                Model_Cdr::Add_CDR_Record(array(
                    'cdr_id'           => $this->_id,
                    'ip'               => $data['IP'],
                    'answer_time'      => $data['Answer time'],
                    'end_time'         => $data['End time'],
                    'time_band'        => $data['Time band'],
                    'duration'         => $data['Duration'],
                    'number_presented' => $data['Number presented'],
                    'number_dialled'   => $data['Number dialled'],
                    'prefix'           => $data['Prefix'],
                    'cost'             => number_format(ceil(($data['Cost (pounds)']*100000))/100000,5),
                    'client_cost'      => number_format(ceil(($data['Cost (pounds)']*100))/100,2),
                ));
                $totalCost = ($totalCost + $data['Cost (pounds)']);
            }
        }
        $this->_callsMade = ($recordNumber -1);
        $this->_totalCost = number_format((ceil(($totalCost*100000))/100000),5);
        $this->_save();

        return $this;
    }


    // *****************
    // Load Methods

    public function load($id=null)
    {
        return new Cdr(null, $id);
    }

    public function __construct($file=null, $existingID=null)
    {
        if (!is_null($file))
        {
            $newID = Model_Cdr::Create_CDR($file);
            $this->_fileName = $file;
            $this->statusNew();
            $this->_id = $newID;
            $this->_received = $existingID;
            $this->_import();
        }
        else
        {
            $this->_id = $existingID;
            $this->load();
        }
    }

}