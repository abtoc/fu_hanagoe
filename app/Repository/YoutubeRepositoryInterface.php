<?php

namespace App\Repository;

interface YoutubeRepositoryInterface
{
    public function search(String $q);
    public function fetch(String $id): array;
}