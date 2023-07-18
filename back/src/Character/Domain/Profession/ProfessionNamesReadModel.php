<?php

namespace App\Character\Domain\Profession;

interface ProfessionNamesReadModel
{
    /**
     * @throws ProfessionNamesReadException
     * @return array<int, mixed>
     */
    public function ofLanguage(ProfessionLanguage $lang): array;
}
