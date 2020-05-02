create table complain(
id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
filedBy varchar(255) not null,
url varchar(255) not null,
complain text not null,
detail text not null
);