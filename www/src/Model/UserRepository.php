<?php

declare(strict_types=1);

namespace Student\SlimSkeleton\Model;

interface UserRepository
{
    public function save(User $user): void;
}