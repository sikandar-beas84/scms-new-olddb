DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_report`;
CREATE PROCEDURE `sp_report`(
    IN `status_data` VARCHAR(255), 
    IN `customerdata` VARCHAR(255), 
    IN `productsdata` VARCHAR(255), 
    IN `branchdata` VARCHAR(255), 
    IN `to_date` VARCHAR(255), 
    IN `form_date` VARCHAR(255)
)
BEGIN
    DECLARE status_query VARCHAR(500) DEFAULT '';
    DECLARE customer_query VARCHAR(500) DEFAULT '';
    DECLARE product_query VARCHAR(500) DEFAULT '';
    DECLARE branch_query VARCHAR(500) DEFAULT '';
    DECLARE to_date_query VARCHAR(500) DEFAULT '';
    DECLARE form_date_query VARCHAR(500) DEFAULT '';

    IF status_data <> "" THEN
        SET status_query = CONCAT(" AND loan_form_data.verify_statas = '", status_data, "' ");
    ELSE
        SET status_query = " ";
    END IF;

    IF customerdata <> "" THEN
        SET customer_query = CONCAT(" AND loan_form_data.customer_id = ", customerdata, " ");
    ELSE
        SET customer_query = " ";
    END IF;

    IF productsdata <> "" THEN
        SET product_query = CONCAT(" AND loan_form_data.product_id = ", productsdata, " ");
    ELSE
        SET product_query = " ";
    END IF;

    IF branchdata <> "" THEN
        SET branch_query = CONCAT(" AND loan_form_data.branch = ", branchdata, " ");
    ELSE
        SET branch_query = " ";
    END IF;

    IF to_date <> "" AND form_date <> "" THEN
        SET to_date_query = CONCAT(" AND DATE(loan_form_data.created_at) BETWEEN '", form_date, "' AND '", to_date, "' ");
    ELSE
        IF to_date <> "" THEN
            SET to_date_query = CONCAT(" AND DATE(loan_form_data.created_at) = '", to_date, "' ");
        ELSE
            SET to_date_query = " ";
        END IF;

        IF form_date <> "" THEN
            SET form_date_query = CONCAT(" AND DATE(loan_form_data.created_at) = '", form_date, "' ");
        ELSE
            SET form_date_query = " ";
        END IF;
    END IF;

    SET @QRY = CONCAT("
                SELECT 
                    (SELECT COUNT(*) FROM loan_form_data WHERE is_active = 'Y') as recordsTotal,

                    (
                        SELECT COUNT(*) FROM loan_form_data 
                        LEFT JOIN customer_master
                        ON customer_master.id = loan_form_data.customer_id
                        WHERE loan_form_data.is_active = 'Y'", 
                        status_query, 
                        customer_query, 
                        product_query, 
                        branch_query, 
                        to_date_query, 
                        form_date_query,"
                    ) as recordsFiltered,

                    loan_form_data.*, 
                    customer_master.account_number, 
                    customer_master.de_dupe_first_name, 
                    customer_master.de_dupe_last_name,
                    customer_master.account_number
                FROM loan_form_data
                LEFT JOIN customer_master
                ON customer_master.id = loan_form_data.customer_id
                WHERE loan_form_data.is_active = 'Y' ", 
                status_query, 
                customer_query, 
                product_query, 
                branch_query, 
                to_date_query, 
                form_date_query, 
                " ORDER BY loan_form_data.id DESC");

    -- SELECT @QRY;
    PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;