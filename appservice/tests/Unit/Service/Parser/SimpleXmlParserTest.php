<?php

namespace App\Tests\Unit\Service\Parser;

use App\Infrastructure\Parser\SimpleXmlParser;
use PHPUnit\Framework\TestCase;

class SimpleXmlParserTest extends TestCase
{
    private SimpleXmlParser $parser;

    protected function setUp(): void
    {
        $this->parser = new SimpleXmlParser();
    }

    public function testParseReturnsArrayFromValidXml(): void
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<catalog>
    <item>
        <id>1</id>
        <name>Coffee</name>
    </item>
</catalog>
XML;

        $expected = [
            'item' => [
                'id' => '1',
                'name' => 'Coffee'
            ]
        ];

        $result = $this->parser->parse($xml);

        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

}
