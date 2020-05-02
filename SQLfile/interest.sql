create table interest(
id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
username varchar(245) NOT NULL,
interest varchar(245) NOT NULL
);

--USE THIS SQLI QUERY FIRST
ALTER TABLE interest ADD interest varchar(245) NOT NULL;

--USE THIS SQLI QUERY AT LAST
ALTER TABLE interest DROP art;
ALTER TABLE interest DROP FilmAnimation;
ALTER TABLE interest DROP news;
ALTER TABLE interest DROP design;
ALTER TABLE interest DROP music;
ALTER TABLE interest DROP entertainment;
ALTER TABLE interest DROP comedy;
ALTER TABLE interest DROP literature;
ALTER TABLE interest DROP diy;
ALTER TABLE interest DROP fashion;
ALTER TABLE interest DROP scienceandtech;
ALTER TABLE interest DROP education;
ALTER TABLE interest DROP shortstories;
ALTER TABLE interest DROP MangaAnime;
ALTER TABLE interest DROP comics;

--YOU CAN DELETE ALL THESE WHEN THE DATABASE TABLE IS UPDATED AND JUST KEEP create table interest
art BOOLEAN NOT NULL,
FilmAnimation BOOLEAN NOT NULL,
news BOOLEAN NOT NULL,
design BOOLEAN NOT NULL,
music BOOLEAN NOT NULL,
entertainment BOOLEAN NOT NULL,
comedy BOOLEAN NOT NULL,
literature BOOLEAN NOT NULL,
diy BOOLEAN NOT NULL,
fashion BOOLEAN NOT NULL,
scienceandtech BOOLEAN NOT NULL,
education BOOLEAN NOT NULL,
shortstories BOOLEAN NOT NULL,
MangaAnime BOOLEAN NOT NULL,
comics BOOLEAN NOT NULL