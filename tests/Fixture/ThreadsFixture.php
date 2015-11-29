<?php
namespace Messages\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ThreadsFixture
 *
 */
class ThreadsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'title' => 'Lorem ipsum dolor sit amet',
            'created' => '2015-10-10 03:38:20',
            'modified' => '2015-10-10 03:38:20'
        ],
        [
            'title' => 'This is a thread with no users',
            'created' => '2015-10-10 03:38:20',
            'modified' => '2015-10-10 03:38:20'
        ],
    ];
}
