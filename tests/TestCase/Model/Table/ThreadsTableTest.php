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

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.messages.threads',
        'plugin.messages.messages',
        'plugin.messages.users',
        'plugin.messages.message_read_statuses',
        'plugin.messages.threads_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Threads') ? [] : ['className' => 'Messages\Model\Table\ThreadsTable'];
        $this->Threads = TableRegistry::get('Threads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Threads);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $hasMany = $this->Threads->association('Messages');
        $this->assertInstanceOf('Cake\ORM\Association\HasMany', $hasMany);
        $belongsToMany = $this->Threads->association('Users');
        $this->assertInstanceOf('Cake\ORM\Association\BelongsToMany', $belongsToMany);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $thread = $this->Threads->newEntity();
        $result = $this->Threads->save($thread);
        $this->assertInstanceOf('Messages\Model\Entity\Thread', $result);
    }

    /**
     * Test findParticipating method
     *
     * @return void
     */
    public function testFindParticipating()
    {
        $result = $this->Threads->find('participating', [1])
            ->all()
            ->extract('id')
            ->toArray();

        $this->assertEquals($result, [1]);
    }

    /**
     * Test findOtherUsers method
     *
     * @return void
     */
    public function testFindOtherUsers()
    {
        $thread = $this->Threads
            ->find('participating', [1])
            ->find('otherUsers')
            ->first();

        $userId = $thread->users[0]->id;
        $this->assertEquals($userId, 2);
    }

    /**
     * Test findSummary method
     *
     * @return void
     */
    public function testFindSummary()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test open method
     *
     * @return void
     */
    public function testOpen()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
