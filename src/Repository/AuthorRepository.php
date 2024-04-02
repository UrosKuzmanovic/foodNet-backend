<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 *
 * @method Author|null find($id, $lockMode = null, $lockVersion = null)
 * @method Author|null findOneBy(array $criteria, array $orderBy = null)
 * @method Author[]    findAll()
 * @method Author[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @param Author $author
     * @return Author
     */
    public function save(Author $author): Author
    {
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();

        return $author;
    }

    /**
     * @param Author $author
     * @return int
     */
    public function remove(Author $author): int
    {
        $this->getEntityManager()->remove($author);
        $this->getEntityManager()->flush();

        return $author->getId();
    }

    /**
     * @param Author $author
     * @return int
     */
    public function getRecipesCountForAuthor(Author $author): int
    {
        $sql = '
            select r.id
            from author a
            inner join recipe r on a.id = r.author_id
            where a.id = :id
                and r.archived = 0
                and r.deleted_at is null;
        ';

        try {
            $stmt = $this->_em
                ->getConnection()
                ->prepare($sql);
            $stmt->bindValue('id', $author->getId());
            return $stmt->executeQuery()->rowCount();
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
