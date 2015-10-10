<?php
namespace Messages\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Messages\Controller\ThreadsController;

/**
 * Messages\Controller\threadsController Test Case
 */
class ThreadsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.messages.users',
        'plugin.messages.threads',
        'plugin.messages.threads_users',
        'plugin.messages.messages',
        'plugin.messages.message_read_statuses',
    ];

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $controller = new ThreadsController();
        $controller->initialize();
        $result = $controller->components()->loaded();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/messages/threads/add.json');
        $this->assertResponseOk();

        $data = [
            'user' => '1',
            'thread' => [
                'title' => 'fdsafd'
            ],
            'message' => [
                'body' => 'aaa'
            ]
        ];
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 2
                ]
            ]
        ]);

        $this->post('/messages/threads/add.json', $data);
        $this->assertResponseOk();

        $usersTable = TableRegistry::get('Messages.Threads');
        $threadCount = $usersTable->find()->count();
        $this->assertEquals($threadCount, 2);
    }

}
