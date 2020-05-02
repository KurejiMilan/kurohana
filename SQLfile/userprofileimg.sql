create table userprofileimg
(
  id bigint NOT NULL AUTO_INCREMENT primary key,
  userid bigint not null,
  username varchar(245) not null,
  profileimage varchar(245) not null
);