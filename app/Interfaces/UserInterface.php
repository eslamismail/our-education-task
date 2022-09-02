<?php

namespace App\Interfaces;

interface UserInterface
{
    public function filter(array $data = []): array;
}
