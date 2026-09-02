<?php

use yii\db\Migration;

class m260902_170000_restore_library_primary_key extends Migration
{
    private const TABLE = '{{%library}}';

    public function safeUp()
    {
        $tableName = $this->db->schema->getRawTableName(self::TABLE);
        $table = $this->db->schema->getTableSchema($tableName, true);

        if ($table === null || !isset($table->columns['id'])) {
            throw new RuntimeException('The library table or its id column does not exist.');
        }

        if ($table->primaryKey !== [] && $table->primaryKey !== ['id']) {
            throw new RuntimeException('The library table has an unexpected primary key.');
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
            throw new RuntimeException('The library table contains null or duplicate ids.');
        }

        if ($table->primaryKey === []) {
            $this->addPrimaryKey('pk-library', self::TABLE, 'id');
        }

        if (!$table->columns['id']->autoIncrement) {
            $this->alterColumn(self::TABLE, 'id', $this->integer()->notNull()->append('AUTO_INCREMENT'));
        }
    }

    public function safeDown()
    {
        echo "m260902_170000_restore_library_primary_key cannot be reverted safely.\n";

        return false;
    }
}
