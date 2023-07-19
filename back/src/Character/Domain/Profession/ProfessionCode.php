<?php

declare(strict_types=1);

namespace App\Character\Domain\Profession;

enum ProfessionCode: string
{
    case CLERIC = 'cleric';
    case FIGHTER = 'fighter';
    case ROGUE = 'rogue';
    case RANGER = 'ranger';
    case MAGE = 'mage';
    case MONK = 'monk';
    case THIEF = 'thief';
    case WARRIOR_MAGE = 'warrior_mage';
    case HARPER = 'harper';
}
