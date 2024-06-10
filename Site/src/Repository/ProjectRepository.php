<?php

namespace App\Repository;

use App\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<Language>
 */
class ProjectRepository extends ServiceEntityRepository
{
    private $connection;
    public function __construct(ManagerRegistry $registry,Connection $connection)
    {
        parent::__construct($registry, Projet::class);
        $this->connection = $connection;
    }

    public function ProjectListOfUser($userId): array
    {
        $sql = '
        SELECT * FROM project Where user_id = :userId ORDER BY project_name ASC;';
        $resultSet = $this->connection->executeQuery($sql,['userId' => $userId]);
        return $resultSet->fetchAllAssociative();
    }
    
    public function CreateProject($userId,$projectName)
    {
        $sql = '
       INSERT INTO project (user_id,project_name) VALUE (:userId , :projectName) ;';
       $this->connection->executeQuery($sql,['userId' => $userId, 'projectName' => $projectName]);
        return;
    }

    public function DeleteProject($projectId)
    {
        $sql = "
       DELETE FROM project WHERE id = :projectId;";
       $this->connection->executeQuery($sql,['projectId' => $projectId]);
        return;
    }
    
}
