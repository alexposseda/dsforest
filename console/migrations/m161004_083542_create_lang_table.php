<?php

use yii\db\Migration;

/**
 * Handles the creation for table `lang`.
 */
class m161004_083542_create_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('lang', [
            'id' => $this->primaryKey(),
            'langCode' => $this->string()->notNull()->unique(),
            'langTitle' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('lang');
    }
}
