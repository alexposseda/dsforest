<?php

use yii\db\Migration;

/**
 * Handles the creation for table `offer`.
 */
class m161004_084544_create_offer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('offer', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('offer');
    }
}
