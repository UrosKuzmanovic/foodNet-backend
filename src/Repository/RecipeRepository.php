<?php

namespace App\Repository;

use App\Entity\Dto\SearchParametersDto;
use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * @param Recipe $entity
     * @return Recipe
     */
    public function save(Recipe $entity): Recipe
    {
        // TODO fix pre persist listener
        if (!$entity->getCreatedAt()) {
            $entity->setCreatedAt(new \DateTime());
        }

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    /**
     * @param Recipe $entity
     * @return void
     */
    public function delete(Recipe $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param SearchParametersDto $parameters
     * @return Recipe[]
     */
    public function listForFeed(SearchParametersDto $parameters): array
    {
        $qb = $this->createQueryBuilder('r')
            ->select()
            ->leftJoin('r.author', 'a')
            ->leftJoin('r.tags', 't')
            ->where('r.archived = :archived')
            ->setParameter('archived', $parameters->getArchived())
            ->andWhere('r.deletedAt is null');

        if ($parameters->getAuthorId()) {
            $qb->andWhere('a.id = :authorId')
                ->setParameter('authorId', $parameters->getAuthorId());
        }

        if ($parameters->getSearch()) {
            $qb->andWhere($qb->expr()->orX(
                $qb->expr()->like('r.name', ':search'),
                $qb->expr()->like('t.name', ':search'),
            ))
                ->setParameter('search', '%' . $parameters->getSearch() . '%');
        }

        $qb->orderBy('r.createdAt', 'desc');

        return $qb->getQuery()->execute();
    }
}
