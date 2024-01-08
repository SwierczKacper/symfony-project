<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Aggregates;

use App\Core\User\Domain\Exception\UserInactiveException;
use App\Core\User\Domain\User;

class UserAggregate
{
	public function determineIfUserIsActive(User $user): void
	{
		if(!$user->isActive()) {
			throw new UserInactiveException("Użytkownik nie jest aktywny.");
		}
	}
}