<?php

namespace App\Notifier\Factory;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag(name: 'app.notification_factory')]
interface IterableFactoryInterface
{
    public static function getDefaultIndexName(): string;
}