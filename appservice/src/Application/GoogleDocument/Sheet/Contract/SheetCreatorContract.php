<?php

namespace App\Application\GoogleDocument\Sheet\Contract;

interface SheetCreatorContract
{
    public function create(string $title): string;

}
