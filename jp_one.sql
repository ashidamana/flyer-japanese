-- 每日一句表
CREATE TABLE IF NOT EXISTS `jp_one`(
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(60) DEFAULT '' COMMENT '标题',
    `link` VARCHAR(60) DEFAULT '' COMMENT '源链接',
    `content` TEXT COMMENT '内容',
    `date` DATE DEFAULT NULL COMMENT '日期',
    `create_time` DATETIME DEFAULT NULL COMMENT '创建时间',
    `update_time` DATETIME DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
