<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\Invoice\Application\DTO\InvoiceDTO;
use App\Core\Invoice\Application\Query\GetInvoicesByStatusAndAmountGreater\GetInvoicesByStatusAndAmountGreaterQuery;
use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Application\Query\GetEmailsOfInactiveUsers\GetEmailsOfInactiveUsersQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
	name: 'app:user:get-emails-of-inactive-users',
	description: 'Pobieranie adresów email nieaktywnych użytkowników'
)]
class GetInactiveUsersEmails extends Command
{
	public function __construct(private readonly QueryBusInterface $bus)
	{
		parent::__construct();
	}
	
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$users = $this->bus->dispatch(new GetEmailsOfInactiveUsersQuery());
		
		/** @var UserDTO $user */
		foreach ($users as $user) {
			$output->writeln($user->email);
		}
		
		return Command::SUCCESS;
	}
	
	protected function configure(): void
	{
	}
}
