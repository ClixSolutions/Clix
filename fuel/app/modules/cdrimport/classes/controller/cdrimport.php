<?php

namespace CDRImport;

class Controller_CDRImport extends \Clients\Controller_Force
{

    public function action_index()
    {

        $this->template->title = "Calls View";
        $this->template->content = \View::forge('cdroptions');

    }

}