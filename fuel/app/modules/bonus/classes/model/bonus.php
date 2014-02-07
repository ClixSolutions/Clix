<?php

namespace Bonus;

class Model_Bonus
{

    public static function getCurrentStatuses($status)
    {
        $results = \DB::select('*')
            ->from('bonus')
            ->where('status', $status)
            ->execute()
            ->as_array();

        return (count($results) > 0)
            ? $results
            : array();
    }



    public static function addTransaction($status, $gbp, $cd, $comments='', $user=0)
    {
        \DB::insert('bonus')
            ->set(array(
                'date'      => date('Y-m-d'),
                'user'      => $user,
                'status'    => $status,
                'gbp'       => $gbp,
                'cd'        => $cd,
                'comments'  => $comments,
            ))
            ->execute();

        return true;
    }

}