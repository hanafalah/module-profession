<?php

namespace Hanafalah\ModuleProfession\Resources\Profession;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ShowProfession extends ViewProfession
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [];
        $arr = array_merge(parent::toArray($request), $arr);

        return $arr;
    }
}
