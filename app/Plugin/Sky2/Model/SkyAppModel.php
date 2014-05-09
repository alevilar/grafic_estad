<?php

App::uses('AppModel', 'Model');

/**
 * Sky App Model
 *
 */
class SkyAppModel extends AppModel {
    
    public $tablePrefix = 'sky_';


    public function filterDatetimeFrom($data = array())
    {
        $conditions = array();
        if (!empty($data['datetime_from'])) {
            $conditions = array(
                $this->name.'.datetime >=' => $data['datetime_from'],
            );
        }
        return $conditions;
    }



    public function filterDatetimeTo($data = array())
    {
        $conditions = array();
        if (!empty($data['datetime_to'])) {
            $conditions = array(
                $this->name.'.datetime <=' => $data['datetime_to'],
            );
        }
        return $conditions;
    }
    
    
}
