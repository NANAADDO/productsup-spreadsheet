<?php


namespace App\Application\GoogleDocument\Sheet\Contract;
interface SheetCreatrContract
{
    public function create(string $title): string;

}