<?php
/**
 * Repository
 * Modular layer
 *
 */

namespace Repository;
use \PDO;


class Category EXTENDS \Abstraction
{
    private $connection;

    public function __construct(PDO $connection=null) {
        //TODO: Move to config file.
        $this->connection = $connection;
        if($this->connection === null) {
            $this->connection = new PDO(
                'mysql:host=host.url;dbname=database_name',
                'user',
                'pass'
            );
            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        }
    }

    public function Find(\Abstraction\Category $data)
    {
        if(is_object($data)) {
            $id = $data->id;
            $ReferenceID = $data->ReferenceID;
        }
        $Query = $this->connection->prepare('
            SELECT *
            WHERE `id` = :id
            AND `ReferenceID` = :ReferenceID
        ');
        //TODO: implement $data->id, $data->ReferenceID
        $Query->bindParam(':id', $id);
        $Query->bindParam(':ReferenceID', $ReferenceID);
        $Query->execute();

        $Query->setFetchMode(PDO::FETCH_CLASS, '\Abstraction\Category');
        return $Query->fetch();
    }

    public function Save(\Abstraction\Category $data)
    {
        if(is_object($data)) {
            if(isset($data->id)) {
                return $this->Update($data);
            }

            $Query = $this->connection->prepare('
                INSERT INTO `table`
                  (Column1, Column2, Column3)
                VALUES
                  (:Column1, :Column2, :Column3)
            ');

            $Query->bindParam(':Column1', $data->Column1);
            $Query->bindParam(':Column2', $data->Column2);
            $Query->bindParam(':Column3', $data->Column3);
            if($Query->execute()) {
                return $this->connection->lastInsertId();
            }
        }
    }

    public function Update(\Abstraction\Category $data)
    {
        if(is_object($data)) {
            if(!isset($data->id)) {
                throw new \LogicException('Cannot update, id not present in DB');
            }
            $Query = $this->connection->prepare('
                UPDATE `table` SET
                  Column1 = :Column1
                  Column2 = :Column2
                WHERE
                  Column3 = :Column3
            ');
            $Query->bindParam(':Column1', $data->Column1);
            $Query->bindParam(':Column2', $data->Column2);
            $Query->bindParam(':Column3', $data->Column3);
            return $Query->execute();
        }
    }
}