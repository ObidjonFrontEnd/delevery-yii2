<?php

use yii\db\Migration;

class m251017_094329_addresses extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE addresses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            latitude DECIMAL(10,8),
            longitude DECIMAL(11,8),
            house VARCHAR(50),
            apartment VARCHAR(50),
            status VARCHAR(20),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = "DROP TABLE addresses;";
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094329_addresses cannot be reverted.\n";

        return false;
    }
    */
}
