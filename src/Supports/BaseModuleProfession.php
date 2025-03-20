<?php

namespace Zahzah\ModuleProfession\Supports;

use Zahzah\LaravelSupport\Supports\PackageManagement;
use Zahzah\ModuleProfession\Contracts\ModuleProfession;

class BaseModuleProfession extends PackageManagement implements ModuleProfession{
    /** @var array */
    protected $__module_profession_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct(){
        $this->setConfig('module-profession',$this->__module_profession_config);
    }    
}   