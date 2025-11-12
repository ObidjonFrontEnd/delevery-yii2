<?php

use yii\db\Migration;

class m251017_094655_chats extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="CREATE TABLE chats (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                admin_id INT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql="DROP TABLE chats;";
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094655_chats cannot be reverted.\n";

        return false;
    }
    */
}
