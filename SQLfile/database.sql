-- create table users(
-- userid bigint AUTO_INCREMENT primary key not null,
-- name varchar(245) not null,
-- username varchar(245) not null,
-- useremail varchar(245) not null,
-- userpassword varchar(245) not null,
-- sign_up_date date NOT NULL,
-- varifiedbadge boolean not null,
-- badgeoverride boolean not null,
-- bio text NOT NULL,
-- token INT NOT NULL,
-- emailvar boolean NOT NULL,
-- followers bigint not null,
-- following bigint not null,
-- activated enum('0','1') NOT NULL
-- );

CREATE TABLE IF NOT EXISTS users(
  userid BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name varchar(50) NOT NULL,
  username varchar(50) UNIQUE NOT NULL,
  useremail varchar(100) UNIQUE NOT NULL,
  password varchar(255) NOT NULL,
  sign_up_date DATE NOT NULL,
  bio text NOT NULL,
  followers INT UNSIGNED NOT NULL DEFAULT 0,
  following INT UNSIGNED NOT NULL DEFAULT 0,
  active TINYINT NOT NULL DEFAULT 0
);
