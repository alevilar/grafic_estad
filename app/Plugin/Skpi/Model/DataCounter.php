 <?php
App::uses('AppModel', 'Model');
/**
 * DataKpiCounter Model
 *
 * @property Sector $Sector
 */
class DataCounter extends AppModel {
    
    public $useDbConfig = 'migration_db';
    

    public function getDataForSiteCounter ( $site_id, $counterId, $date_from, $date_to) {

        $Counter = ClassRegistry::init('Skpi.Counter');
        $Counter->recursive = -1;

        // Get Counter DL
        $Counter->id = $counterId;
        $counter = $Counter->read();
        $counterColName = $counter['Counter']['col_name'];

		$data_metrics = $this->find('all', array(
			'conditions' => array(
				'DataCounter.objectno' => array(17,18,19,20,21,22,23,24), // Hardcodedo como si fuese un sitio
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
    
    
}

