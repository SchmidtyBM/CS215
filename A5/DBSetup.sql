-- Clean up tables
DROP TABLE IF EXISTS Votes, Answers, Questions, Users;

-- Users Table
CREATE TABLE Users (
  user_id INT NOT NULL AUTO_INCREMENT,
  email VARCHAR(32) NOT NULL,
  screenname VARCHAR(32) NOT NULL,
  birthdate DATE NOT NULL,
  avatar VARCHAR(255) NOT NULL,
  password VARCHAR(32) NOT NULL,
  PRIMARY KEY (user_id)
);

-- Question Table
CREATE TABLE Questions (
  question_id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  question VARCHAR(200) NOT NULL,
  created_dt DATETIME NOT NULL,
  PRIMARY KEY (question_id),
  FOREIGN KEY (user_id) REFERENCES Users (user_id)
);


-- Answers Table
CREATE TABLE Answers (
  answer_id INT NOT NULL AUTO_INCREMENT,
  question_id INT NOT NULL,
  user_id INT NOT NULL,
  answer VARCHAR(1500) NOT NULL,
  created_dt DATETIME NOT NULL,
  PRIMARY KEY (answer_id),
  FOREIGN KEY (question_id) REFERENCES Questions (question_id),
  FOREIGN KEY (user_id) REFERENCES Users (user_id)
);



-- Votes Tables
 CREATE TABLE Votes (
  vote_id INT NOT NULL AUTO_INCREMENT,
  answer_id INT NOT NULL,
  user_id INT NOT NULL,
  up_vote INT NOT NULL,
  down_vote INT NOT NULL,
  PRIMARY KEY (vote_id),
  FOREIGN KEY (answer_id) REFERENCES Questions (question_id),
  FOREIGN KEY (user_id) REFERENCES Users (user_id)
);
