<?php

namespace App\Application\Parser\Contract;

interface XmlParserContract
{
    /**
     * @return list<array{name: string, price: float}>
     */
    public function parse(string $xmlContent): array;
}
