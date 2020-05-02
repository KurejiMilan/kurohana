create table token(
id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
logid char(64) NOT NULL UNIQUE,
userid BIGINT NOT NULL  
);