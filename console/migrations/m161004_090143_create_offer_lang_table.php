<?php

use yii\db\Migration;

/**
 * Handles the creation for table `offer_lang`.
 */
class m161004_090143_create_offer_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('offer_lang', [
            'id' => $this->primaryKey(),
            'offerId' => $this->integer(),
            'language' => $this->string()->notNull(),
            'title' => $this->string(),
            'advantages' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('offer_lang');
    }
}
