CREATE DATABASE IF NOT EXISTS test_db;

SET @grantto = (select User from mysql.user where User!="root" and Host!="localhost");
SET @grantStmtText = CONCAT("GRANT ALL ON test_db.* to ", @grantto);
PREPARE grantStmt FROM @grantStmtText;
EXECUTE grantStmt;
