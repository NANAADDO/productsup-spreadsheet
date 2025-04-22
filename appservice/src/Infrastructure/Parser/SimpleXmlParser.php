<?php

namespace App\Infrastructure\Parser;

use App\Application\Parser\Contract\XmlParserContract;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(XmlParserContract::class)]
class SimpleXmlParser implements XmlParserContract
{
    public function parse(string $xmlContent): array
    {
        $content = simplexml_load_string($xmlContent);

        return json_decode(json_encode($content), true);

    }

}
