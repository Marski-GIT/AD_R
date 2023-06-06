CREATE TABLE `currency_rate_type`
(
    `id_currency_rate_type` INT(11)     NOT NULL AUTO_INCREMENT,
    `table_number`          VARCHAR(15) NOT NULL COLLATE 'utf8mb4_general_ci',
    `table_type`            VARCHAR(1)  NOT NULL COLLATE 'utf8mb4_general_ci',
    `effective_date`        TIMESTAMP   NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `created_at`            TIMESTAMP   NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id_currency_rate_type`) USING BTREE
)
    COLLATE = 'utf8mb4_general_ci'
    ENGINE = InnoDB
;
CREATE TABLE `exchange_rates`
(
    `id_exchange_rates`     INT(11)    NOT NULL AUTO_INCREMENT,
    `id_currency_rate_type` INT(11)    NOT NULL,
    `currency`              TEXT       NULL     DEFAULT NULL COLLATE 'utf8mb4_general_ci',
    `code`                  VARCHAR(3) NOT NULL COLLATE 'utf8mb4_general_ci',
    `mid`                   FLOAT      NOT NULL DEFAULT 0,
    PRIMARY KEY (`id_exchange_rates`) USING BTREE,
    INDEX `id_currency_rate_type` (`id_currency_rate_type`) USING BTREE,
    CONSTRAINT `exchange_rates_ibfk_1` FOREIGN KEY (`id_currency_rate_type`) REFERENCES `currency_rate_type` (`id_currency_rate_type`) ON UPDATE RESTRICT ON DELETE RESTRICT
)
    COLLATE = 'utf8mb4_general_ci'
    ENGINE = InnoDB
;
CREATE TABLE `calculated_exchange_rate`
(
    `id_calculated_exchange_rate` INT(11)    NOT NULL AUTO_INCREMENT,
    `currency_from`               VARCHAR(3) NOT NULL COLLATE 'utf8mb4_general_ci',
    `currency_for`                VARCHAR(3) NOT NULL COLLATE 'utf8mb4_general_ci',
    `amount_from`                 FLOAT      NOT NULL,
    `amount_for`                  FLOAT      NOT NULL,
    `amount`                      FLOAT      NOT NULL DEFAULT 0,
    `created_at`                  TIMESTAMP  NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id_calculated_exchange_rate`) USING BTREE
)
    COLLATE = 'utf8mb4_general_ci'
    ENGINE = InnoDB
;