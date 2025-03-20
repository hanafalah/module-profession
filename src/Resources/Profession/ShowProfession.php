<?php

namespace Zahzah\ModuleProfession\Resources\Profession;

use Zahzah\LaravelSupport\Resources\ApiResource;

class ShowProfession extends ViewProfession
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [

        ];
        $arr = array_merge(parent::toArray($request),$arr);
        
        return $arr;
    }
}

