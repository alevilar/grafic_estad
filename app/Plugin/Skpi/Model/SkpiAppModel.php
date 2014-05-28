<?php

App::uses('AppModel', 'Model');

/**
 * Sky App Model
 *
 */
class SkpiAppModel extends AppModel {
    
    public $tablePrefix = 'skpi_';


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



    public function filterDateFrom($data = array())
    {
        $conditions = array();
        if (!empty($data['date_from'])) {
            $conditions = array(
                $this->name . '.ml_date >=' => $data['date_from'],
            );
        }
        return $conditions;
    }

    public function filterDateTo($data = array())
    {
        $conditions = array();
        if (!empty($data['date_to'])) {
            $conditions = array(
                $this->name . '.ml_date <=' => $data['date_to'],
            );
        }
        return $conditions;
    }
    
    
}
