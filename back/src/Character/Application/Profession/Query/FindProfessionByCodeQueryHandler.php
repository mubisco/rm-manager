<?php

declare(strict_types=1);

namespace App\Character\Application\Profession\Query;

use App\Character\Domain\Profession\ProfessionCode;
use App\Character\Domain\Profession\ProfessionLanguage;
use App\Character\Domain\Profession\ProfessionNotFoundException;
use App\Character\Domain\Profession\ProfessionReadModel;
use InvalidArgumentException;
use ValueError;

class FindProfessionByCodeQueryHandler
{
    public function __construct(private readonly ProfessionReadModel $professionReadModel)
    {
    }

    /**
     * @return array<string, mixed>
     * @throws InvalidArgumentException When parameters passed are wrong
     * @throws ProfessionNotFoundException When profession not found inside model
     */
    public function __invoke(FindProfessionByCodeQuery $query): array
    {
        try {
            $lang = ProfessionLanguage::fromString($query->lang);
            $code = ProfessionCode::from($query->professionCode);
            return $this->professionReadModel->ofCode(lang: $lang, code: $code);
        } catch (ValueError $e) {
            throw new InvalidArgumentException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
