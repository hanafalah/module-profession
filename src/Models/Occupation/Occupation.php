<?php

namespace Hanafalah\ModuleProfession\Models\Occupation;

use Hanafalah\ModuleProfession\{
    Models\Profession\Profession,
    Enums\Profession\Flag
};

class Occupation extends Profession
{
    protected $table = 'professions';

    protected static function booting(): void
    {
        static::setFlags(Flag::OCCUPATION->value);
    }

    protected static function booted(): void
    {
        parent::booted();

        static::creating(function ($query) {
            if (!isset($query->flag)) $query->flag = Flag::OCCUPATION->value;
        });
    }
}
