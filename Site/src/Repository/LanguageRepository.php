<?php

namespace App\Repository;

use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<Language>
 */
class LanguageRepository extends ServiceEntityRepository
{
    private $connection;
    public function __construct(ManagerRegistry $registry,Connection $connection)
    {
        parent::__construct($registry, Language::class);
        $this->connection = $connection;
    }

    public function findAllL(): array
    {

        $sql = '
        SELECT * FROM language ORDER BY language_name ASC;';
        $resultSet = $this->connection->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }
    public function delById(int $id)
    {
        $entityManager = $this->getEntityManager();
        $language = $this->find($id);
        // Vérifiez si l'entité est gérée par l'EntityManager
        if ($entityManager->contains($language)) {
            $entityManager->remove($language);
            $entityManager->flush();
        } else {
            
        }
        return;
    }
    
}
