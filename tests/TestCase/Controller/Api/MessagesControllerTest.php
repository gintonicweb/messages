<?php
namespace Messages\Test\TestCase\Controller\Api;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;
use Messages\Controller\Api\MessagesController;

/**
 * Messages\Controller\MessagesController Test Case
 */
class MessagesControllerTest extends IntegrationTestCase
{

    public $fixtures = [
        'plugin.messages.messages',
        'plugin.messages.users',
        'plugin.messages.threads',
        'plugin.messages.threads_users',
        'plugin.messages.message_read_statuses',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'Phil',
                ]
            ]
        ]);
        $this->configRequest([
            'headers' => ['Accept' => 'application/json']
        ]);
    }

    public function tearDown()
    {
        TableRegistry::remove('Messages');
        TableRegistry::remove('Threads');
        TableRegistry::remove('MessageReadStatuses');
    }

    public function testAdd()
    {
        $data = [
            'user_id' => 1,
            'thread_id' => 3,
            'body' => 'This is a new message',
        ];

        $this->post('/api/messages/add', $data);
        $this->assertResponseSuccess();


        $messagesTable = TableRegistry::get('Messages');
        $query = $messagesTable->find()->where(['body' => $data['body']]);

        $this->assertEquals($query->count(), 1);

        $message = $query->first()->toArray();
        $this->assertEquals($message['thread_id'], $data['thread_id']);

        $viewVariables = $this->viewVariable('_ws');
        $this->assertEquals($viewVariables['data']['user']['id'], $data['user_id']);
    }
}
