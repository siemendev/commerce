<?php

declare(strict_types=1);

namespace App\Repository;

use ReflectionClass;
use RuntimeException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @template T of IdentifiableInterface
 */
abstract class AbstractRepository
{
    private const FILE_GLOB_PATTERN = '%s/*.xml';

    private const FILE_PATTERN = '%s/%s.xml';

    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new XmlEncoder()]);
    }

    abstract public static function getDirectory(): string;

    /**
     * @return class-string<T>
     */
    abstract public static function getClass(): string;

    /**
     * @return array<T>
     * @throws ObjectNotFoundException
     */
    public function loadAll(): array
    {
        $this->ensureDirectory();

        $objects = [];

        foreach ($this->loadAllIds() as $id) {
            $objects[] = $this->load($id);
        }

        return $objects;
    }

    /**
     * @return array<string>
     */
    public function loadAllIds(): array
    {
        $ids = [];
        foreach (glob(sprintf(self::FILE_GLOB_PATTERN, $this::getDirectory())) as $filename) {
            if (!is_file($filename)) {
                continue;
            }
            $id = pathinfo($filename, PATHINFO_FILENAME);
            if (!is_string($id) || '' === $id) {
                continue;
            }

            $ids[] = $id;
        }

        return $ids;
    }

    /**
     * @return T
     * @throws ObjectNotFoundException
     */
    public function load(string $id): IdentifiableInterface
    {
        $this->ensureDirectory();

        $file = $this->getFilename($id);

        if (!file_exists($file)) {
            throw new ObjectNotFoundException($this::getClass(), $id);
        }

        $object = $this->serializer->deserialize(file_get_contents($file), $this::getClass(), 'xml');

        if (!is_a($object, $this::getClass())) {
            throw new ObjectNotFoundException($this::getClass(), $id);
        }

        return $object;
    }

    public function save(IdentifiableInterface $object): void
    {
        $this->ensureDirectory();

        file_put_contents(
            $this->getFilename($object->getIdentifier()),
            $this->serializer->serialize(
                $object,
                'xml',
                [
                    'xml_root_node_name' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', (new ReflectionClass($this::getClass()))->getShortName())),
                    'xml_format_output' => true,
                ],
            ),
        );
    }

    public function delete(string $id): void
    {
        $this->ensureDirectory();

        if (!$this->exists($id)) {
            throw new RuntimeException(sprintf('file not found: %s', $this->getFilename($id)));
        }

        unlink($this->getFilename($id));
    }

    public function exists(string $id): bool
    {
        $this->ensureDirectory();

        return file_exists($this->getFilename($id));
    }

    private function getFilename(string $id): string
    {
        return sprintf(self::FILE_PATTERN, $this::getDirectory(), $id);
    }

    private function ensureDirectory(): void
    {
        if (!is_dir($this::getDirectory()) && !mkdir($this::getDirectory(), 0777, true) && !is_dir($this::getDirectory())) {
            throw new RuntimeException(sprintf('Directory "%s" could not be created', $this::getDirectory()));
        }
    }
}
