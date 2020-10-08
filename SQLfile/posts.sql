create table posts(
id BIGINT NOT NULL AUTO_INCREMENT primary key,
userid BIGINT not null,
username varchar(245) not null,      
title varchar(245) not null,
caption varchar(245) not null,
link varchar(245) not null,
textbody text not null,
tag varchar(245) not null,
dt date not null,
type varchar(245) not null,
likes bigint not null,
comments bigint not null,
visibility varchar(245) not null
);
--use the code below to update the table--
ALTER TABLE posts ADD COLUMN visibility varchar(245) not null;
UPDATE posts SET visibility = 'public';
