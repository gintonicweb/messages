<?php
namespace Messages\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Messages\Model\Table\ThreadsTable;

/**
 * Messages\Model\Table\ThreadsTable Test Case
 */
class ThreadsTableTest extends TestCase
{
    public $fixtures = [
        'plugin.messages.threads',
        'plugin.messages.messages',
        'plugin.messages.users',
        'plugin.messages.message_read_statuses',
        'plugin.messages.threads_users'
    ];

    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Threads') ? [] : ['className' => 'Messages\Model\Table\ThreadsTable'];
        $this->Threads = TableRegistry::get('Threads', $config);
    }

    public function tearDown()
    {
        unset($this->Threads);

        parent::tearDown();
    }

    public function testInitialize()
    {
        $hasMany = $this->Threads->association('Messages');
        $this->assertInstanceOf('Cake\ORM\Association\HasMany', $hasMany);
        $belongsToMany = $this->Threads->association('Users');
        $this->assertInstanceOf('Cake\ORM\Association\BelongsToMany', $belongsToMany);
    }

    public function testValidationDefault()
    {
        $thread = $this->Threads->newEntity();
        $result = $this->Threads->save($thread);
        $this->assertInstanceOf('Messages\Model\Entity\Thread', $result);
    }

    public function testFindParticipating()
    {
        $result = $this->Threads->find('participating', [1])
            ->all()
            ->extract('id')
            ->toArray();

        $this->assertEquals($result, [1]);
    }

    public function testFindOtherUsers()
    {
        $thread = $this->Threads
            ->find('participating', [1])
            ->find('otherUsers')
            ->first();

        $userId = $thread->users[0]->id;
        $this->assertEquals($userId, 2);
    }

    public function testFindReadStatus()
    {
        $thread = $this->Threads->find()
            ->find('readStatus', ['id' => 1])
            ->first();
        $this->assertTrue($thread->read);
    }

    public function testOpen()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
