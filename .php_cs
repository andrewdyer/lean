<?php

$finder = PhpCsFixer\Finder::create()->in(__DIR__);

$config = new PhpCsFixer\Config();

$rules = [
    '@Symfony' => true,
    'ordered_class_elements' => [
        'sort_algorithm' => 'alpha',
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
];

return $config->setRules($rules)->setFinder($finder);
