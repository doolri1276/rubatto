CREATE TABLE memo(
	num int NOT NULL AUTO_INCREMENT,
	id VARCHAR(20) NOT NULL,
	name VARCHAR(20) NOT NULL,
	nick VARCHAR(20) NOT NULL,
	content TEXT NOT NULl,
	regist_day DATETIME NOT NULL,
	PRIMARY KEY(num),
	INDEX(id)
);