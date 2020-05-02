create table notification
(
 id bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
 name VARCHAR(245) NOT NULL,
 notification VARCHAR(245) NOT NULL,
 link VARCHAR(245) NOT NULL,
 dt date NOT  NULL,
 seen bool NOT NULL
);
--use the code below to update the table--
ALTER TABLE notification
DROP COLUMN tm;
ADD COLUMN postid BIGINT NOT NULL;