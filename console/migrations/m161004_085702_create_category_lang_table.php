<?php

use yii\db\Migration;

/**
 * Handles the creation for table `category_lang`.
 */
class m161004_085702_create_category_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('category_lang', [
            'id' => $this->primaryKey(),
            'categoryId' => $this->integer(),
            'language' => $this->string()->notNull(),
            'title' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('category_lang');
    }
}
