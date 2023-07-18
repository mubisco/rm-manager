<?php

declare(strict_types=1);

namespace App\Character\Application\Profession\Query;

use App\Character\Domain\Profession\ProfessionLanguage;
use App\Character\Domain\Profession\ProfessionNamesReadException;
use App\Character\Domain\Profession\ProfessionNamesReadModel;
use App\Shared\Application\QueryHandlerInterface;
use InvalidArgumentException;

class FindProfessionNamesQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProfessionNamesReadModel $readModel)
    {
    }
    /**
     * @return array<int, string>
     * @throws InvalidArgumentException
     * @throws ProfessionNamesReadException
     */
    public function __invoke(FindProfessionNamesQuery $query): array
    {
        $lang = ProfessionLanguage::fromString($query->lang);
        return $this->readModel->ofLanguage($lang);
    }
}
