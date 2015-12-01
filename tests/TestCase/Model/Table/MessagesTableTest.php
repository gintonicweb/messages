<?php
namespace Messages\Test\TestCase\Model\Table;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Messages\Model\Table\MessagesTable;

/**
 * Messages\Model\Table\MessagesTable Test Case
 */
class MessagesTableTest extends TestCase
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
        'plugin.messages.message_read_statuses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Messages') ? [] : ['className' => 'Messages\Model\Table\MessagesTable'];
        $this->Messages = TableRegistry::get('Messages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Messages);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $belongsTo = $this->Messages->association('Users');
        $this->assertInstanceOf('Cake\ORM\Association\BelongsTo', $belongsTo);

        $belongsTo = $this->Messages->association('Threads');
        $this->assertInstanceOf('Cake\ORM\Association\BelongsTo', $belongsTo);

        $hasMany = $this->Messages->association('MessageReadStatuses');
        $this->assertInstanceOf('Cake\ORM\Association\HasMany', $hasMany);
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $data = [
            'user_id' => 1,
            'thread_id' => 1,
            'body' => 'This is a new message',
        ];
        $message = $this->Messages->newEntity();
        $this->Messages->patchEntity($message, $data);
        $message = $this->Messages->save($message, $data);
        $this->assertInstanceOf('Messages\Model\Entity\Message', $message);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $data = [
            'user_id' => 3,
            'thread_id' => 1,
            'body' => 'This is a new message',
        ];
        $message = $this->Messages->newEntity();
        $this->Messages->patchEntity($message, $data);
        $result = $this->Messages->save($message, $data);
        $this->assertFalse($result);

        $data = [
            'user_id' => 1,
            'thread_id' => 3,
            'body' => 'This is a new message',
        ];
        $message = $this->Messages->newEntity();
        $this->Messages->patchEntity($message, $data);
        $result = $this->Messages->save($message, $data);
        $this->assertFalse($result);
    }

    public function testFindReadStatus()
    {
        $message = $this->Messages->find()
            ->find('readStatus', ['id' => 1])
            ->where(['id' => 1])
            ->first();
        $this->assertTrue($message->read);

        $message = $this->Messages->find()
            ->find('readStatus', ['id' => 2])
            ->where(['id' => 1])
            ->first();
        $this->assertFalse($message->read);
    }

    public function testGetRecent()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
