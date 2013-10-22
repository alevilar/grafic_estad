<?php

class FirstMigrationKms extends CakeMigration
{

    /**
     * Migration description
     *
     * @var string
     * @access public
     */
    public $description = '';

    /**
     * Actions to be performed
     *
     * @var array $migration
     * @access public
     */
    public $migration = array(
        'up' => array(
            'create_field' => array(
                'users' => array(
                    'twitter' => array(
                        'type' => 'string',
                        'length' => '94',
                        'null' => true,
                        'default' => NULL
                    ),
                    'facebook' => array(
                        'type' => 'string',
                        'length' => '94',
                        'null' => true,
                        'default' => NULL
                    ),
                    'google_plus' => array(
                        'type' => 'string',
                        'length' => '94',
                        'null' => true,
                        'default' => NULL
                    ),
                    'linkedin' => array(
                        'type' => 'string',
                        'length' => '94',
                        'null' => true,
                        'default' => NULL
                    ),
                    'skills' => array(
                        'type' => 'string',
                        'length' => '254',
                        'null' => true,
                        'default' => NULL
                    ),
                    'generally_about' => array(
                        'type' => 'text',
                        'null' => true,
                        'default' => NULL
                    ),
                    'my_favourite_tags' => array(
                        'type' => 'string',
                        'length' => '254',
                        'null' => true,
                        'default' => NULL
                    ),
                    'kms_writing' => array(
                        'type' => 'boolean',
                        'null' => false,
                        'default' => false
                    ),
                    'kms_reading' => array(
                        'type' => 'boolean',
                        'null' => false,
                        'default' => false
                    ),
                    'kms_editing' => array(
                        'type' => 'boolean',
                        'null' => false,
                        'default' => false
                    ),
                    'kms_traveling' => array(
                        'type' => 'boolean',
                        'null' => false,
                        'default' => false
                    ),
                    'kms_others' => array(
                        'type' => 'boolean',
                        'null' => false,
                        'default' => false
                    ),
                    'allow_contact' => array(
                        'type' => 'boolean',
                        'null' => true,
                        'default' => 0
                    ),
                ),
            ),
        ),
        'down' => array(
            'drop_field' => array(
                'users' => array(
                    'twitter',
                    'facebook',
                    'google_plus',
                    'linkedin',
                    'skills',
                    'generally_about',
                    'my_favourite_tags',
                    'kms_writing',
                    'kms_reading',
                    'kms_editing',
                    'kms_traveling',
                    'kms_others',
                    'allow_contact',
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
