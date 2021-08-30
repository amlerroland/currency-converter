<?php

use PhpCsFixer\Config;
use Symfony\Component\Finder\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->exclude(['bootstrap','node_modules','storage','vendor']);

return (new Config())
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setRules([
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        'concat_space' => ['spacing' => 'one'],
        'array_syntax' => ['syntax' => 'short'],
        'not_operator_with_successor_space' => true,
        'multiline_whitespace_before_semicolons' => false,
        'yoda_style' => false,
        'php_unit_method_casing' => false,
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false
    ])
    ->setFinder($finder);
