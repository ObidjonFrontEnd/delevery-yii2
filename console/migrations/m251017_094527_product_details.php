<?php

use yii\db\Migration;

class m251017_094527_product_details extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql =" CREATE TABLE product_details (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    product_id INT,
                    description TEXT,
                    weight VARCHAR(50),
                    color VARCHAR(50),
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $sql = "drop table product_details;";
       $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094527_product_details cannot be reverted.\n";

        return false;
    }
    */
}
