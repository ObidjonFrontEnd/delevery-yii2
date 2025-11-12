<?php

use yii\db\Migration;

class m251017_094637_order_details extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql="CREATE TABLE order_details (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    order_id INT,
                    product_id INT,
                    quantity INT DEFAULT 1,
                    price DECIMAL(10,2),
                    status VARCHAR(20),
                    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql="DROP TABLE order_details;";
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094637_order_details cannot be reverted.\n";

        return false;
    }
    */
}
