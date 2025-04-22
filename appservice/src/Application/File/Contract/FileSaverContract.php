<?php

namespace App\Application\File\Contract;

interface FileSaverContract
{
    public function save(string $content): void;

}
