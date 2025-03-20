<?php

namespace Zahzah\ModuleProfession\Schemas;

use Zahzah\LaravelSupport\Supports\PackageManagement;
use Zahzah\ModuleProfession\Contracts\Profession as ContractsProfession;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Zahzah\ModuleProfession\Resources\Profession\ShowProfession;
use Zahzah\ModuleProfession\Resources\Profession\ViewProfession;
use Zahzah\ModuleTransaction\Schemas\PriceComponent;

class Profession extends PackageManagement implements ContractsProfession{
    protected array $__guard   = ['id', 'parent_id', 'name'];
    protected array $__add     = ['name','flag'];
    protected string $__entity = 'Profession';
    public static $profession_model;

    protected array $__resources = [
        'view' => ViewProfession::class,
        'show' => ShowProfession::class
    ];

    protected array $__cache = [
        'index' => [
            'name'     => 'profession',
            'tags'     => ['profession','profession-index'],
            'forever'  => true
        ]
    ];

    public function getProfession(): mixed{
        return static::$profession_model;
    }

    public function prepareShowProfession(? Model $model = null): ?Model{
        $this->booting();

        $model ??= $this->getProfession();
        $id = request()->id;
        if (!request()->has('id')) throw new \Exception('No id provided',422);

        if (!isset($model)) $model = $this->profession()->find($id);
        return static::$profession_model = $model;
    }

    public function showProfession(? Model $model = null): array{
        return $this->transforming($this->__resources['show'],fn()=>$this->prepareShowProfession($model));
    }

    public function prepareStoreProfession(? array $attributes = null): Model {
        $attributes ??= request()->all();

        $profession = $this->ProfessionModel()->updateOrCreate([
            'id' => $attributes['id'] ?? null
        ],[
            'name' => $attributes['name'],
            'flag' => $attributes['flag']
        ]);

        $price_component = $this->schemaContract('price_component');
        $price_component->prepareStorePriceComponent($this->assocRequest(
            'tariff_components',
            ...[
                'model_id'   => $profession->getKey(),
                'model_type' => $profession->getMorphClass(),
            ],
        ));

        static::$profession_model = $profession;
        $profession->load('tariffComponents');
        $this->flushTagsFrom('index');

        return $profession;
    }

    public function storeProfession(): array{
        return $this->transaction(function(){
            return $this->showProfession($this->prepareStoreProfession());
        });
    }

    public function prepareViewProfessionList(): Collection{
        return static::$profession_model = $this->cacheWhen(!$this->isSearch(),$this->__cache['index'],function(){
            $professions = $this->profession()->with('tariffComponents')->whereNull('parent_id')->orderBy('name','asc')->get();
            foreach ($professions as $profession) {
                $this->inheritenceLoad($profession,'childs',function($query){
                    $query->with('tariffComponents');
                });
            }
            return $professions;
        });
    }

    public function viewProfessionList(): array{
        return $this->transforming($this->__resources['view'], fn() => $this->prepareViewProfessionList());
    }

    public function profession(mixed $conditionals = null): Builder{
        return $this->ProfessionModel()->conditionals($conditionals);
    }

    public function addOrChange(? array $attributes=[]): self{
        $this->updateOrCreate($attributes);
        return $this;
    }
}
