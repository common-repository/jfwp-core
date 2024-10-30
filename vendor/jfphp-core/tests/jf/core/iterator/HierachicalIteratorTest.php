<?php
namespace jf\core\iterator;

use jf\core\object\HierachicalStdObject;

/**
 * Test class for HierachicalIterator.
 * Generated by PHPUnit on 2011-02-09 at 08:29:59.
 */
class HierachicalIteratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var HierachicalIterator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $data = array('property1' => 'value1',
                      'property2' => 'value2',
                      'child1' => array('property1' => 'value1', 'property2' => 'value2'),
                      'child2' => array('property1' => 'value1', 
                      					'property2' => 'value2',
                                        'subchild1' => array('property1' => 'value1', 'property2' => 'value2'),
                                        'subchild2' => array('property1' => 'value1', 'property2' => 'value2')));
        
        $this->object = new HierachicalIterator(new HierachicalStdObject('root', $data));
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testCurrent().
     */
    public function testCurrent()
    {
        $this->assertEquals('child1', $this->object->current()->getId()); 
        $this->object->next();
        $this->assertEquals('child2', $this->object->current()->getId());    
    }

    /**
     * @todo Implement testKey().
     */
    public function testKey()
    {
        $this->assertEquals(0, $this->object->key());    
        $this->object->next();
        $this->assertEquals(1, $this->object->key());  
    }

    /**
     * @todo Implement testNext().
     */
    public function testNext()
    {
        $this->assertEquals('child2', $this->object->next()->getId());   
    }

    /**
     * @todo Implement testRewind().
     */
    public function testRewind()
    {
        $this->object->next();
        $this->object->rewind();
        $this->assertEquals(0, $this->object->key());    
    }

    /**
     * @todo Implement testValid().
     */
    public function testValid()
    {
        $this->object->next();
        $this->assertTrue($this->object->valid());
        $this->object->next();
        $this->assertFalse($this->object->valid());
    }

    /**
     * @todo Implement testHasChildren().
     */
    public function testHasChildren()
    {
        $this->assertFalse($this->object->hasChildren());
        $this->object->next();
        $this->assertTrue($this->object->hasChildren());
    }

    /**
     * @todo Implement testGetChildren().
     */
    public function testGetChildren()
    {
       $this->object->next();
       $this->assertInstanceOf('jf\core\iterator\HierachicalIterator', $this->object->getChildren());
    }
}
?>