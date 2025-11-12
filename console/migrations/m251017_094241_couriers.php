<?php

use yii\db\Migration;

class m251017_094241_couriers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE couriers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100),
            last_name VARCHAR(100),
            phone_number VARCHAR(20),
            password VARCHAR(255),
            transport_type VARCHAR(50),
            courier_license VARCHAR(100),
            status VARCHAR(20),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $sql = "DROP TABLE couriers;";
       $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094241_couriers cannot be reverted.\n";

        return false;
    }
    */
}
