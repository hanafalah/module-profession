<?php

use Hanafalah\ModuleProfession\{
    Commands as ModuleProfessionCommands,
    Models,
    Contracts
};

return [
    'commands' => [
        ModuleProfessionCommands\InstallMakeCommand::class
    ],
    'contracts' => [
        'occupation'  => Contracts\Occupation::class,
        'profession'  => Contracts\Profession::class,
        'module_profession' => Contracts\ModuleProfession::class
    ],
    'database' => [
        'models' => [
            'Profession' => Models\Profession\Profession::class,
            'Occupation' => Models\Occupation\Occupation::class
        ]
    ]
];
