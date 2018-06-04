CREATE TABLE member (
	user_id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
	uiu_id VARCHAR(20) NOT NULL UNIQUE,
	email VARCHAR(254) NOT NULL,
	password VARCHAR (128),
	PRIMARY KEY (email)
);

CREATE TABLE user_info(
  user_id INT(11) NOT NULL,
  firstname VARCHAR(32),
  lastname VARCHAR(32),
  middlename VARCHAR(32),
  birthdate VARCHAR (15),
  dp VARCHAR(300),
  primary KEY (user_id),
  FOREIGN key (user_id) REFERENCES member(user_id)
);

CREATE table phone(
  user_id INT(11) NOT NULL,
  phone VARCHAR(20) NOT NULL,
  PRIMARY key (user_id, phone),
  FOREIGN key (user_id) REFERENCES member(user_id)
);

CREATE table forgot_token(
  email VARCHAR(256) NOT NULL,
  token VARCHAR(256) NOT NULL,
  PRIMARY key (token),
  FOREIGN key (email) REFERENCES member(email)
);

CREATE table follow(
  user_id INT(11) NOT NULL,
  followed_id INT(11) NOT NULL,
	time_stamp VARCHAR(20),
  PRIMARY key(user_id, followed_id),
  FOREIGN key (user_id) REFERENCES member(user_id),
  FOREIGN key (followed_id) REFERENCES member(user_id)
);

CREATE TABLE message(
  m_id INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  receiver_id INT(11) NOT NULL,
  message VARCHAR(3000),
	flag INT(1) DEFAULT 0,
	time_stamp VARCHAR(20),
  primary KEY (m_id),
  FOREIGN key (user_id) REFERENCES member(user_id),
	FOREIGN key (receiver_id) REFERENCES member(user_id)
);

CREATE TABLE m_attachment(
  m_id INT(11)  NOT NULL,
  attachment VARCHAR(300),
  FOREIGN key (m_id) REFERENCES message(m_id)
);

CREATE TABLE building(
  building VARCHAR(32),
  location VARCHAR(200),
  description VARCHAR(1000),
  PRIMARY key(building, location)
);
CREATE TABLE department(
  dept_name VARCHAR(10),
  name VARCHAR (100),
  description VARCHAR(1000),
  PRIMARY key(dept_name)
);
CREATE table room(
	building VARCHAR(32) NOT NULL,
  room VARCHAR(10) NOT NULL,
  PRIMARY key(room,building),
  FOREIGN key (building) REFERENCES building(building)
);
CREATE TABLE faculty(
	faculty_id VARCHAR(20) NOT NULL,
  user_id INT(11) NOT NULL,
  dept_name VARCHAR(10),
  designation VARCHAR(20),
  joining_date VARCHAR(20),
  PRIMARY key(user_id, faculty_id),
  FOREIGN key (user_id) REFERENCES member(user_id),
  FOREIGN key (dept_name) REFERENCES department(dept_name)
);
CREATE TABLE student(
	student_id VARCHAR(20) NOT NULL,
  user_id INT(11) NOT NULL,
  dept_name VARCHAR(20) NOT NULL,
  addmission_date VARCHAR(20) NOT NULL,
  PRIMARY key(user_id, student_id),
  FOREIGN key(dept_name) REFERENCES department(dept_name),
  FOREIGN key (user_id) REFERENCES member(user_id)
);
CREATE TABLE staff(
	staff_id VARCHAR(20) NOT NULL,
  user_id INT(11) NOT NULL,
  dept_name VARCHAR(10) NOT NULL,
  designation VARCHAR (20),
  joining_date VARCHAR (20),
  PRIMARY key(user_id, staff_id),
  FOREIGN key(dept_name) REFERENCES department(dept_name),
  FOREIGN key (user_id) REFERENCES member(user_id)
);
CREATE TABLE course(
  course_code VARCHAR(10) NOT NULL,
  dept_name VARCHAR(10) NOT NULL,
  course_name VARCHAR(50) NOT NULL,
  credit VARCHAR(5) NOT NULL,
  PRIMARY KEY(course_code,dept_name),
  FOREIGN key (dept_name) REFERENCES department(dept_name)
);

CREATE TABLE section(
  section_id INT(11) UNIQUE NOT NULL AUTO_INCREMENT,
  course_code VARCHAR(10) NOT NULL,
  dept_name VARCHAR(10) NOT NULL,
  section_name VARCHAR(10) NOT NULL,
  building VARCHAR (32) NOT NULL,
  room_number VARCHAR(10) NOT NULL,
  yr INT(4) NOT NULL,
  trimester VARCHAR(1) NOT NULL,
  timeslot VARCHAR(5) NOT NULL,
  PRIMARY key(course_code, section_name,dept_name,building,room_number,yr,trimester, timeslot),
  FOREIGN key (course_code) REFERENCES course(course_code),
  FOREIGN key (dept_name) REFERENCES department(dept_name),
  FOREIGN key (building) REFERENCES building(building),
  FOREIGN key (room_number) REFERENCES room(room)
);

CREATE TABLE post(
  post_id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  section_id INT(11) NOT NULL,
  post VARCHAR (3000),
	time_stamp VARCHAR(20),
  PRIMARY key (post_id),
  FOREIGN key (user_id) REFERENCES member(user_id),
  FOREIGN key (section_id) REFERENCES section(section_id)
);

CREATE TABLE p_seen(
  post_id INT(11) NOT NULL,
  user_id INT(11) NOT NULL,
  PRIMARY key (post_id, user_id),
  FOREIGN key (user_id) REFERENCES member(user_id),
	FOREIGN key (post_id) REFERENCES post(post_id)
);

CREATE TABLE p_attachment(
  post_id INT(11) NOT NULL,
  attachment VARCHAR(300),
  FOREIGN key (post_id) REFERENCES post(post_id)
);

CREATE TABLE comment(
  comment_id INT(11) NOT NULL AUTO_INCREMENT,
  user_id INT(11) NOT NULL,
  post_id INT(11) NOT NULL,
  comment VARCHAR(3000),
	time_stamp VARCHAR(20),
  PRIMARY key (comment_id),
  FOREIGN key (user_id) REFERENCES member(user_id),
  FOREIGN key (post_id) REFERENCES post(post_id)
);

CREATE TABLE c_attachment(
  comment_id INT(11) NOT NULL,
  attachment VARCHAR(300),
  FOREIGN key (comment_id) REFERENCES comment(comment_id)
);

CREATE table fa_assign(
  section_id INT(11) NOT NULL,
  faculty_id INT(11) NOT NULL,
  PRIMARY key(section_id,faculty_id),
  FOREIGN key (faculty_id) REFERENCES faculty(user_id),
  FOREIGN key (section_id) REFERENCES section(section_id)
);
CREATE table takes(
  section_id INT(11) NOT NULL,
  student_id INT(11) NOT NULL,
  PRIMARY key(section_id,student_id),
  FOREIGN key (section_id) REFERENCES section(section_id),
  FOREIGN key (student_id) REFERENCES student(user_id)
);
CREATE table ta_assign(
  section_id INT(11) NOT NULL,
  student_id INT(11)  NOT NULL,
  PRIMARY key(section_id,student_id),
  FOREIGN key (section_id) REFERENCES section(section_id),
  FOREIGN key (student_id) REFERENCES student(user_id)
);

CREATE table attendance(
  att_id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  section_id INT(11) NOT NULL,
  time_stamp VARCHAR(20) NOT NULL,
  PRIMARY key(att_id),
  FOREIGN key (section_id) REFERENCES section(section_id)
);

CREATE table present(
  att_id INT(11) NOT NULL,
  student_id INT(11)  NOT NULL,
  comment VARCHAR(1000),
  PRIMARY key(att_id,student_id),
  FOREIGN key (student_id) REFERENCES student(user_id),
  FOREIGN key (att_id) REFERENCES attendance(att_id)
);

CREATE TABLE online_quiz(
  quiz_id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  section_id INT(11) NOT NULL,
  title VARCHAR(200) ,
  description VARCHAR(3000),
  total_marks INT(11) NOT NULL,
  total_time VARCHAR(10),
  PRIMARY KEY (quiz_id),
  FOREIGN KEY(section_id) REFERENCES section(section_id)
);

CREATE TABLE question(
  quiz_id INT(11),
  question VARCHAR(200),
  description VARCHAR(300),
  mark INT(3),
  primary KEY (quiz_id),
  FOREIGN key (quiz_id) REFERENCES online_quiz(quiz_id)
);

CREATE TABLE taken(
  quiz_id INT(11) NOT NULL,
  student_id INT(11) NOT NULL,
  marks INT(3),
  comment VARCHAR(300),
  primary KEY (quiz_id,student_id),
  FOREIGN key (quiz_id) REFERENCES online_quiz(quiz_id),
  FOREIGN key (student_id) REFERENCES student(user_id)
);

CREATE TABLE work (
  work_id INT(11) NOT NULL AUTO_INCREMENT,
  section_id INT(11) NOT NULL,
  title VARCHAR(200),
  description VARCHAR(3000),
  deadline VARCHAR(20),
  PRIMARY KEY(work_id),
  FOREIGN KEY(section_id) REFERENCES attendance(section_id)
);

CREATE TABLE w_attachment(
  work_id INT(11) NOT NULL,
  attachment VARCHAR(300),
  PRIMARY KEY(work_id),
  FOREIGN key (work_id) REFERENCES work(work_id)
);

CREATE TABLE submission(
  s_id INT(11) NOT NULL AUTO_INCREMENT,
  work_id INT(11) NOT NULL,
  text VARCHAR(3000) NOT NULL,
  description VARCHAR(300),
  time_stamp VARCHAR (20) NOT NULL,
  PRIMARY KEY(s_id),
  FOREIGN KEY(work_id) REFERENCES work(work_id)
);

CREATE TABLE s_attachment(
  s_id INT(11) NOT NULL,
  attachment VARCHAR(300),
  PRIMARY KEY(s_id),
  FOREIGN key (s_id) REFERENCES submission(s_id)
);

ALTER TABLE `course` ADD INDEX(`course_name`);
ALTER TABLE `user_info` ADD INDEX(`firstname`,`lastname`, `middlename`);
