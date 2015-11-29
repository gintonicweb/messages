<?php
namespace Messages\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MessageReadStatusesFixture
 *
 */
class MessageReadStatusesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'message_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
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
            'message_id' => 1,
            'user_id' => 1,
            'status' => 1,
            'created' => '2015-10-10 03:42:07',
            'modified' => '2015-10-10 03:42:07'
        ],
        [
            'message_id' => 1,
            'user_id' => 2,
            'status' => 0,
            'created' => '2015-10-10 03:42:07',
            'modified' => '2015-10-10 03:42:07'
        ],
        [
            'message_id' => 2,
            'user_id' => 1,
            'status' => 0,
            'created' => '2015-10-10 03:42:07',
            'modified' => '2015-10-10 03:42:07'
        ],
        [
            'message_id' => 2,
            'user_id' => 2,
            'status' => 1,
            'created' => '2015-10-10 03:42:07',
            'modified' => '2015-10-10 03:42:07'
        ],
    ];
}
