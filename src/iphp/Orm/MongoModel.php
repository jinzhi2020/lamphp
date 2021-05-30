<?php

namespace iphp\Orm;

use iphp\Configs;
use iphp\Orm\Drivers\MongoDB;
use MongoDB\BSON\ObjectId;
use MongoDB\Client;

/**
 * Class MongoModel
 * @package iphp\Orm
 *
 * @method insertMany(array $documents, array $options = [])
 * @method insertOne($document, array $options = [])
 * @method updateMany($filter, $update, array $options = [])
 * @method updateOne($filter, $update, array $options = [])
 * @method deleteOne($filter, array $options = [])
 * @method deleteMany($filter, array $options = [])
 * @method find($filter = [], array $options = [])
 * @method findOne($filter = [], array $options = [])
 */
class MongoModel
{
    /**
     * MongoDB 客户端实例
     * @var Client
     */
    protected Client $instance;

    /**
     * 集合名称
     * @var string
     */
    protected string $collection = '';

    /**
     * 数据库名称
     * @var string
     */
    protected string $db = '';

    /**
     * 构造方法
     */
    public function __construct()
    {
        $this->instance = MongoDB::getInstance($this->getUri());
    }

    /**
     * 获取 Mongodb 配置
     * @return string
     */
    protected function getUri(): string
    {
        return Configs::get('mongodb.uri', 'mongodb://127.0.0.1/');
    }

    /**
     * 设置集合的名字
     * @param string $name
     * @return MongoModel
     */
    public function setCollectionName(string $name): self
    {
        $this->collection = $name;

        return $this;
    }

    /**
     * 保存文档
     */
    public function save(array $doc)
    {
        if (isset($doc['_id'])) {
            $id = new ObjectId($doc['_id']);
            unset($doc['_id']);

            return $this->updateOne(['_id' => $id], [
                '$set' => $doc
            ]);
        }

        return $this->insertOne($doc);
    }


    /**
     * 调用 MongoDB Client 中的方法
     * @param string $name
     * @param array $arguments
     * @return false|mixed
     */
    public function __call(string $name, array $arguments)
    {
        $collection = $this->instance->selectDatabase($this->db)->selectCollection($this->collection);

        return call_user_func_array([$collection, $name], $arguments);
    }
}
