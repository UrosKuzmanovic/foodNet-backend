<?php

namespace App\Service;

use App\Entity\Ingredient;
use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
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
                    $value = $this->getSpecialValue($propertyName, $entity->$getter(), $entityDB->$getter()) ?? $entity->$getter();
                } else if (method_exists($entity, $isser)) {
                    $value = $this->getSpecialValue($propertyName, $entity->$isser(), $entityDB->$isser()) ?? $entity->$isser();
                }
                $entityDB->$setter($value);
            }

            return $entityDB;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function getSpecialValue(string $propertyName, $newValue, $dbValue)
    {
        switch ($propertyName) {
            case 'tags':
                $value = new ArrayCollection();
                /** @var Tag $data */
                foreach ($newValue as $data) {
                    if ($data->getId()) {
                        $oldValue = array_filter($dbValue->toArray(), (function ($value) use ($data) {
                            return $value->getId() === $data->getId();
                        }));
                        count($oldValue) > 0 && $oldValue = array_pop($oldValue);
                        /** @var Tag $oldValue */
                        $value[] = $oldValue->setName($data->getName())->setColor($data->getColor());
                    } else {
                        $value[] = $data;
                    }
                }
                return $value;
            case 'ingredients':
                $value = new ArrayCollection();
                /** @var Ingredient $data */
                foreach ($newValue as $data) {
                    if ($data->getId()) {
                        $oldValue = array_filter($dbValue->toArray(), (function ($value) use ($data) {
                            return $value->getId() === $data->getId();
                        }));
                        count($oldValue) > 0 && $oldValue = array_pop($oldValue);
                        /** @var Ingredient $oldValue */
                        $value[] = $oldValue->setName($data->getName())->setQuantity($data->getQuantity());
                    } else {
                        $value[] = $data;
                    }
                }
                return $value;
            default:
                return null;
        }
    }
}