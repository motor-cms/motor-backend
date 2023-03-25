<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        $transformer = new UuidTransformer(DB::connection());
        $transformer->transform();

        // Handle special cases

    }
};

use Doctrine\DBAL\Schema\AbstractSchemaManager as DoctrineSchemaManager;
use Illuminate\Console\Command;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder as SchemaBuilder;

class UuidTransformer
{
    protected Connection $connection;

    protected DoctrineSchemaManager $doctrineSchemaManager;

    protected SchemaBuilder $schemaBuilder;

    protected ?Command $command = null;

    private array $intColumnsInfo = [];

    private array $foreignKeysConstraintsInfo = [];

    private array $excludedTables = ['migrations'];

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->doctrineSchemaManager = $connection->getDoctrineSchemaManager();
        $this->schemaBuilder = $connection->getSchemaBuilder();

        // This handles enums
        $this->connection->getDoctrineConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    /**
     * Set console command instance for printing message to the console.
     *
     * @param  Command $command
     * @return void
     */
    public function setConsoleCommand(Command $command): void
    {
        $this->command = $command;
    }

    /**
     * 1) Drop all foreign key constraints on each table
     * 2) Change INT to BIGINT on primary and foreign key columns on each table
     * 3) Restore all foreign key constraints on each table
     *
     * @return void
     */
    public function transform(): void
    {
        $this->extractSchemaInfos();

        $hasConstraintAnomaly = false;

        foreach ($this->foreignKeysConstraintsInfo as $constraint) {
            // If there are data that do not respect a foreign key constraint,
            // it will be impossible to restore the constraint after deleting it.
            // So, we check this before doing any action.
            if ($this->hasConstraintAnomaly($constraint)) {
                $this->message(
                    "Foreign key constraint anomaly: [{$constraint['name']}] "
                    ."{$constraint['table']}.{$constraint['column']} references "
                    ."{$constraint['relatedTable']}.{$constraint['relatedColumn']}",
                    'error'
                );

                $hasConstraintAnomaly = true;
            }
        }


        if ($hasConstraintAnomaly) {
            return;
        }

        // DROP FOREIGN KEY CONSTRAINTS

        foreach ($this->foreignKeysConstraintsInfo as $constraint) {
            $this->message("Drop foreign on {$constraint['table']}.{$constraint['column']}");

            $this->schemaBuilder->table($constraint['table'], function (Blueprint $blueprint) use ($constraint) {
                $blueprint->dropForeign($constraint['name']);
            });
        }

        // CHANGE id to uuid type

        foreach ($this->intColumnsInfo as $column) {
            $this->message("Change id from BIGING / Autoincrement to UUID for {$column['table']}.{$column['column']}");

            $this->schemaBuilder->table($column['table'], function (Blueprint $blueprint) use ($column) {
                $blueprint
                    ->uuid($column['column'])
                    ->nullable($column['nullable'])
                    ->default($column['default'])
                    ->change();
            });
        }

        // RESTORE FOREIGN KEY CONSTRAINTS

        foreach ($this->foreignKeysConstraintsInfo as $constraint) {
            $this->message("Restore foreign on {$constraint['table']}.{$constraint['column']}");

            $this->schemaBuilder->table($constraint['table'], function (Blueprint $blueprint) use ($constraint) {
                $blueprint
                    ->foreign($constraint['column'], $constraint['name'])
                    ->references($constraint['relatedColumn'])
                    ->on($constraint['relatedTable'])
                    ->onDelete($constraint['onDelete'])
                    ->onUpdate($constraint['onUpdate']);
            });
        }
    }

    /**
     * On each table :
     * 1) Extract information on unsigned integer columns that are primary or foreign key.
     * 2) Extract information on foreign keys constraints concerning unsigned integer columns.
     *
     * @return void
     */
    private function extractSchemaInfos(): void
    {
        $this->intColumnsInfo = [];
        $this->foreignKeysConstraintsInfo = [];

        foreach ($this->doctrineSchemaManager->listTables() as $table) {

            if (in_array($table->getName(), $this->excludedTables)) {
                continue;
            }

            $tableIntColumnsNames = [];

            // GET TABLE KEYS COLUMNS NAMES

            $tableKeysColumnsNames = [];

            // primary keys...
            if ($primaryKey = $table->getPrimaryKey()) {
                $tableKeysColumnsNames = $primaryKey->getColumns();
            }

            // ... + foreign keys
            foreach ($table->getForeignKeys() as $foreignKey) {
                $tableKeysColumnsNames = array_merge($tableKeysColumnsNames, $foreignKey->getLocalColumns());
            }

            // GET UNSIGNED INTEGER COLUMNS NAMES AND INFOS

            foreach ($table->getColumns() as $column) {
                // keep only unsigned integer columns that are a key
                if (! $column->getType() instanceof \Doctrine\DBAL\Types\BigIntType
                    || ! $column->getUnsigned()
                    || ! in_array($column->getName(), $tableKeysColumnsNames)) {


                    if (! str_ends_with($column->getName(), '_id') && ! in_array($column->getName(), ['created_by', 'updated_by', 'deleted_by'])) {
                        continue;
                        //var_dump("FOUND A BITCH - ".$column->getName());
                    }

                    //var_dump("SKIPPED - ". $column->getName() . '('.(string)(!$column->getType() instanceof \Doctrine\DBAL\Types\BigIntType).','.(string)!$column->getUnsigned().','.(string)(!in_array($column->getName(), $tableKeysColumnsNames).')'));

                }

                $tableIntColumnsNames[] = $column->getName();

                $this->intColumnsInfo[] = [
                    'table' => $table->getName(),
                    'column' => $column->getName(),
                    'nullable' => ! $column->getNotnull(),
                    'default' => $column->getDefault(),
                    'autoIncrement' => $column->getAutoincrement(),
                ];
            }

            // GET FOREIGN KEYS CONSTRAINTS INFOS

            foreach ($table->getForeignKeys() as $foreignKey) {
                // keep only foreign keys that are unsigned integer
                if (! in_array($foreignKey->getLocalColumns()[0], $tableIntColumnsNames)) {
                    continue;
                }

                $this->foreignKeysConstraintsInfo[] = [
                    'name' => $foreignKey->getName(),
                    'table' => $foreignKey->getLocalTableName(),
                    'column' => $foreignKey->getLocalColumns()[0],
                    'relatedTable' => $foreignKey->getForeignTableName(),
                    'relatedColumn' => $foreignKey->getForeignColumns()[0],
                    'onUpdate' => $foreignKey->onUpdate(),
                    'onDelete' => $foreignKey->onDelete(),
                ];
            }
        }
    }

    /**
     * Says if there are data that do not respect a foreign key constraint.
     *
     * @param  array $constraint
     * @return bool
     */
    private function hasConstraintAnomaly(array $constraint): bool
    {
        return $this->connection
            ->table($constraint['table'])
            ->whereNotNull($constraint['column'])
            ->whereNotIn($constraint['column'], function ($query) use ($constraint) {
                $query
                    ->from($constraint['relatedTable'])
                    ->select($constraint['relatedColumn']);
            })
            ->exists();
    }

    /**
     * Print message to the console if set, or do an echo.
     *
     * @param  string $message
     * @param  string $style
     * @return void
     */
    protected function message(string $message, string $style = 'info'): void
    {
        if ($this->command !== null) {
            $this->command->line($message, $style);
        } else {
            echo $message."\n";
        }
    }
}
