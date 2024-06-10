<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @extends ServiceEntityRepository<UserLanguage>
 */
class UserLanguageRepository extends ServiceEntityRepository
{
    private $connection;
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    public function findAllLanguageOfUserTag(int $user_id): array
    {

        $sql = '
        SELECT language_name,language_id FROM language INNER JOIN user_language on user_language.language_id = language.id  WHERE user_id = :user_id ORDER BY language_name ASC;';
        $resultSet = $this->connection->executeQuery($sql, ['user_id' => $user_id]);
        return $resultSet->fetchAllAssociative();
    }
    public function findAllLanguageOfUserUntag(int $user_id): array
    {

        $sql = '
        SELECT Language.id, Language.language_name FROM Language WHERE Language.id NOT IN (SELECT user_language.language_id FROM user_language WHERE user_language.user_id = :user_id) ORDER BY Language.language_name ASC;
        ';
        $resultSet = $this->connection->executeQuery($sql, ['user_id' => $user_id]);
        return $resultSet->fetchAllAssociative();
    }


    

 
    public function addLanguageToUser(int $userId, int $languageId)
    {
    
        $sql = "
        INSERT INTO user_language (user_id,language_id) VALUE (:user_id ,:language_id);";
        $this->connection->executeQuery($sql, ['user_id' => $userId , 'language_id'=>$languageId]);
        return ;
    }
    public function delLanguageToUser(int $userId, int $languageId): array
    {
    
        $sql = "
        DELETE FROM  user_language WHERE (user_id = :user_id and language_id = :language_id);";
        $resultSet = $this->connection->executeQuery($sql, ['user_id' => $userId , 'language_id'=>$languageId]);
        return $resultSet->fetchAllAssociative();
    }
    
    
}