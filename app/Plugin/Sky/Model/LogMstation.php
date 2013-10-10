<?php

App::uses('SkyAppModel', 'Sky.Model');

/**
 * SkyLogMstation Model
 *
 * @property MsLogTable $MsLogTable
 * @property Status $Status
 */
class LogMstation extends SkyAppModel
{

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'mstation_id';
    public $order = array('LogMstation.ms_log_table_id DESC');
    public $actsAs = array(
        'Search.Searchable',
    );

    /**
     * Filter search fields
     *
     * @var array
     * @access public
     */
    public $filterArgs = array(
        'mstation_id' => array('type' => 'like'),
        'status_id' => array('type' => 'value'),
        'mimo_id' => array('type' => 'value'),
        'dl_fec_id' => array('type' => 'value'),
        'ul_fec_id' => array('type' => 'value'),
        'site_id' => array('type' => 'value', 'field' => 'MsLogTable.site_id'),
        'sector_id' => array('type' => 'value', 'field' => 'MsLogTable.sector_id'),
        'carrier_id' => array('type' => 'value', 'field' => 'MsLogTable.carrier_id'),
        'datetime' => array('type' => 'value', 'field' => 'MsLogTable.site_id'),
        'datetime_from' => array('type' => 'query', 'method' => 'filterDatetimeFrom'),
        'datetime_to' => array('type' => 'query', 'method' => 'filterDatetimeTo'),
        'retcode_id' => array('type' => 'value', 'field' => 'MsLogTable.retcode_id'),
        'om_id' => array('type' => 'value', 'field' => 'MsLogTable.om_id'),
        'comand_number' => array('type' => 'value', 'field' => 'MsLogTable.comand_number'),
    );

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'mstation_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'status_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'mstation_pwr' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dl_cinr' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ul_cinr' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dl_rssi' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ul_rssi' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dl_fec_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ul_fec_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dl_repetitionfatctor' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ul_repetitionfatctor' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'dl_mimo_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'benum' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'nrtpsnum' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'rtpsnum' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ertpsnum' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ugsnum' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ul_per_for_an_ms' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'ni_value' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Sky.MsLogTable',
        'Sky.Status',
        'Sky.Mimo',
        'DlFec' => array(
            'className' => 'Sky.Fec',
            'foreignKey' => 'dl_fec_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'UlFec' => array(
            'className' => 'Sky.Fec',
            'foreignKey' => 'ul_fec_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public function filterDatetimeFrom($data = array())
    {
        $conditions = array();
        if (!empty($data['datetime_from'])) {
            $conditions = array(
                'MsLogTable.datetime >=' => $data['datetime_from'],
            );
        }
        return $conditions;
    }

    public function filterDatetimeTo($data = array())
    {
        $conditions = array();
        if (!empty($data['datetime_to'])) {
            $conditions = array(
                'MsLogTable.datetime <=' => $data['datetime_to'],
            );
        }
        return $conditions;
    }

}
