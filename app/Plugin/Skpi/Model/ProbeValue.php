<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * ProbeValue Model
 *
 * @property Probe $Probe
 */
class ProbeValue extends SkpiAppModel {

	public $tablePrefix = '';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	 public $actsAs = array(
        'Search.Searchable',
    );


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Probe' => array(
			'className' => 'Skpi.Probe',
			'foreignKey' => 'probe_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	/**
     * Filter search fields
     *
     * @var array
     * @access public
     */
    public $filterArgs = array(
        'date_time' =>  array('type' => 'value'),
        'date_from' => array('type' => 'value', 'field' => 'DATE(ProbeValue.date_time) >='),
        'date_to'   =>  array('type' => 'value', 'field' => 'DATE(ProbeValue.date_time) <='),
    );


    public function medicionesList () {
    	return $this->ProbeValue->find('list', array(
			'group' => array('ProbeValue.date_time'),
			'fields' => array('ProbeValue.date_time', 'ProbeValue.date_time'),
			'order' => array('ProbeValue.date_time DESC'),
			));
    }

}
