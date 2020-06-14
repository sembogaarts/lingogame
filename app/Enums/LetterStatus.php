<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LetterStatus extends Enum
{
    const Correct = 'valid';
    const Incorrect = 'invalid';
    const WrongPosition = 'misplaced';
}

