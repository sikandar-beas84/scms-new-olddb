DELIMITER $$
CREATE PROCEDURE `sp_loan_count`(IN `month` INT, IN `year` INT)
BEGIN
	DECLARE query VARCHAR(500) DEFAULT '';
	DECLARE monthQuery VARCHAR(500) DEFAULT '';
    DECLARE yearQuery VARCHAR(500) DEFAULT '';
	
    IF month<>0 OR month<>'' THEN
        SET monthQuery = CONCAT("AND MONTH(`created_at`) in (", month, ")");
    ELSE
        SET monthQuery = " ";
    END IF;
    
    IF year<>0 OR year<>'' THEN
        SET yearQuery = CONCAT("AND YEAR(`created_at`) in (", year, ")");
    ELSE
        SET yearQuery = " ";
    END IF;
    
    SET @QRY = CONCAT("SELECT 

            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE verify_statas = 'P' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS pending_loan,


            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE verify_statas = 'A' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS approve_loan,
            
      		
            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE verify_statas = 'R' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS reject_loan
            
            
        FROM loan_form_data LIMIT 1");

	PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;