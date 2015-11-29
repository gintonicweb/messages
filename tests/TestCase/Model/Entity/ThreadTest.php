<?php
namespace Messages\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use Messages\Model\Entity\Thread;

/**
 * Messages\Model\Entity\Thread Test Case
 */
class ThreadTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Thread = new Thread();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Thread);

        parent::tearDown();
    }

    /**
     * Test addMessage method
     *
     * @return void
     */
    public function testAddMessage()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
