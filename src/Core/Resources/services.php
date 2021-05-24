<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Core\Database\AbstractRepository;
use App\Core\Kernel\ControllerResolver;
use App\Core\Routing\Router;
use App\Core\Templating\TemplateEngine;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ConstraintViolationListNormalizer;
use Symfony\Component\Serializer\Normalizer\CustomNormalizer;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

return function (ContainerConfigurator $configurator): void {
    $configurator->parameters()
        ->set('kernel.routes_path', param('kernel.project_dir') . '/config/routes.php')
        ->set('kernel.templates_path', param('kernel.project_dir') . '/templates')
        ->set('database.host', '')
        ->set('database.port', '3306')
        ->set('database.name', '')
        ->set('database.user', '')
        ->set('database.password', '');

    $services = $configurator->services();

    $services->defaults()->public();

    // Kernel.
    $services->set(ControllerResolver::class)->args([service('service_container')]);
    $services->set(Router::class)->args([param('kernel.routes_path')]);

    $services->set(Serializer::class)
        ->args([
            [
                inline_service(CustomNormalizer::class),
                inline_service(JsonSerializableNormalizer::class),
                inline_service(DateTimeNormalizer::class),
                inline_service(DateTimeZoneNormalizer::class),
                inline_service(DateIntervalNormalizer::class),
                inline_service(ConstraintViolationListNormalizer::class),
                inline_service(ObjectNormalizer::class),
                inline_service(ArrayDenormalizer::class),
            ],
            [
                inline_service(JsonEncoder::class),
            ],
        ])
        ->public();

    $services->alias(SerializerInterface::class, Serializer::class);
    $services->alias(NormalizerInterface::class, Serializer::class);
    $services->alias(DenormalizerInterface::class, Serializer::class);
    $services->alias(EncoderInterface::class, Serializer::class);
    $services->alias(DecoderInterface::class, Serializer::class);

    $services->set(TemplateEngine::class)->args([param('kernel.templates_path')]);

    $services->set(ValidatorInterface::class)
        ->factory([
            inline_service(ValidatorBuilder::class)
                ->factory([Validation::class, 'createValidatorBuilder'])
                ->call('addMethodMapping', ['loadValidationConstraints']),
            'getValidator',
        ]);
    // End of - Kernel.

    // Database.
    $services->set('database.connection', \PDO::class)
        ->args([
            'mysql:host='.param('database.host').'; port='.param('database.port').'; dbname='.param('database.name'),
            param('database.user'),
            param('database.password'),
        ])
        ->call('setAttribute', [\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION]);

    $services->set(AbstractRepository::class)
        ->args([service('database.connection')])
        ->abstract();
    // End of - Database.
};
