<?php

namespace App\Infrastructure\Parser;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;

use App\Application\Parser\Contract\XmlParserContract;

#[AsAlias(XmlParserContract::class)]
class SimpleXmlParser implements XmlParserContract
{
    public function parse(string $xmlContent): array
    {
       $content = simplexml_load_string($xmlContent);
       return json_decode(json_encode($content), true);

    }

}