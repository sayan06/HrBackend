<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

return (new Jubeki\LaravelCodeStyle\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(app_path())
            ->in(config_path())
            ->in(database_path('factories'))
            ->in(database_path('seeders'))
            ->in(lang_path())
            ->in(base_path('routes'))
            ->in(base_path('tests'))
    )
    ->setRules([
        '@Laravel' => true,
        // '@Laravel:risky' => true,
        'not_operator_with_space' => false,
        'not_operator_with_successor_space' => false,
        'concat_space' => ['spacing' => 'one'],
    ])
    // ->setRiskyAllowed(true)
;
