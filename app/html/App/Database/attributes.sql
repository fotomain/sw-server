
DROP TABLE IF EXISTS `attribute_set_table`;
DROP TABLE IF EXISTS `attribute_options_table`;
DROP TABLE IF EXISTS `products_attributes`;

CREATE TABLE IF NOT EXISTS `attribute_set_table` (
                                                     `attributeSetId` VARCHAR(255) NOT NULL
    ,
    `attributeSetName` VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (`attributeSetId`),
    INDEX `attributeSetName_index` (`attributeSetName`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--Color : red, blue
--Size : XX, XXL
CREATE TABLE IF NOT EXISTS `attribute_options_table` (
                                                         `attributeOptionId` VARCHAR(255) NOT NULL  ,
    `attributeSetId` VARCHAR(255) NOT NULL,
    `displayValue` VARCHAR(255) NOT NULL ,
    `value` VARCHAR(255) NOT NULL ,
    PRIMARY KEY (`attributeOptionId`),
    INDEX `displayValue_index` (`displayValue`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `products_attributes_register`
(
`productId` VARCHAR(255) NOT NULL ,
`attributeSetId` VARCHAR(255) NOT NULL ,
`attributeOptionId` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`productId`, `attributeSetId`, `attributeOptionId`)) ENGINE = InnoDB;


INSERT INTO `attribute_set_table`(`attributeSetId`, `attributeSetName`) VALUES ('Capacity','Capacity' ) ON DUPLICATE KEY UPDATE attributeSetId = 'Capacity';
INSERT INTO `attribute_set_table`(`attributeSetId`, `attributeSetName`) VALUES ('Color','Color' ) ON DUPLICATE KEY UPDATE attributeSetId = 'Color';

INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Capacity','512G', '512G' , '512G' ) ON DUPLICATE KEY UPDATE attributeOptionId = '512G';INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Capacity','1T', '1T' , '1T' ) ON DUPLICATE KEY UPDATE attributeOptionId = '1T';INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Color','Green', 'Green' , '#44FF03' ) ON DUPLICATE KEY UPDATE attributeOptionId = 'Green';INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Color','Cyan', 'Cyan' , '#03FFF7' ) ON DUPLICATE KEY UPDATE attributeOptionId = 'Cyan';INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Color','Blue', 'Blue' , '#030BFF' ) ON DUPLICATE KEY UPDATE attributeOptionId = 'Blue';INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Color','Black', 'Black' , '#000000' ) ON DUPLICATE KEY UPDATE attributeOptionId = 'Black';INSERT INTO `attribute_options_table`(`attributeSetId`, `attributeOptionId`, `displayValue`, `value`) VALUES ('Color','White', 'White' , '#FFFFFF' ) ON DUPLICATE KEY UPDATE attributeOptionId = 'White';

-- possible product attributes
select distinct aa.attributeSetId
from products_table as pp
         join products_attributes_register as aa on pp.id = aa.productId
where productId = 'apple-imac-2021';

-- possible product attributes options
select distinct aa.attributeSetId, aa.attributeOptionId
from products_table as pp
         join products_attributes_register as aa on pp.id = aa.productId
where
    productId = 'apple-imac-2021'
  and
    attributeSetId = 'Capacity'

-- CHECK NULL
select *
from products_attributes_register as reg
         join attribute_options_table as aa
              on reg.attributeOptionId = aa.attributeOptionId
where aa.attributeOptionId is  null
