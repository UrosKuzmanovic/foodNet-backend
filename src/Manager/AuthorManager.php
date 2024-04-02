<?php

namespace App\Manager;

use App\Entity\Author;
use App\Entity\Dto\AuthenticatorHttpDto;
use App\Entity\Dto\UserDto;
use App\Repository\AuthorRepository;

class AuthorManager
{

    /** @var AuthorRepository */
    private AuthorRepository $repository;

    public function __construct(AuthorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Author[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param array $criteria
     * @return Author|null
     */
    public function findOneBy(array $criteria): ?Author
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @param Author $author
     * @return Author
     */
    public function save(Author $author): Author
    {
        return $this->repository->save($author);
    }

    /**
     * @param UserDto $user
     * @return Author
     */
    public function registerAuthor(UserDto $user): Author
    {
        $author = (new Author())
            ->setUsername($user->getUsername())
            ->setEmail($user->getEmail())
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setUserId($user->getId())
            ->setImage($user->getImage())
            ->setEnabled(false);

        return $this->save($author);
    }

    /**
     * @param UserDto $user
     * @return Author
     */
    public function enableAuthor(UserDto $user): Author
    {
        $authorDB = $this->findOneBy(['email' => $user->getEmail()]);

        if ($authorDB) {
            $authorDB->setEnabled(true);

            return $this->save($authorDB);
        }

        return new Author();
    }

    /**
     * @param UserDto $user
     * @return Author|null
     */
    public function getByUser(UserDto $user): ?Author
    {
        return $this->repository->findOneBy(['userId' => $user->getId()]);
    }

    /**
     * @param Author $author
     * @return int
     */
    public function getRecipesCountForAuthor(Author $author): int
    {
        return $this->repository->getRecipesCountForAuthor($author);
    }

}