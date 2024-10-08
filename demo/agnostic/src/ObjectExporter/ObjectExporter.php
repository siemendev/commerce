<?php

declare(strict_types=1);

namespace Demo\ObjectExporter;

use ReflectionClass;
use RuntimeException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ObjectExporter
{
    private const VAR_DIRECTORY = '../var/';

    public function export(object $object, string $fileName): void
    {
        $directory = dirname(self::VAR_DIRECTORY . $fileName);
        if (is_file($directory)) {
            unlink($directory);
        }
        if (!is_dir($directory) && !mkdir(directory: $directory, recursive: true) && !is_dir($directory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        $serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);

        file_put_contents(
            self::VAR_DIRECTORY . $fileName,
            $serializer->encode(
                $serializer->normalize($object, XmlEncoder::FORMAT, [
                    AbstractObjectNormalizer::SKIP_UNINITIALIZED_VALUES => false,
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                ]),
                XmlEncoder::FORMAT,
                [
                    'xml_root_node_name' => (new ReflectionClass($object))->getShortName(),
                    'xml_format_output' => true,
                ],
            ),
        );
    }

    public function remove(string $fileName): void
    {
        if (file_exists(self::VAR_DIRECTORY . $fileName)) {
            unlink(self::VAR_DIRECTORY . $fileName);
        }
    }
}
