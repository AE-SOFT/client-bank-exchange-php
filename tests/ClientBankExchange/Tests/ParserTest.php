<?php

namespace AE\Tools1C\Tests\ClientBankExchange;

use AE\Tools1C\ClientBankExchange\Parser;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-04-10 at 17:43:47.
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    protected $object = null;

    protected function setUp()
    {
        $dp_item = $this->goodFileProvider()[0];
        $file = $dp_item[0];

        $this->object = new Parser($file);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::__construct
     * @dataProvider goodFileProvider
     */
    public function test__constructGood($file, $encoding, $count)
    {
        $parser = new Parser($file, $encoding);
        $this->assertCount($count, $parser->documents);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::__construct
     * @dataProvider badFileProvider
     * @expectedException AE\Tools1C\ClientBankExchange\Exception
     */
    public function test__constructBad($file)
    {
        $parser = new Parser($file, 'cp1251');
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::parse_file
     */
    public function testParse_file()
    {
        $dp_item = $this->goodFileProvider()[0];
        $file = $dp_item[0];
        $this->object->parse_file($file);
        $this->assertNotEmpty($this->object->documents);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::parse
     */
    public function testParse()
    {
        $dp_item = $this->goodFileProvider()[0];
        $file = $dp_item[0];
        $this->object->parse(file_get_contents($file));
        $this->assertNotEmpty($this->object->documents);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::general
     */
    public function testGeneral()
    {
        $this->assertEquals('Windows', $this->object->general->{'Кодировка'});
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::filter
     */
    public function testFilter()
    {
        $this->assertEquals('11.01.2016', $this->object->filter->{'ДатаНачала'});
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::remainings
     */
    public function testRemainings()
    {
        $this->assertEquals(45329.910000000003, $this->object->remainings->{'НачальныйОстаток'});
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::documents
     */
    public function testDocuments()
    {
        $this->assertNotEmpty($this->object->documents);
        $this->assertEquals(697162, $this->object->documents[0]->{'Номер'});
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::offsetSet
     */
    public function testOffsetSet()
    {
        $this->object['general'] = 123;
        $this->assertEquals(123, $this->object['general']);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::offsetExists
     */
    public function testOffsetExists()
    {
        $this->assertTrue(isset($this->object['general']));
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::offsetUnset
     */
    public function testOffsetUnset()
    {
        unset($this->object['general']);
        $this->assertEquals($this->object['general'], null);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::offsetGet
     */
    public function testOffsetGet()
    {
        $this->assertNotEmpty($this->object['general']);
    }

    /**
     * @covers AE\Tools1C\ClientBankExchange\Parser::__get
     */
    public function test__get()
    {
        $this->assertNotEmpty($this->object->general);
    }

    public function goodFileProvider()
    {
        $path = dirname(dirname(__DIR__)).'/resources';

        return [
            [$path.'/one_day.txt', 'cp1251', 13],
            [$path.'/one_day_utf8.txt', 'utf-8', 13],
            [$path.'/huge.txt', 'cp1251', 9783],
        ];
    }

    public function badFileProvider()
    {
        $path = dirname(dirname(__DIR__)).'/resources';

        return [
            ['/nonexistent'],
        ];
    }
}
