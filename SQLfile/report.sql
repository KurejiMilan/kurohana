create table report(
id bigint not null primary key auto_increment,
reportedBy varchar(255) not null,
report text not null
);