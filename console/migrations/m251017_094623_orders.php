<?php

use yii\db\Migration;

class m251017_094623_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT,
                restaurant_id INT,
                courier_id INT,
                total DECIMAL(10,2),
                check_number VARCHAR(50),
                status VARCHAR(20),
                payment_status VARCHAR(20),
                address_id INT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (restaurant_id) REFERENCES restaurants(id) ON DELETE CASCADE,
                FOREIGN KEY (courier_id) REFERENCES couriers(id) ON DELETE SET NULL,
                FOREIGN KEY (address_id) REFERENCES addresses(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $sql = "DROP TABLE orders;";
        $this->execute($sql);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251017_094623_orders cannot be reverted.\n";

        return false;
    }
    */
}
