<?php

namespace App\Repository;

interface YoutubeRepositoryInterface
{
    public function fetch(String $id): array;
}