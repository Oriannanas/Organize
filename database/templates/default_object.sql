SET @new_table_name = '';

CREATE @new_table_name
(
  id INT NOT NULL AUTO_INCREMENT,
  created_on DATETIME NULL DEFAULT NULL,
  last_modified DATETIME NULL DEFAULT NULL,
  deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_on DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id),
);