<?php

namespace App\Application\Parser\Contract;
interface XmlParserContract
{
    public function parse(string $xmlContent): array;
}