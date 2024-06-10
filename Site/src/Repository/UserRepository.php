<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;


/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    private $connection;
    public function __construct(ManagerRegistry $registry,Connection $connection)
    {
        parent::__construct($registry, User::class,);
        $this->connection = $connection;
    }
    public function findOneByUsername(string $user_Login): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.user_Login = :user_Login')
            ->setParameter('user_Login', $user_Login)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function findOneById(int $userId): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }
    function deleteUser($userId){
        $sql = "
        DELETE FROM user WHERE id = :userId;";
        $this->connection->executeQuery($sql,['userId' => $userId]);
         return;
    }
}
