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
        $this->get('/api/threads/index.json');
        $this->assertResponseSuccess();

        $result = json_decode($this->_response->body(), true);

        // Assert that we only get the thread we're participating in
        $this->assertEquals(count($result['threads']), 2);
        $this->assertEquals($result['threads'][0]['id'], 1);

        // Assert that only other users are shown in the thread
        $this->assertEquals(count($result['threads'][0]['users']), 1);
        $this->assertEquals($result['threads'][0]['users'][0]['id'], 2);
        $this->assertTrue(isset($result['threads'][0]['messages']));
    }

    public function testLatest()
    {
        $this->get('/api/threads/latest.json');
        $this->assertResponseSuccess();

        $result = json_decode($this->_response->body(), true);

        $this->assertEquals($result['thread']['id'], 3);
        $this->assertTrue(isset($result['messages']));
    }

    public function testView()
    {
        $response = $this->get('/api/threads/view/1.json');
        $this->assertResponseSuccess();

        $result = json_decode($this->_response->body(), true);

        $this->assertEquals($result['thread']['id'], 1);
        $this->assertEquals(count($result['messages']), 2);
        $this->assertTrue(isset($result['messages'][0]['user']), 1);
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

        $this->assertEquals(count($thread), 1);
        $this->assertEquals(count($thread->messages), 1);
        $this->assertEquals(count($thread->messages[0]->message_read_statuses), 2);
    }

    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
