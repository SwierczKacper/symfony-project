<?php

namespace App\Core\User\Application\Query\GetEmailsOfInactiveUsers;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetEmailsOfInactiveUsersHandler
{
	public function __construct(
		private readonly UserRepositoryInterface $userRepository
	) {}
	
	public function __invoke(GetEmailsOfInactiveUsersQuery $query): array
	{
		$users = $this->userRepository->getByActiveStatus(false);
		
		return array_map(static function (User $user) {
			return new UserDTO(
				$user->getId(),
				$user->getEmail(),
				$user->isActive()
			);
		}, $users);
	}
}
