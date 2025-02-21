
-- DROP DATABASE example_products;
-- CREATE DATABASE example_products;
--

-- DROP TABLE IF EXISTS `products_attributes_table`;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `products_table`;

CREATE TABLE IF NOT EXISTS `products_table` (
    `id` varchar(255) NOT NULL,
    `name` varchar(255) DEFAULT NULL,
    `inStock` int(1),
    `description` LONGTEXT DEFAULT NULL,
    `category` varchar(255) NOT NULL,
    `brand` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=0;

    DELETE FROM `products_table` WHERE 1


INSERT INTO `products_table` (`id`, `name`, `price`) VALUES
                                                         (1, 'Milk 1l', '10'),
                                                         (101, 'pack 1l', '3'),
                                                         (102, 'milk liquid', '2'),
                                                         (103, 'paper 10cm', '1'),
                                                         (2, 'Oil 2l ', '20'),
                                                         (201, 'pack 2l', '5'),
                                                         (202, 'oil liquid', '2'),
                                                         (203, 'paper 20cm', '1'),
                                                         (3, 'Bread', '30'),
                                                         (4, 'Potato', '40'),
                                                         (5, 'Eggs', '50'),
                                                         (6, 'Carot', '60');



INSERT INTO `products_attributes_table` (`productId`, `attributeId`) VALUES
                                                                         (1, 101),
                                                                         (1, 102),
                                                                         (1, 103),
                                                                         (2, 201),
                                                                         (2, 202),
                                                                         (2, 203);



SELECT * FROM `products_attributes_table` WHERE 1;

SELECT oo.* FROM `attribute_set_table` aa
                     LEFT JOIN `attribute_options_table` oo
                               ON aa.attributeSetId=oo.attributeSetId

