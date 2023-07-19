<?php

namespace App\Character\Domain\Profession;

interface ProfessionReadModel
{
    /**
     * @throws ProfessionNotFoundException
     * @return array<string, mixed>
     */
    public function ofCode(ProfessionLanguage $lang, ProfessionCode $code): array;
}
