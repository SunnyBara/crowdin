<?php

namespace App\Repository;

use App\Entity\Source;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<Source>
 */
class SourceRepository extends ServiceEntityRepository
{
    private $connection;
    public function __construct(ManagerRegistry $registry,Connection $connection)
    {
        parent::__construct($registry, Source::class);
        $this->connection = $connection;
    }
    public function findAll():array
    {
        $sql = '
        SELECT * FROM source';
        $resultSet = $this->connection->executeQuery($sql);
        return $resultSet->fetchAllAssociative();
    }
    public function SourceListOfUser($projectId): array
    {
        $sql = '
        SELECT * FROM source Where source_project_id = :projectId;';
        $resultSet = $this->connection->executeQuery($sql,['projectId' => $projectId]);
        return $resultSet->fetchAllAssociative();
    }
    public function CreateSource($source)
    {
        $sql = '
       INSERT INTO source (source_project_id,source_native_language_id,source_require_language_id,source_content) VALUE (:projectId,:nativeLanguage ,:require_language, :content) ;';
       $this->connection->executeQuery($sql,['projectId' => $source["projectId"], 'nativeLanguage' => $source["nativeLanguage"], 'require_language' => $source["require_language"],'content' => $source["content"]]);
        return;
    }

    public function DeleteSource($sourceId)
    {
        $sql = "
       DELETE FROM source WHERE id = :sourceId;";
       $this->connection->executeQuery($sql,['sourceId' => $sourceId]);
        return;
    }

}
