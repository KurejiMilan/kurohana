CREATE TABLE verification(
  userid BIGINT UNSIGNED NOT NULL,
  verification_code MEDIUMINT UNSIGNED NOT NULL,
  time DATETIME NOT NULL,
  verified TINYINT NOT NULL DEFAULT 0,
  FOREIGN KEY (userid) REFERENCES users(userid)
);
