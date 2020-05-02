create table about
(
 id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
 username varchar(245) not null,
 creator boolean not null,
 individual boolean not null,
 company boolean not null,
 companyname varchar(245) not null,
 companyurl varchar(245) not null,
 creating varchar(245) not null,
 address varchar(245) not null,
 contact varchar(10) not null
);
--use this to modify the existing tables
ALTER TABLE about MODIFY COLUMN contact varchar(10) NOT NULL
