<?php

namespace App\Core\Invoice\Application\Command\CreateInvoice;

use App\Core\Invoice\Domain\Invoice;
use App\Core\Invoice\Domain\Repository\InvoiceRepositoryInterface;
use App\Core\User\Domain\Aggregates\UserAggregate;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateInvoiceHandler
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly UserRepositoryInterface $userRepository,
		private readonly UserAggregate $userAggregate,
    ) {}

    public function __invoke(CreateInvoiceCommand $command): void
    {
		$user = $this->userRepository->getByEmail($command->email);
	
		$this->userAggregate->determineIfUserIsActive($user);
		
		$this->invoiceRepository->save(new Invoice($user, $command->amount));
		$this->invoiceRepository->flush();
	
	}
}
