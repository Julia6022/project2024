<?php
/**
 * User repository.
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public const PAGINATOR_ITEMS_PER_PAGE = 8;

    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry The registry for managing entities
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Query all users.
     *
     * @return QueryBuilder Returns the QueryBuilder object
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('user.id, user.nickname, user.email, user.roles');
    }

    /**
     * Save a user entity.
     *
     * @param User $user The user entity to save
     */
    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * Delete a user entity.
     *
     * @param User $user The user entity to delete
     */
    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    /**
     * Upgrade the user's password.
     *
     * @param PasswordAuthenticatedUserInterface $user              The user object
     * @param string                             $newHashedPassword The new hashed password
     *
     * @throws UnsupportedUserException if the user instance is not supported
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user);
    }

    /**
     * Get or create a QueryBuilder object.
     *
     * @param QueryBuilder|null $queryBuilder Optional QueryBuilder object
     *
     * @return QueryBuilder Returns the QueryBuilder object
     */
    private function getOrCreateQueryBuilder(?QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('user');
    }
}
