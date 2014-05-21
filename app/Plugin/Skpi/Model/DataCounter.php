 <?php
App::uses('AppModel', 'Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class DataCounter extends AppModel {
    
    public $useDbConfig = 'migration_db';


    public function getDataCounter ($what, $what_id, $counterId, $date_from, $date_to ) {

		$fn = $what.'_get_objectnos';
    	$objectnos = $this->{$fn}( $what_id, $counterId, $date_from, $date_to );    	


    	$Counter = ClassRegistry::init('Skpi.Counter');
        $Counter->recursive = -1;


        

        // Get Counter DL
        $Counter->id = $counterId;
        $counter = $Counter->read();
        $counterColName = $counter['Counter']['col_name'];

		$data_metrics = $this->find('all', array(
			'conditions' => array(
				'DataCounter.objectno' => $objectnos, // Hardcodedo como si fuese un sitio
				'DataCounter.date_time >=' => $date_from,
				'DataCounter.date_time <=' => $date_to,
				),
			'order' => array(
				'DataCounter.date_time ASC'
				),
			'group' => array(
				'DataCounter.date_time',
				),
			'fields' => array(
				'DataCounter.date_time',			
				'AVG(DataCounter.'.$counterColName.') as avg',
				)
			));

		$metrics = array();
		foreach ($data_metrics as $dm ) {
			$timestamp = strtotime ( '-3 hour' , strtotime($dm['DataCounter']['date_time']) ) ;
			$timestamp = $timestamp * 1000; // para JS hay que multiplicarlo por 1000 por los ms
			$metrics[] = array( $timestamp, $dm[0]['avg'] );
		}

		$metrics = array(
			'Counter' => $counter,
			'DataCounter' => $metrics,
			);
		return $metrics;

    }
    

    public function carrier_get_objectnos (  $carrier_id, $counterId, $date_from, $date_to ) {
    	$Carrier = ClassRegistry::init('Skpi.Carrier');
    	$Carrier->recursive = -1;
    	$carr = $Carrier->read(null, $carrier_id);
    	return $carr['Carrier']['objectno'];
    }


    public function sector_get_objectnos (  $sector_id, $counterId, $date_from, $date_to ) {
    	$Sector = ClassRegistry::init('Skpi.Sector');
        $Sector->recursive = -1;
        $objectnos = $Sector->listCarriers($sector_id, 'objectno');

		return $objectnos;      
    }


    public function site_get_objectnos ( $site_id, $counterId, $date_from, $date_to) {
    	$Site = ClassRegistry::init('Skpi.Site');
        $Site->recursive = -1;
        $objectnos = $Site->listCarriers($site_id, 'objectno');

		return $objectnos;        
    }
    
    
}

