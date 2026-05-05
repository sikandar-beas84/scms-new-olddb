DELIMITER $$
CREATE PROCEDURE `sp_dynamic_query`(IN `table_name` VARCHAR(255), IN `query` TEXT)
BEGIN
	SET @QRY = CONCAT("DROP TABLE IF EXISTS ", table_name); 
	PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    
    SET @QRY = query;
    PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;