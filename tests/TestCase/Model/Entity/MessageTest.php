<?php
namespace Messages\Test\TestCase\Model\Entity;

use Cake\TestSuite\TestCase;
use Messages\Model\Entity\Message;

/**
 * Messages\Model\Entity\Message Test Case
 */
class MessageTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Message = new Message();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Message);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
