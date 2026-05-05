DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_lone_ecm_count`;
CREATE PROCEDURE `sp_lone_ecm_count`(IN `month` INT, IN `year` INT)
BEGIN
	DECLARE query VARCHAR(500) DEFAULT '';
	DECLARE monthQuery VARCHAR(500) DEFAULT '';
    DECLARE yearQuery VARCHAR(500) DEFAULT '';
	
    IF month<>0 OR month<>'' THEN
        SET monthQuery = CONCAT("AND MONTH(`created_at`) in (", month, ")");
    ELSE
        SET monthQuery = ' ';
    END IF;
    
    IF year<>0 OR year<>'' THEN
        SET yearQuery = CONCAT("AND YEAR(`created_at`) in (", year, ")");
    ELSE
        SET yearQuery = ' ';
    END IF;
    
    SET @QRY = CONCAT("SELECT 

            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE product_type = '11' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS lone_account,


            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE product_type = '13' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS deposit_account
            
        FROM loan_form_data LIMIT 1");

	PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;