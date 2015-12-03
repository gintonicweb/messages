<?php
namespace Messages\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ThreadsUsersFixture
 *
 */
class ThreadsUsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'thread_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
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
            'thread_id' => 1,
            'user_id' => 1,
            'created' => '2015-10-10 03:40:55'
        ],
        [
            'thread_id' => 1,
            'user_id' => 2,
            'created' => '2015-10-10 03:40:55'
        ],
        [
            'thread_id' => 3,
            'user_id' => 1,
            'created' => '2015-10-10 03:40:55'
        ],
        [
            'thread_id' => 3,
            'user_id' => 2,
            'created' => '2015-10-10 03:40:55'
        ],
    ];
}
