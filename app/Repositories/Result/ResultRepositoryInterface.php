<?php

namespace App\Repositories\Result;

interface ResultRepositoryInterFace
{
    public function check($input, $id);
    public function save($input ,$id);
}
