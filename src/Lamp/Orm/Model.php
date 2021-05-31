<?php
declare(strict_types=1);

namespace Lamp\Orm;

use Lamp\Db;
use Lamp\Orm\Exception\ColumnCanNotNull;
use Lamp\Tools\Strings;
use Exception;
use InvalidArgumentException;
use MysqliDb;

/**
 * Class Orm
 * @package App\Common\Basic
 *
 * @method bool insert(string $tableName, array $insertData)
 * @method MysqliDb where(string $filed, string $value)
 * @method int getInsertId()
 * @method mixed getValue($tableName, $column, $limit = 1)
 * @method string getLastQuery()
 * @method bool has()
 */
class Model
{

    /**
     * 降序排列
     * @var string
     */
    protected const ORDER_BY_DESC = 'desc';

    /**
     * 升序排列
     * @var string
     */
    protected const ORDER_BY_ASC = 'asc';

    /**
     * 表结构
     * @var Scheme|null
     */
    protected static ?Scheme $scheme = null;
    /**
     * 表名
     * @var string
     */
    public string $table = '';
    /**
     * 表中的数据
     * @var array
     */
    protected array $data = [];

    /**
     * 主键
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * 数据库实例
     * @var MysqliDb|null
     */
    protected ?MysqliDb $db = null;


    /**
     * 构造函数
     * @throws Exception
     */
    public function __construct()
    {
        $this->db = Db::getInstance();
        // 设定表名
        if (empty($this->table)) {
            $className = basename(str_replace('\\', '/', static::class));
            $this->table = Strings::snake($className);
        }
    }

    /**
     * 创建模型
     * @param array $params
     * @return $this
     */
    public static function create(array $params): static
    {
        $model = new static();
        // 加载 Scheme
        static::$scheme = static::scheme();
        // 加载属性
        self::load($params, $model);

        return $model;
    }

    /**
     * 表结构
     */
    public static function scheme(): ?Scheme
    {
        return null;
    }

    /**
     * 载入属性
     * @param array $params
     * @param Model $model
     * @return void
     */
    public static function load(array $params, Model $model): void
    {
        $columns = static::$scheme?->getColumnNames();
        foreach ($params as $key => $value) {
            // 检查列是否存在
            if (!is_null($columns) && !in_array($key, $columns)) {
                throw new InvalidArgumentException("Column '$key' not exists!");
            }
            $model->$key = $value;
            $model->data[$key] = $value;
        }
    }

    public function limit(int $limit): self
    {
        $this->db->pageLimit = $limit;

        return $this;
    }

    /**
     * 保存数据
     * @param bool $created
     * @throws Exception
     */
    public function save(bool $created = false)
    {
        $data = $this->data;
        // 更新
        if (!$created) {
            $this->where($this->primaryKey, $data[$this->primaryKey])->update($this->table, $this->data);
            return;
        }
        // 排除主键
        unset($data[$this->primaryKey]);
        // 检查是否缺少了不为空的字段
        $columns = static::$scheme->getColumns();
        foreach ($columns as $column) {
            if ($column->isPrimaryKey()) {
                continue;       // 跳过主键
            }
            if (!$column->isNullable() && !isset($this->data[$column->getName()])) {
                throw new ColumnCanNotNull(sprintf("Column '%s' can not null!", $column->getName()));
            }
        }
        $this->insert($this->table, $data);
    }

    /**
     * 转为数组
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * 调用 MysqliDb 中的方法
     * @param string $name
     * @param array $arguments
     * @return false|mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func([$this->db, $name], ...$arguments);
    }
}
