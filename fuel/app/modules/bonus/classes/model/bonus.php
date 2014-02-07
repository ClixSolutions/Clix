<?php

namespace Bonus;

class Model_Bonus
{

    public static function getCurrentStatuses($status)
    {
        $results = \DB::select(array())
            ->from('bonus')
            ->where('status', $status)
            ->execute()
            ->as_array();

        return $results;
    }



    public static function addTransaction($status, $gbp, $cd, $comments='', $user=null)
    {

    }

}