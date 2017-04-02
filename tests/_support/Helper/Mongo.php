<?php
namespace Helper;

use MongoId;
use MongoDBRef;

class Mongo extends \Codeception\Module
{
    const TEST_DB_NAME = 'dominoes_again_test';

    public function insertDocument(string $collectionName, array $document) : array
    {
        $this->getCollection($collectionName)->insert($document);

        return $document;
    }

    public function saveDocument(string $collectionName, array $document) : void
    {
        $this->getCollection($collectionName)->save($document);
    }

    public function findDocument(string $collectionName, array $query) : ?array
    {
        $collection = $this->getCollection($collectionName);

        return $collection->findOne($query);
    }

    public function deleteDocumentById(string $collectionName, string $id) : void
    {
        $collection = $this->getCollection($collectionName);

        $collection->remove(['_id' => new MongoId($id)]);
    }

    public function createMongoDate(string $format, string $value) : \MongoDate
    {
        $date = \DateTime::createFromFormat($format, $value);
        $timestamp = $date->getTimestamp();
        $isoDate = new \MongoDate($timestamp);

        return $isoDate;
    }

    public function getDbRef(string $collectionName, array $document) : MongoDBRef
    {
        return $this->getCollection($collectionName)->getDBRef($document);
    }

    private function getCollection(string $collectionName) : \MongoCollection
    {
        $mongo = new \Mongo();
        $database = $mongo->selectDB(self::TEST_DB_NAME);
        $collection = $database->selectCollection($collectionName);

        return $collection;
    }
}
