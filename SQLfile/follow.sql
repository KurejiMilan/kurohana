create table follow
(
 id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
 following varchar(245) not null ,
 followedby varchar(245) not null
);