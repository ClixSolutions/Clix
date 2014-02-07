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
        $bonus->investment(100,250,0,'Second Test Balance');
    }

}