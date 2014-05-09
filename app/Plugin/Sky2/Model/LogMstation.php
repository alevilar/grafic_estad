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
        'mstation_id' => array('type' => 'query', 'method' => 'mstationFilter'),
        'status_id' => array('type' => 'value'),
        'mimo_id' => array('type' => 'query', 'method' => 'searchMimoById'),
        'dl_fec_id' => array('type' => 'value'),
        'ul_fec_id' => array('type' => 'value'),
        'sector_name' => array('type' => 'query', 'method' => 'sectorByName'),
        'carrier_name' => array('type' => 'query', 'method' => 'carrierByName'),
        'site_id' => array('type' => 'query', 'method' => 'searchSiteById'),
        'sector_id' => array('type' => 'value', 'field' => 'MsLogTable.sector_id'),
        'carrier_id' => array('type' => 'value', 'field' => 'MsLogTable.carrier_id'),
        'datetime' => array('type' => 'value', 'field' => 'MsLogTable.datetime'),
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
    
    
    public function searchSiteById ($data = array()) {
        $nsp = $conditions = array();
        
        if (isset($data['site_id'])) {
            foreach ( $data['site_id'] as $auxsp ) {
                $nsp[]['MsLogTable.site_id'] = $auxsp;
            }
            if (count($nsp) == 1) {
                $conditions['MsLogTable.site_id'] = $nsp[0];
            } else {
                $conditions['OR'] = $nsp;
            }
        }
        return $conditions;
    }
    
    public function searchMimoById ($data = array()) {
        $nsp = $conditions = array();
        
        if (isset($data['mimo_id'])) {
            foreach ( $data['mimo_id'] as $auxsp ) {
                $nsp[]['LogMstation.mimo_id'] = $auxsp;
            }
            if (count($nsp) == 1) {
                $conditions['LogMstation.mimo_id'] = $nsp[0];
            } else {
                $conditions['OR'] = $nsp;
            }
        }
        return $conditions;
    }
    
    public function mstationFilter($data = array()) {
        $conditions = array();
        if (isset($data['mstation_id'])) {
            $sp = split(",",$data['mstation_id']);
            foreach ( $sp as $auxsp ) {
                $nsp[]['LogMstation.mstation_id'] = trim($auxsp);
            }
            if (count($nsp) == 1) {
                $conditions['LogMstation.mstation_id'] = $nsp[0];
            } else {
                $conditions['OR'] = $nsp;
            }
        }
        return $conditions;
    }

    public function sectorByName($data = array()){
        $conditions = array();
        if (isset($data['sector_name'])) {
            $conditions = array(
                'Sector.name' => $data['sector_name'],
            );
        }
        return $conditions;
    }
    public function carrierByName($data = array()){
        $conditions = array();
        if (isset($data['carrier_name'])) {
            $conditions = array(
                'Carrier.name' => $data['carrier_name'],
            );
        }
        return $conditions;
    }
    
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
    
    
    public function beforeFind($queryData)
    {
        parent::beforeFind($queryData);
        if ( empty($queryData['joindata']) ) {
            // si esta vacio entonces no seguis mas...
            return true;
        }
        
        if ( empty($queryData['fields']) ) {
            $queryData['fields'] = '*';
        }
        $queryData['recursive'] = -1;
        $queryData['joins'] = array (
                    array(
                        'table' => 'sky_ms_log_tables',
                        'alias' => 'MsLogTable',
                        'type' => 'left',
                        'conditions' => array('MsLogTable.id = LogMstation.ms_log_table_id'),
                    ),
                    array(
                        'table' => 'sky_sites',
                        'alias' => 'Site',
                        'type' => 'left',
                        'conditions' => array('Site.id = MsLogTable.site_id'),
                    ),
                    array(
                        'table' => 'sky_sectors',
                        'alias' => 'Sector',
                        'type' => 'left',
                        'conditions' => array('Sector.id = MsLogTable.sector_id'),
                    ),
                    array(
                        'table' => 'sky_carriers',
                        'alias' => 'Carrier',
                        'type' => 'left',
                        'conditions' => array('Carrier.id = MsLogTable.carrier_id'),
                    ),
                    array(
                        'table' => 'sky_mimos',
                        'alias' => 'Mimo',
                        'type' => 'left',
                        'conditions' => array('Mimo.id = LogMstation.mimo_id'),
                    ),
                    array(
                        'table' => 'sky_fecs',
                        'alias' => 'DlFec',
                        'type' => 'left',
                        'conditions' => array('DlFec.id = LogMstation.dl_fec_id'),
                    ),
                    array(
                        'table' => 'sky_fecs',
                        'alias' => 'UlFec',
                        'type' => 'left',
                        'conditions' => array('UlFec.id = LogMstation.ul_fec_id'),
                    ),
                    array(
                        'table' => 'sky_modulations',
                        'alias' => 'DlModulation',
                        'type' => 'left',
                        'conditions' => array('DlModulation.id = DlFec.modulation'),
                    ),
                    array(
                        'table' => 'sky_modulations',
                        'alias' => 'UlModulation',
                        'type' => 'left',
                        'conditions' => array('UlModulation.id = UlFec.modulation'),
                    ),
                );
        
        return $queryData;
    }

}
