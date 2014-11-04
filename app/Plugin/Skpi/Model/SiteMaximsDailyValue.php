<?php
App::uses('SkpiAppModel', 'Skpi.Model');
/**
 * Counter Model
 *
 * @property Sector $Sector
 */
class SiteMaximsDailyValue extends SkpiAppModel {

        
	public $belongsTo = array('Sky.Site');


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
        'site_id' => array('type' => 'query', 'method' => 'filterBySite'),
        'date' => array('field'=>'DataDay.ml_datetime','type' => 'value'),
        'date_from' => array('type' => 'query', 'method' => 'filterDateFrom'),
        'date_to' => array('type' => 'query', 'method' => 'filterDateTo'),
    );


	public function getSitesValues ($date_from = null, $date_to = null) {
		$sites = $this->Site->find('list', array('conditions'=>array('Site.deleted'=>false)));

		$sitesValues = array();
		foreach ( $sites as $sId=>$sName ) {
			$vals = $this->getSiteValue( $date_from, $date_to, $sId);
			$sitesValues[$sId] = $vals;
		}
		return $sitesValues;
	}


	/**
	 *	Devuelve los registros para un sitio en particular en un intervalo dado
	 *  Por defecto toma la fecha desde 3 dias para atras.
	 *
	 *	@param integer $site_id Id del sitio
	 *	@param string $date_from Fecha desde. Toma -3 dias por defecto
	 *	@param string $date_to fecha hasta. Toma "now" por defecto 
	 *
	 */
	public function getSiteValue ( $date_from = null, $date_to = null, $site_id = null) {


		// set default value for date from
		$conds = array(
				'DATE(SiteMaximsDailyValue.ml_datetime) >=' => date('Y-m-d', strtotime('-3 day') ),
				'DATE(SiteMaximsDailyValue.ml_datetime) <=' => date('Y-m-d'),
			);


		if ( !empty($site_id) ) {
			$conds['SiteMaximsDailyValue.site_id'] = $site_id;
		}

		
		
		if ( !empty($date_from) ) {
			$conds['DATE(SiteMaximsDailyValue.ml_datetime) >='] = $date_from;
		}


		// set default value for date  to
		if ( !empty($date_to) ) {
			$conds['DATE(SiteMaximsDailyValue.ml_datetime) <='] = $date_to;			
		}

		return $this->find('all', array(
				'conditions' => $conds,
				'order' => array('SiteMaximsDailyValue.ml_datetime ASC')
				));
	}



	public function filterDateFrom($data = array())
    {
        $conditions = array();
        if (!empty($data['date_from'])) {
            $conditions = array(
                $this->name . '.ml_datetime >=' => $data['date_from'],
            );
        }
        return $conditions;
    }

    public function filterDateTo($data = array())
    {
        $conditions = array();
        if (!empty($data['date_to'])) {
            $conditions = array(
                $this->name . '.ml_datetime <=' => $data['date_to'],
            );
        }
        return $conditions;
    }
    

}

