<?php

namespace Clients;

class Client
{

    protected $_id;
    protected $_name;
    protected $_status;
    protected $_joinDate;


    public function statusNew()
    {
        $this->_setStatus(1);
        return $this;
    }



    protected function _setStatus($status)
    {
        Model_Client::Set_Status($this->_id, $status);
        return $this;
    }

    protected function _save()
    {

    }

    protected function _load()
    {

    }


    public static function load($id=null)
    {
        return new Client(null, $id);
    }

    public function __construct($details=null, $id=null)
    {
        if (!is_null($details))
        {
            $this->_id = Model_Client::Create_Client();
            $this->statusNew();
        }
        else
        {
            $this->_id = $id;
            $this->_load();
        }
    }


}