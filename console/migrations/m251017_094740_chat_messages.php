<?php

use yii\db\Migration;

class m251017_094740_chat_messages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $slq = "CREATE TABLE chat_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                chat_id INT,
                sender_role VARCHAR(20), -- заменено ENUM на VARCHAR
                message TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (chat_id) REFERENCES chats(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($slq);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql="DROP TABLE chat_messages;";
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094740_chat_messages cannot be reverted.\n";

        return false;
    }
    */
}
