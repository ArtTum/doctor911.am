<?php

use yii\db\Migration;

class m260902_180000_restore_crud_primary_keys extends Migration
{
    private const TABLES = [
        'category',
        'comment',
        'doctor',
        'footer_menu',
        'galery',
        'galery_category',
        'galery_category_has_doctor',
        'help_info',
        'hospital',
        'lang',
        'menu',
        'news',
        'page',
        'social',
        'sub_menu',
        'subscribe',
        'type',
        'user',
    ];

    public function safeUp()
    {
        $tables = [];

        foreach (self::TABLES as $tableName) {
            $table = $this->db->schema->getTableSchema($tableName, true);

            if ($table === null || !isset($table->columns['id'])) {
                throw new RuntimeException("The {$tableName} table or its id column does not exist.");
            }

            if ($table->primaryKey !== [] && $table->primaryKey !== ['id']) {
                throw new RuntimeException("The {$tableName} table has an unexpected primary key.");
            }

            $quotedTable = $this->db->quoteTableName($tableName);
            $quotedId = $this->db->quoteColumnName('id');
            $invalidIdCount = (int) $this->db->createCommand(
                "SELECT COUNT(*) FROM {$quotedTable} WHERE {$quotedId} IS NULL"
            )->queryScalar();
            $duplicateIdCount = (int) $this->db->createCommand(
                "SELECT COUNT(*) FROM (SELECT {$quotedId} FROM {$quotedTable} GROUP BY {$quotedId} HAVING COUNT(*) > 1) duplicate_ids"
            )->queryScalar();

            if ($invalidIdCount > 0 || $duplicateIdCount > 0) {
                throw new RuntimeException("The {$tableName} table contains null or duplicate ids.");
            }

            $tables[$tableName] = $table;
        }

        foreach ($tables as $tableName => $table) {
            if ($table->primaryKey === []) {
                $this->addPrimaryKey("pk-{$tableName}", $tableName, 'id');
            }

            if (!$table->columns['id']->autoIncrement) {
                $this->alterColumn(
                    $tableName,
                    'id',
                    $table->columns['id']->dbType . ' NOT NULL AUTO_INCREMENT'
                );
            }
        }
    }

    public function safeDown()
    {
        echo "m260902_180000_restore_crud_primary_keys cannot be reverted safely.\n";

        return false;
    }
}
