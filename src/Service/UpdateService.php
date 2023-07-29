<?php

namespace App\Service;

use Doctrine\Persistence\ManagerRegistry;

class UpdateService
{

    private ManagerRegistry $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function updateEntity($entity)
    {
        try {
            $class = get_class($entity);

            $entityDB = $this->doctrine->getRepository($class)->findOneBy(['id' => $entity->getId()]);

            $reflectionClass = new \ReflectionClass($class);
            $properties = $reflectionClass->getProperties();

            foreach ($properties as $property) {
                $propertyName = $property->getName();
                $getter = 'get' . ucfirst($propertyName);
                $isser = 'is' . ucfirst($propertyName);
                $setter = 'set' . ucfirst($propertyName);
                $value = null;
                if (method_exists($entity, $getter)) {
                    $value = $entity->$getter();
                } else if (method_exists($entity, $isser)) {
                    $value = $entity->$isser();
                }
                $entityDB->$setter($value);
            }

            return $entityDB;
        } catch (\Exception $e) {
            return null;
        }
    }
}