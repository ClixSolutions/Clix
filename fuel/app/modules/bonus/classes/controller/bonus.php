<?php

namespace Bonus;

class Controller_Bonus extends \Clients\Controller_Force
{

    public function action_index()
    {

    }

    public function action_test()
    {
        $bonus = new Bonus();
        $bonus->investment(100,100,0,'Starting Balance');
    }

}