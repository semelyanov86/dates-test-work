<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use RectorLaravel\Rector\Cast\DatabaseExpressionCastsToMethodCallRector;
use RectorLaravel\Rector\Class_\ReplaceExpectsMethodsInTestsRector;
use RectorLaravel\Rector\MethodCall\DatabaseExpressionToStringToMethodCallRector;
use RectorLaravel\Rector\MethodCall\ReplaceWithoutJobsEventsAndNotificationsWithFacadeFakeRector;
use RectorLaravel\Rector\StaticCall\ReplaceAssertTimesSendWithAssertSentTimesRector;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    // register single rule
    ->withRules([
        TypedPropertyFromStrictConstructorRector::class,
        InlineConstructorDefaultToPropertyRector::class,
        DatabaseExpressionCastsToMethodCallRector::class,
        DatabaseExpressionToStringToMethodCallRector::class,
        ReplaceExpectsMethodsInTestsRector::class,
        ReplaceAssertTimesSendWithAssertSentTimesRector::class,
        ReplaceWithoutJobsEventsAndNotificationsWithFacadeFakeRector::class,
    ])
    ->withPaths([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/public',
        __DIR__.'/resources',
        __DIR__.'/tests',
    ])
    ->withPhpSets(php83: true)
    ->withSets([
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,
    ])
    // here we can define, what prepared sets of rules will be applied
    ->withPreparedSets(
        codeQuality: true,
    );
