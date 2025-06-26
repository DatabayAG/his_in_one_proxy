<?php

namespace HisInOneProxy\Database;

use Exception;
use HisInOneProxy\Database\FieldDefinition\DBPdoFieldDefinition;
use HisInOneProxy\Database\FieldDefinition\DBPdoMySQLFieldDefinition;
use HisInOneProxy\Log\Log;
use HisInOneProxy\System\Utils;
use PDO;
use PDOException;

class DbPdo
{

    private array $attributes = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    );

    private string $charset = 'utf8';
    private ?int $limit = null;
    private ?int $offset = null;
    private string $storage_engine = 'InnoDB';
    private string $dsn = '';
    protected ?PDO $pdo = null;
    private $DbPdo = null;
    private int $error_code = 0;
    private Log $log;
    private DBPdoMySQLFieldDefinition $field_definition;
    private DBPdoManager $manager;
    public string $SQL_TYPE;
    /**
     * @throws Exception
     */
    public function __construct(string $dsn)
    {
        $this->log = new Log();
        $this->dsn = $dsn;

        try {
            $connection = $this->connect();
            $this->initHelpers();
            if ($connection && $this->pdo !== null) {
                return $this->pdo;
            }
        } catch (Exception $e) {
                $msg = sprintf('Could not initialize database, ERROR: "%s"', $e->getMessage());
                Utils::LogToShellAndExit($msg);
                $this->log->critical($msg);
        }
        $this->DbPdo = $this;
        $this->field_definition = new DBPdoMySQLFieldDefinition($this);
        return null;
    }

    public function initHelpers(): void
    {
        $this->manager = new DbPdoManager($this->pdo, $this);
    }

    /**
     * @throws Exception
     */
    protected function connect(bool $return_false_for_error = false): ?bool
    {
        $options = $this->getAttributes();
        try {
            $this->pdo = new PDO($this->getDSN(), null, null, $options);
        } catch (PDOException $e) {
            $this->error_code = $e->getCode();
            if ($return_false_for_error) {
                return false;
            }
            throw $e;
        }
        return ($this->pdo->errorCode() === PDO::ERR_NONE);
    }

    protected function getAttributes(): array
    {
        $options = $this->attributes;
        foreach ($this->getAdditionalAttributes() as $k => $v) {
            $options[$k] = $v;
        }

        return $options;
    }

    protected function getAdditionalAttributes(): array
    {
        return [
            PDO::ATTR_PERSISTENT => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
    }

    private function getDsn(): string
    {
        return $this->dsn;
    }

    public function tableExists(string $table_name): bool
    {
        $dbType = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
        if($dbType === 'sqlite') {
            $result = $this->pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=?;");
            $result->execute([$table_name]);
            $return = $result->fetch();
            if(isset($return['name'])) {
                $return = 1;
            }
            $result->closeCursor();
        } else {
            $result = $this->pdo->prepare("SHOW TABLES LIKE :table_name");
            $result->execute(['table_name' => $table_name]);
            $return = $result->rowCount();
            $result->closeCursor();
        }

        return $return > 0;
    }

    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    public function setStorageEngine(string $storage_engine): void
    {
        $this->storage_engine = $storage_engine;
    }

    public function getPdo(): ?PDO
    {
        if ($this->pdo !== null) {
            return $this->pdo;
        }
        $this->log->critical('Database connection is not initialized.');
        return null;
    }
    public function getDbPdo(): ?DbPdo
    {
        if ($this->DbPdo !== null) {
            return $this->DbPdo;
        }
        $this->log->critical('Database connection is not initialized.');
        return null;
    }

    private function getLimit(): ?int
    {
        return $this->limit;
    }

    private function getOffset(): ?int
    {
        return $this->offset;
    }

    public function getStorageEngine(): string
    {
        return $this->storage_engine;
    }

    public function createTable(
        string $table_name,
        array $fields,
        bool $drop_table = false,
        bool $ignore_erros = false
    ): bool {
        // check table name
        if (!$ignore_erros && !$this->checkTableName($table_name)) {
            throw new Exception("ilDB Error: createTable(" . $table_name . ")");
        }

        // check definition array
        if (!$ignore_erros && !$this->checkTableColumns($fields)) {
            throw new Exception("ilDB Error: createTable(" . $table_name . ")");
        }

        if ($drop_table) {
            $this->dropTable($table_name, false);
        }

        return $this->manager->createTable($table_name, $fields, array());
    }

    public function checkTableName(string $a_name): bool
    {
        return $this->field_definition->checkTableName($a_name);
    }

    protected function checkTableColumns($a_cols)
    {
        foreach ($a_cols as $col => $def) {
            if (!$this->checkColumn($col, $def)) {
                return false;
            }
        }

        return true;
    }

    protected function checkColumn(string $a_col, array $a_def): bool
    {
        if (!$this->checkColumnName($a_col)) {
            return false;
        }
        return $this->checkColumnDefinition($a_def);
    }

    protected function checkColumnDefinition(array $a_def, bool $a_modify_mode = false): bool
    {
        return $this->field_definition->checkColumnDefinition($a_def);
    }

    public function checkColumnName(string $a_name): bool
    {
        return $this->field_definition->checkColumnName($a_name);
    }

    public function getFieldDefinition(): DBPdoFieldDefinition
    {
        return $this->field_definition;
    }

    public function quoteIdentifier(string $identifier, bool $check_option = false): string
    {
        return '`' . $identifier . '`';
    }

    public function addPrimaryKey(string $table_name, array $primary_keys): bool
    {
        assert(is_array($primary_keys));

        $fields = array();
        foreach ($primary_keys as $f) {
            $fields[$f] = array();
        }
        $definition = array(
            'primary' => true,
            'fields' => $fields,
        );
        $this->manager->createConstraint(
            $table_name,
            $this->constraintName($table_name, $this->getPrimaryKeyIdentifier()),
            $definition
        );

        return true;
    }

    public function constraintName(string $a_table, string $a_constraint): string
    {
        return $a_constraint;
    }

    public function getPrimaryKeyIdentifier(): string
    {
        return "PRIMARY";
    }

    public function getIndexName(string $index_name_base): string
    {
        return sprintf(DBPdoFieldDefinition::INDEX_FORMAT, preg_replace('/[^a-z0-9_\$]/i', '_', $index_name_base));
    }

    public function getSequenceName(string $table_name): string
    {
        return sprintf(DBPdoFieldDefinition::SEQUENCE_FORMAT, preg_replace('/[^a-z0-9_\$.]/i', '_', $table_name));
    }

    public function modifyTableColumn(string $table, string $column, array $attributes): bool
    {
        $def = $this->reverse->getTableFieldDefinition($table, $column);

        $analyzer = new ilDBAnalyzer($this);
        $best_alt = $analyzer->getBestDefinitionAlternative($def);
        $def = $def[$best_alt];
        unset($def["nativetype"], $def["mdb2type"]);

        // check attributes
        $ilDBPdoFieldDefinition = $this->field_definition;

        $type = $attributes["type"] ?? $def["type"];

        foreach (array_keys($def) as $k) {
            if ($k !== "type" && !$ilDBPdoFieldDefinition->isAllowedAttribute($k, $type)) {
                unset($def[$k]);
            }
        }
        $check_array = $def;
        foreach ($attributes as $k => $v) {
            $check_array[$k] = $v;
        }
        if (!$this->checkColumnDefinition($check_array, true)) {
            throw new Exception("ilDB Error: modifyTableColumn(" . $table . ", " . $column . ")");
        }

        foreach ($attributes as $a => $v) {
            $def[$a] = $v;
        }

        $attributes["definition"] = $def;

        $changes = array(
            "change" => array(
                $column => $attributes,
            ),
        );

        return $this->manager->alterTable($table, $changes, false);
    }

    public function addIndex(string $table_name, array $fields, string $index_name = '', bool $fulltext = false): bool
    {
        assert(is_array($fields));
        $this->field_definition->checkIndexName($index_name);

        $definition_fields = array();
        foreach ($fields as $f) {
            $definition_fields[$f] = array();
        }
        $definition = array(
            'fields' => $definition_fields,
        );

        if (!$fulltext) {
            $this->manager->createIndex($table_name, $this->constraintName($table_name, $index_name), $definition);
        } elseif ($this->supportsFulltext()) {
            $this->addFulltextIndex($table_name, $fields, $index_name);
            // TODO
        }

        return true;
    }

    public function alterColumAutoIncrementAndPrimary(string $table, string $name): bool
    {
        $table = $this->quoteIdentifier($table, true);
        $name = $this->quoteIdentifier($name, true);
        $query = "ALTER TABLE $table MODIFY $name BIGINT( 20 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ";
        return (bool) $this->pdo->exec($query);
    }


    public function supportsFulltext(): bool
    {
        return false;
    }
}
