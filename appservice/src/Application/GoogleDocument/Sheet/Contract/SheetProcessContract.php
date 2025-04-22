<?php


namespace App\Application\GoogleDocument\Sheet\Contract;
interface SheetProcessContract
{
    public function process(array $data): string;

}