<?php
namespace Messages\Test\TestCase\Controller;

use Cake\TestSuite\IntegrationTestCase;
use Messages\Controller\MessagesController;

/**
 * Messages\Controller\MessagesController Test Case
 */
class MessagesControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.messages.messages',
        'plugin.messages.users',
        'plugin.messages.threads',
        'plugin.messages.threads_users',
        'plugin.messages.message_read_statuses',
    ];

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
