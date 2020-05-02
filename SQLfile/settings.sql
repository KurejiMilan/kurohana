create table settings(
id bigint not null PRIMARY KEY auto_increment,
username varchar(245) not null,
likes boolean not null,
comments boolean not null
);