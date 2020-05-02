create table users(
userid bigint AUTO_INCREMENT primary key not null,
name varchar(245) not null,
username varchar(245) not null,
useremail varchar(245) not null,
userpassword varchar(245) not null,
sign_up_date date NOT NULL,
varifiedbadge boolean not null,
badgeoverride boolean not null, 
bio text NOT NULL,
token INT NOT NULL,
emailvar boolean NOT NULL,
followers bigint not null,
following bigint not null,
activated enum('0','1') NOT NULL
);
--ALTER TABLE users--
 --ADD COLUMN--
