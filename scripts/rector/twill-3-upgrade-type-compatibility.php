<?php

/**
 * Used in the upgrade from Twill 2 to Twill 3, to further add types to methods
 * after running the Twill 3 upgrade script: https://github.com/area17/twill/blob/3.x/UPGRADE.md#run-the-upgrade
 */

declare(strict_types=1);

use A17\Twill\Repositories\ModuleRepository;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationBasedOnParentClassMethodRector;
use Rector\TypeDeclaration\Rector\Property\AddPropertyTypeDeclarationRector;
use Rector\TypeDeclaration\ValueObject\AddPropertyTypeDeclaration;

return static function (RectorConfig $config): void {
    $config->paths([getcwd() . '/app/']);
    $config->importNames(false);
    $config->importShortClasses(false);
    $config->phpVersion(PhpVersion::PHP_80);
    $config->disableParallel();

    /**
     * Our extensions of Twill's base repository, model, and Controller were
     * updated, so now we need to update the methods of the classes that inherit
     * from them.
     */
    $config->rule(AddReturnTypeDeclarationBasedOnParentClassMethodRector::class);

    // Module repository repeaters are now typed.
    $config->ruleWithConfiguration(AddPropertyTypeDeclarationRector::class, [
        new AddPropertyTypeDeclaration(
            ModuleRepository::class,
            'repeaters',
            new ArrayType(new MixedType(), new MixedType())
        ),
    ]);
};
