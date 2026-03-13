<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $transformer = new Transformer(DB::connection());
        $transformer->transform();
    }
};

class Transformer
{
    protected Connection $connection;

    protected SchemaBuilder $schemaBuilder;

    private array $intColumnsInfo = [];

    private array $foreignKeysConstraintsInfo = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->schemaBuilder = $connection->getSchemaBuilder();
    }

    /**
     * 1) Drop all foreign key constraints on each table
     * 2) Change INT to BIGINT on primary and foreign key columns on each table
     * 3) Restore all foreign key constraints on each table
     */
    public function transform(): void
    {
        $this->extractSchemaInfos();

        $hasConstraintAnomaly = false;

        foreach ($this->foreignKeysConstraintsInfo as $constraint) {
            if ($this->hasConstraintAnomaly($constraint)) {
                echo "Foreign key constraint anomaly: [{$constraint['name']}] "
                    ."{$constraint['table']}.{$constraint['column']} references "
                    ."{$constraint['relatedTable']}.{$constraint['relatedColumn']}\n";

                $hasConstraintAnomaly = true;
            }
        }

        if ($hasConstraintAnomaly) {
            return;
        }

        // DROP FOREIGN KEY CONSTRAINTS

        foreach ($this->foreignKeysConstraintsInfo as $constraint) {
            echo "Drop foreign on {$constraint['table']}.{$constraint['column']}\n";

            $this->schemaBuilder->table($constraint['table'], function (Blueprint $blueprint) use ($constraint) {
                $blueprint->dropForeign($constraint['name']);
            });
        }

        // CHANGE INT TO BIGINT

        foreach ($this->intColumnsInfo as $column) {
            echo "Change INT to BIGINT for {$column['table']}.{$column['column']}\n";

            $this->schemaBuilder->table($column['table'], function (Blueprint $blueprint) use ($column) {
                $blueprint
                    ->unsignedBigInteger($column['column'], $column['autoIncrement'])
                    ->nullable($column['nullable'])
                    ->default($column['default'])
                    ->change();
            });
        }

        // RESTORE FOREIGN KEY CONSTRAINTS

        foreach ($this->foreignKeysConstraintsInfo as $constraint) {
            echo "Restore foreign on {$constraint['table']}.{$constraint['column']}\n";

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
     * On each table:
     * 1) Extract information on unsigned integer columns that are primary or foreign key.
     * 2) Extract information on foreign keys constraints concerning unsigned integer columns.
     */
    private function extractSchemaInfos(): void
    {
        $this->intColumnsInfo = [];
        $this->foreignKeysConstraintsInfo = [];

        $tables = Schema::getTables();

        foreach ($tables as $table) {
            $tableName = $table['name'];
            $columns = Schema::getColumns($tableName);
            $foreignKeys = Schema::getForeignKeys($tableName);
            $indexes = Schema::getIndexes($tableName);

            // GET TABLE KEYS COLUMNS NAMES

            $tableKeysColumnsNames = [];

            // primary key columns
            foreach ($indexes as $index) {
                if ($index['primary']) {
                    $tableKeysColumnsNames = array_merge($tableKeysColumnsNames, $index['columns']);
                }
            }

            // foreign key columns
            foreach ($foreignKeys as $fk) {
                $tableKeysColumnsNames = array_merge($tableKeysColumnsNames, $fk['columns']);
            }

            // GET UNSIGNED INTEGER COLUMNS NAMES AND INFOS

            $tableIntColumnsNames = [];

            foreach ($columns as $column) {
                // Keep only unsigned integer columns that are a key.
                // Native type_name is 'int' for INT, 'bigint' for BIGINT.
                $isInt = in_array(strtolower($column['type_name']), ['int', 'integer']);
                $isUnsigned = str_contains(strtolower($column['type']), 'unsigned');
                $isKey = in_array($column['name'], $tableKeysColumnsNames);

                if (! $isInt || ! $isUnsigned || ! $isKey) {
                    continue;
                }

                $tableIntColumnsNames[] = $column['name'];

                $this->intColumnsInfo[] = [
                    'table' => $tableName,
                    'column' => $column['name'],
                    'nullable' => $column['nullable'],
                    'default' => $column['default'],
                    'autoIncrement' => $column['auto_increment'],
                ];
            }

            // GET FOREIGN KEYS CONSTRAINTS INFOS

            foreach ($foreignKeys as $fk) {
                // Keep only foreign keys that are unsigned integer
                if (! in_array($fk['columns'][0], $tableIntColumnsNames)) {
                    continue;
                }

                $this->foreignKeysConstraintsInfo[] = [
                    'name' => $fk['name'],
                    'table' => $tableName,
                    'column' => $fk['columns'][0],
                    'relatedTable' => $fk['foreign_table'],
                    'relatedColumn' => $fk['foreign_columns'][0],
                    'onUpdate' => strtolower($fk['on_update']),
                    'onDelete' => strtolower($fk['on_delete']),
                ];
            }
        }
    }

    /**
     * Says if there are data that do not respect a foreign key constraint.
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
}
