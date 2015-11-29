<?php
namespace Messages\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use Messages\Model\Entity\MessageReadStatus;

/**
 * Messages\Model\Entity\MessageReadStatus Test Case
 */
class MessageReadStatusTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->MessageReadStatus = new MessageReadStatus();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MessageReadStatus);

        parent::tearDown();
    }

    /**
     * Test types method
     *
     * @return void
     */
    public function testTypes()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test enum method
     *
     * @return void
     */
    public function testEnum()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
