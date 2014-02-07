<?php

namespace Bonus;

class Bonus
{
    const INCOMING = "INCOMING";
    const ASSIGNED = "ASSIGNED";
    const OUTGOING = "OUTGOING";

    const CD2GBP = "CD2GBP";
    const GBP2CD = "GBP2CD";

    const subRate = 0.01;

    protected $_bonusFund = 0;      // Amount of GBP available
    protected $_bonusFundCD = 0;    // Amount of ClixDollah available
    protected $_assignedCD = 0;
    protected $_availableCD = 0;
    protected $_exchangeRateCD2GBP = 0;
    protected $_exchangeRateGBP2CD = 0;



    public function sellCD($value, $userid, $comments='', $doublePoints=false)
    {
        $gbpValue = ($doublePoints)
            ? ($value * $this->_getExchangeRate(Bonus::CD2GBP)) * 2
            : ($value * $this->_getExchangeRate(Bonus::CD2GBP));
        Model_Bonus::addTransaction(Bonus::OUTGOING, $gbpValue, $value, $comments, $userid);
        $this->_setAllImportants();
        return $this;
    }

    public function assignCD($value, $userID, $comments='')
    {
        Model_Bonus::addTransaction(Bonus::ASSIGNED, 0, $value, $comments, $userID);
        $this->_setAllImportants();
        return $this;
    }

    public function investment($gbpValue, $cdValue, $userID=0, $comments='')
    {
        Model_Bonus::addTransaction(Bonus::INCOMING, $gbpValue, $cdValue, $comments, $userID);
        $this->_setAllImportants();
        return $this;
    }


    // **********
    // Public Getters Go Here
    // **********

    public function getExchangeRate($conversion=null)
    {
        return $this->_getExchangeRate($conversion);
    }

    public function getAssignedCD()
    {
        return $this->_getAssignedCD();
    }

    public function getAvailableCD()
    {
        return $this->_getAvailableCD();
    }

    public function getBonusFund()
    {
        return $this->_getBonusFund();
    }

    public function getBonusFundCD()
    {
        return $this->_getBonusFundCD();
    }





    // **********
    // Protected Getters Go Here
    // **********

    protected function _getExchangeRate($conversion=null)
    {
        if (is_null($conversion))
        {
            throw new \Exception("No Conversion direction given.");
        }
        else
        {
            if ($this->_getBonusFundCD() == 0)
            {
                $exchangeRate = 1;
            }
            else
            {
                $exchangeRate = ($conversion == Bonus::CD2GBP)
                    ? ($this->_getBonusFund() * (0.5  - Bonus::subRate)) / $this->_getBonusFundCD()
                    : $this->_getBonusFundCD() / ($this->_getBonusFund() * (0.5 - Bonus::subRate));
            }
            return $exchangeRate;
        }
    }

    protected function _getAssignedCD()
    {
        return $this->_assignedCD;
    }

    protected function _getAvailableCD()
    {
        return $this->_availableCD;
    }

    protected function _getBonusFund()
    {
        return $this->_bonusFund;
    }

    protected function _getBonusFundCD()
    {
        return $this->_bonusFundCD;
    }


    // **********
    // Protected Setters Go Here
    // **********

    protected function _setAssignedCD()
    {
        $totalAssigned = $this->_sum('cd', Model_Bonus::getCurrentStatuses(Bonus::ASSIGNED));
        $totalOutgoing = $this->_sum('cd', Model_Bonus::getCurrentStatuses(Bonus::OUTGOING));
        $this->_assignedCD = $totalAssigned - $totalOutgoing;
        return $this;
    }

    protected function _setBonusFundCD()
    {
        $totalIncoming = $this->_sum('cd', Model_Bonus::getCurrentStatuses(Bonus::INCOMING));
        $totalOutgoing = $this->_sum('cd', Model_Bonus::getCurrentStatuses(Bonus::OUTGOING));
        $this->_bonusFundCD = $totalIncoming - $totalOutgoing;
        return $this;
    }

    protected function _setBonusFund()
    {
        $totalIncoming = $this->_sum('gbp', Model_Bonus::getCurrentStatuses(Bonus::INCOMING));
        $totalOutgoing = $this->_sum('gbp', Model_Bonus::getCurrentStatuses(Bonus::OUTGOING));
        $this->_bonusFund = $totalIncoming - $totalOutgoing;
        return $this;
    }

    protected function _setAvailableCD()
    {
        $this->_availableCD = $this->_getBonusFundCD() - $this->_getAssignedCD();
        return $this;
    }


    // **********
    // Other protected functions
    // **********

    protected function _sum($field, $array)
    {
        $sum = 0;
        foreach ($array as $single)
        {
            $sum = (isset($single[$field]))
                ? $sum + $single[$field]
                : $sum;
        }
        return $sum;
    }

    protected function _setAllImportants()
    {
        $this->_setBonusFund()->_setBonusFundCD()->_setAssignedCD()->_setAvailableCD();
        return $this;
    }



    // **********
    // Constructors and Destructors
    // **********

    public function __construct()
    {
        $this->_setAllImportants();
        return $this;
    }

}