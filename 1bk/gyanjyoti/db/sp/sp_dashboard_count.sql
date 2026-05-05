DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dashboard_count`()
BEGIN
	SELECT 
    	(SELECT COUNT(*) FROM user_masters WHERE is_active = 'Y') AS user_master,
        (SELECT COUNT(*) FROM customer_master WHERE is_active = 'Y') AS customer_master,
        (SELECT COUNT(*) FROM branch_masters WHERE is_active = 'Y') AS branch_master
    FROM user_masters LIMIT 1; 
END$$
DELIMITER ;