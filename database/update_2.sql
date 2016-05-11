use organize;

CREATE TABLE field
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT,
  label VARCHAR(250),
  input_type ENUM('string', 'number', 'function') NOT NULL DEFAULT 'string',
  created_on DATETIME NULL DEFAULT NULL,
  last_modified DATETIME NULL DEFAULT NULL,
  deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_on DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id),
);

CREATE TABLE field_koppel
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT,
  field_id BIGINT(20) NOT NULL,
  logboek_id BIGINT(20) NOT NULL,
  created_on DATETIME NULL DEFAULT NULL,
  last_modified DATETIME NULL DEFAULT NULL,
  deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_on DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX fk_field_id (field_id ASC),
  CONSTRAINT fk_field_id
    FOREIGN KEY (field_id)
    REFERENCES field (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE field_value
(
  id BIGINT(20) NOT NULL AUTO_INCREMENT,
  field_koppel_id BIGINT(20) NOT NULL,
  input VARCHAR VARCHAR(250),
  created_on DATETIME NULL DEFAULT NULL,
  last_modified DATETIME NULL DEFAULT NULL,
  deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_on DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX fk_field_koppel_id (field_koppel_id ASC),
  CONSTRAINT fk_field_koppel_id
    FOREIGN KEY (field_koppel_id)
    REFERENCES field_koppel (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE flex_table
(
  id INT NOT NULL AUTO_INCREMENT,
  field_set_id INT NOT NULL,
  created_on DATETIME NULL DEFAULT NULL,
  last_modified DATETIME NULL DEFAULT NULL,
  deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_on DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX fk_field_set_id (field_set_id ASC),
  CONSTRAINT fk_field_set_id
    FOREIGN KEY (field_set_id)
    REFERENCES field_set (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE field_set
(
  id INT NOT NULL AUTO_INCREMENT,

  created_on DATETIME NULL DEFAULT NULL,
  last_modified DATETIME NULL DEFAULT NULL,
  deleted TINYINT(1) NOT NULL DEFAULT 0,
  deleted_on DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id),
);