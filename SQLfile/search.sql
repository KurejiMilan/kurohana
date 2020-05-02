create table search
(
	id bigint NOT NULL AUTO_INCREMENT PRIMARY KEY,
	search_id bigint not null, 
	usernameORtitle varchar(245) not null,
	nameORcaption varchar(245) not null,
	type varchar(245) not null
);