<?php

class FirstMigrationWorkflow extends CakeMigration
{

    /**
     * Migration description
     *
     * @var string
     * @access public
     */
    public $description = 'First Setup';

    /**
     * Actions to be performed
     *
     * @var array $migration
     * @access public
     */
    public $migration = array(
        'up' => array(
            'create_table' => array(
                'states' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                    'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
                    'order' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
                    'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
                ),
                'state_tables' => array(
                    'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
                    'role_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
                    'type_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
                    'state_from' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
                    'state_to' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
                    'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
                    'indexes' => array(
                        'PRIMARY' => array('column' => 'id', 'unique' => 1)
                    ),
                    'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
                ),
            ),
            'create_field' => array(
                'nodes' => array(
                    'state_id' => array(
                        'type' => 'integer',
                        'length' => '10',
                        'null' => true,
                        'default' => NULL
                    ),
                ),
            ),
        ),
        'down' => array(
            'drop_table' => array(
                'states', 'state_tables',
            ),
            'drop_field' => array(
                'nodes' => array(
                    'state_id',
                ),
            ),
        ),
    );

    /**
     * Before migration callback
     *
     * @param string $direction, up or down direction of migration process
     * @return boolean Should process continue
     * @access public
     */
    public function before($direction)
    {
        return true;
    }

    /**
     * After migration callback
     *
     * @param string $direction, up or down direction of migration process
     * @return boolean Should process continue
     * @access public
     */
    public function after($direction)
    {
        return true;
    }

}
