<?php

use yii\db\Migration;

class m251017_094433_restaurants extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE restaurants (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            phone_number VARCHAR(20),
            image VARCHAR(255),
            address_id INT,
            rate DECIMAL(2,1) DEFAULT 0.0 CHECK (rate BETWEEN 0.0 AND 5.0),
            status VARCHAR(20),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (address_id) REFERENCES addresses(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = "DROP TABLE restaurants;";
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094433_restaurants cannot be reverted.\n";

        return false;
    }
    */
}
