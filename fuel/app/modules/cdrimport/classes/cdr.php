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
        return $this;
    }

    public function statusCompleted()
    {
        $this->_setStatus(4);
        return $this;
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
                    'cost'             => $data['Cost (pounds)'],
                ));
                $totalCost = ($totalCost + $data['Cost (pounds)']);
            }
        }
        $this->_callsMade = ($recordNumber -1);
        $this->_totalCost = $totalCost;
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
            $this->_import();
        }
        else
        {
            $this->_id = $id;
            $this->load();
        }
    }

}