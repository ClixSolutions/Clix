<?php

namespace CDRImport;

class Model_Cdr
{

    public static function Create_CDR($file=null)
    {
        if (is_null($file))
        {
            throw \Exception("No CDR File Given");
        }
        else
        {
            list($insert_id, $rows_affected) = \DB::insert('cdr')->set(array(
                'received'   => date('Y-m-d'),
                'calls_made' => 0,
                'total_cost' => 0,
                'status'     => 1,
            ))->execute();
            return $insert_id;
        }
    }

    public static function Load_CDR($id)
    {
        $results = \DB::select('*')->from('cdr')->where('id', $id)->execute();
        return $results[0];
    }

    public static function Save_CDR($id=null, $details=null)
    {
        $result = \DB::update('cdr')->set($details)->where('id', $id)->execute();
    }

    public static function Add_CDR_Record($data=null)
    {

    }


}