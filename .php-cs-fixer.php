<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('.phpunit.cache')
    ->exclude('.phpstan.cache')
    ->exclude('coverage');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PHP83Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'single_quote' => true,
        'trailing_comma_in_multiline' => true,
        'declare_strict_types' => true,
        'strict_param' => true,
        'void_return' => true,
        'final_class' => true,
        'braces_position' => [
            'allow_single_line_empty_anonymous_classes' => true,
            'allow_single_line_anonymous_functions' => true,
        ],
        'single_line_empty_body' => true,
        'function_declaration' => ['closure_fn_spacing' => 'none'],
    ])
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setCacheFile('.php-cs-fixer.cache');
