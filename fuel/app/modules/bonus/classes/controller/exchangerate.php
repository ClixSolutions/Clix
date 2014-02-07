<?php

namespace Bonus;

class Controller_Exchangerate extends \Controller_Rest
{

    public function get_gbptocd()
    {
        $bonus = new Bonus();
        $exchangeRate = $bonus->getExchangeRate(Bonus::GBP2CD);

        return $this->response(array(
            'exchangeRate' => $exchangeRate,
            'totalBonusFund' => $bonus->getBonusFund(),
            'totalBonusFundCD' => $bonus->getBonusFundCD(),
            'assigned' => $bonus->getAssignedCD(),
            'available' => $bonus->getAvailableCD(),
        ));
    }

    public function get_cdtogbp()
    {
        $bonus = new Bonus();
        $exchangeRate = $bonus->getExchangeRate(Bonus::CD2GBP);

        return $this->response(array(
            'exchangeRate' => $exchangeRate,
        ));
    }

}