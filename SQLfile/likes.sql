create table likes(
id bigint not null primary key auto_increment,
postid bigint not null,
likedby varchar(245) not null,
dt date not null 
);