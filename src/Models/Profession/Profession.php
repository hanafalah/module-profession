<?php

namespace Zahzah\ModuleProfession\Models\Profession;

use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleProfession\Enums\Profession\Flag;
use Zahzah\ModuleTransaction\Concerns\HasPriceComponent;

class Profession extends BaseModel{
    use HasPriceComponent;

    public $timestamps  = false; 
    protected $fillable = ['id','parent_id','flag','name'];
    protected static array $__flags = [];

    protected static function booting(): void{
        static::setFlags(Flag::PROFESSION->value);
    }

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn(static::$__flags);
        });
    }

}