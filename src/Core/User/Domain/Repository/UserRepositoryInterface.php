<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\User;

interface UserRepositoryInterface
{
	public function getByActiveStatus(bool $active);
	
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;
	
	public function save(User $user): void;
}
