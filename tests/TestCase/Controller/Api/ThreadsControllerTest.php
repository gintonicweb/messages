<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ThreadsController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\ThreadsController Test Case
 */
class ThreadsControllerTest extends IntegrationTestCase
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

        $this->Threads = TableRegistry::get('Threads');
        $this->Threads->hasMany('Messages');
        $this->Threads->Messages->hasMany('MessageReadStatuses');
    }

    public function tearDown()
    {
        TableRegistry::remove('Messages');
        TableRegistry::remove('Threads');
        TableRegistry::remove('MessageReadStatuses');
    }

    public function testIndex()
    {
        $response = $this->get('/api/threads/index.json');
        $this->assertResponseSuccess();
    }

    public function testLatest()
    {
        $response = $this->get('/api/threads/index.json');
        $this->assertResponseSuccess();
    }

    public function testView()
    {
        $response = $this->get('/api/threads/index.json');
        $this->assertResponseSuccess();
    }

    public function testAdd()
    {
        $data = [
            'thread' => ['title' => 'Test Title'],
            'message' => ['body' => 'Test content'],
            'users' => ['2'],
        ];
        $this->post('/api/threads/add', $data);
        $this->assertResponseSuccess();

        $thread = $this->Threads->find()
            ->where(['title' => $data['thread']['title']])
            ->contain(['Messages' => ['MessageReadStatuses']])
            ->first();

        $this->markTestIncomplete('Not implemented yet.');
        $this->assertEquals(count($thread), 1);
        $this->assertEquals(count($thread->messages), 1);
        $this->assertEquals(count($thread->messages[0]->message_read_statuses), 2);
    }

    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
