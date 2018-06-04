INSERT INTO member(uiu_id, email, password)
  VALUES
    (
      'UIUSTUDENTAA',
      'elyfes.com@gmail.com',
      'a8b64babd0aca91a59bdbb7761b421d4f2bb38280d3a75ba0f21f2bebc45583d446c598660c94ce680c47d19c30783a7'
    ),
    (
      'UIUSTUDENTAB',
      'atulhussain143@gmail.com',
      'a8b64babd0aca91a59bdbb7761b421d4f2bb38280d3a75ba0f21f2bebc45583d446c598660c94ce680c47d19c30783a7'
    ),
    (
      'UIUSTUDENTAC',
      'azizularif02@gmail.com',
      'a8b64babd0aca91a59bdbb7761b421d4f2bb38280d3a75ba0f21f2bebc45583d446c598660c94ce680c47d19c30783a7'
    ),
    (
      'UIUFACULTYAA',
      'faculty1@gmail.com',
      'a8b64babd0aca91a59bdbb7761b421d4f2bb38280d3a75ba0f21f2bebc45583d446c598660c94ce680c47d19c30783a7'
    ),
    (
      'UIUFACULTYAB',
      'faculty2@gmail.com',
      'a8b64babd0aca91a59bdbb7761b421d4f2bb38280d3a75ba0f21f2bebc45583d446c598660c94ce680c47d19c30783a7'
    ),
    (
      'UIUSTAFFAA',
      'staff@gmail.com',
      'a8b64babd0aca91a59bdbb7761b421d4f2bb38280d3a75ba0f21f2bebc45583d446c598660c94ce680c47d19c30783a7'
    );
INSERT INTO user_info(user_id, firstname, lastname, dp)
  VALUES
    (
      '1',
      'Sadidul',
      "Islam",
      "sadidul.jpg"
    ),
    (
      '2',
      'Atul',
      'Hussain',
      ""
    ),
    (
      '3',
      'Azizul',
      "Arif",
      ""
    ),
    (
      '4',
      'Mahmudul',
      "Islam",
      "mahmudul.jpg"
    ),
    (
      '5',
      'John',
      "Doe",
      ""
    ),
    (
      '6',
      'Anisur',
      "Rahman",
      ""
    );
INSERT INTO phone(user_id, phone)
  VALUES
    (
      '1',
      '01622087099'
    ),
    (
      '2',
      '01674642754'
    ),
    (
      '3',
      '01849632923'
    ),
    (
      '2',
      '01719279746'
    ),
    (
      '4',
      '00000000000'
    ),
    (
      '5',
      '11111111111'
    ),
    (
      '6',
      '22222222222'
    );
INSERT INTO department(dept_name, name)
  VALUES
    (
      'CSE',
      'Computer Science and Engeneering'
    ),
    (
      'EEE',
      'Eletrical and Electronics Engeneering'
    );
INSERT INTO building(building, location)
  VALUES
    (
      'Main Building',
      'Dhanmondi 15'
    ),
    (
      'North Building',
      'Dhanmondi 27'
    );
INSERT INTO room(building, room)
  VALUES
    (
      'Main Building',
      '102'
    ),
    (
      'North Building',
      '101'
    ),
    (
      'North Building',
      '102'
    ),
    (
      'Main Building',
      '103'
    ),
    (
      'Main Building',
      '101'
    );
INSERT INTO faculty(faculty_id, user_id, dept_name, designation, joining_date)
  VALUES
    (
      'UIUFACULTYAA',
      '4',
      "CSE",
      "Lecturer",
      "1481784768"
    ),
    (
      'UIUFACULTYAB',
      '5',
      "EEE",
      "Lecturer",
      "1481784000"
    );
INSERT INTO student(student_id, user_id, dept_name, addmission_date)
  VALUES
    (
      'UIUSTUDENTAA',
      '1',
      "CSE",
      "1481784768"
    ),
    (
      'UIUSTUDENTAB',
      '3',
      "EEE",
      "1481784000"
    ),
    (
      'UIUSTUDENTAC',
      '2',
      "EEE",
      "1481784000"
    );
INSERT INTO staff(staff_id, user_id, dept_name, designation, joining_date)
  VALUES
    (
      'UIUSTAFFAA',
      '6',
      "CSE",
      "Lab Assistant",
      "1481784768"
    );
INSERT INTO course(course_code, dept_name, course_name, credit)
  VALUES
    (
      'CSE 123',
      "CSE",
      "Object Oriented Programming",
      "3"
    ),
    (
      'CSE 124',
      "CSE",
      "Object Oriented Programming Lab",
      "1"
    ),
    (
      'CSE 125',
      "CSE",
      "Database Management System",
      "3"
    ),
    (
      'CSE 126',
      "CSE",
      "Database Management System Lab",
      "1"
    ),
    (
      'EEE 124',
      "EEE",
      "Electronics 1",
      "3"
    );
INSERT INTO section(course_code, dept_name, section_name, building, room_number, yr, trimester, timeslot)
  VALUES
    (
      'CSE 125',
      "CSE",
      "A",
      "North Building",
      "101",
      "2016",
      "3",
      "9:55"
    ),
    (
      'CSE 125',
      "CSE",
      "B",
      "North Building",
      "102",
      "2016",
      "3",
      "9:55"
    ),
    (
      'CSE 123',
      "CSE",
      "A",
      "Main Building",
      "101",
      "2016",
      "3",
      "12:45"
    ),
    (
      'CSE 124',
      "CSE",
      "A",
      "Main Building",
      "101",
      "2016",
      "3",
      "5:00"
    ),
    (
      'CSE 126',
      "CSE",
      "A",
      "Main Building",
      "101",
      "2016",
      "3",
      "3:35"
    );
INSERT INTO fa_assign(section_id, faculty_id)
  VALUES
    (
      '1',
      '4'
    ),
    (
      '2',
      '4'
    ),
    (
      '3',
      '5'
    ),
    (
      '4',
      '4'
    ),
    (
      '5',
      '5'
    );
INSERT INTO takes(section_id, student_id)
  VALUES
    (
      '1',
      '1'
    ),
    (
      '1',
      '3'
    ),
    (
      '2',
      '3'
    ),
    (
      '2',
      '2'
    ),
    (
      '4',
      '3'
    ),
    (
      '4',
      '2'
    ),
    (
      '5',
      '1'
    );
INSERT INTO ta_assign(section_id, student_id)
  VALUES
    (
      '3',
      '1'
    ),
    (
      '4',
      '3'
    );
