create table coverimage(
  id bigint NOT NULL AUTO_INCREMENT primary key,
  userid bigint not null,
  username varchar(245) not null,
  coverimage varchar(245) not null
);