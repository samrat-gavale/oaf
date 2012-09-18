CREATE DATABASE IF NOT EXISTS Faculty_Permanent;

USE Faculty_Permanent;

CREATE TABLE Accounts
 (
 Application_ID INT(7) PRIMARY KEY AUTO_INCREMENT,
 User_ID int(5) UNIQUE NOT NULL,
 Email_ID varchar(35) UNIQUE NOT NULL,
 Password varchar(40) NOT NULL
 );

CREATE TABLE IF NOT EXISTS Personal_Information
(
User_ID int(5) NOT NULL,
Firstname VARCHAR(15),
Middlename VARCHAr(15),
Lastname VARCHAR(15) NOT NULL,
Correspondence_Address VARCHAR(200) NOT NULL,
Correspondence_Phone VARCHAR(20),
Correspondence_Fax VARCHAR(20),
Correspondence_eMail VARCHAR(40) NOT NULL,
Permanent_Address VARCHAR(200) NOT NULL,
Permanent_Phone VARCHAR(20),
Permanent_Fax VARCHAR(20),
Permanent_eMail VARCHAR(40),
Date_of_Birth DATE NOT NULL,
Age INT(2) NOT NULL,
Sex CHAR(1) NOT NULL,
Nationality VARCHAR(20) NOT NULL,
Category VARCHAR(5),
Marital_Status VARCHAR(2),
Photo_Extension VARCHAR(6),
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Referees
(
 Sr_No int(6) PRIMARY KEY AUTO_INCREMENT,
 User_ID int(5) NOT NULL,
 Name VARCHAR(40) NOT NULL,
 Designation VARCHAR(50) NOT NULL,
 Address VARCHAR(200) NOT NULL,
 Phone VARCHAR(20),
 Fax VARCHAR(20),
 Email_ID VARCHAR(40) NOT NULL,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Other_Information
(
 User_ID int(5) NOT NULL,
 Awards BOOL DEFAULT 0,
 Extracurriculars BOOL DEFAULT 0,
 Memberships TEXT(1000),
 Proficiencies TEXT(1000),
 Other_Info TEXT(1000),
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Future_Plans
(
 User_ID int(5) NOT NULL,
 Research_Plans BOOL DEFAULT 0,
 Teaching_Plans BOOL DEFAULT 0,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Application_Details
(
 User_ID int(5) NOT NULL UNIQUE,
 Advertisement_No varchar(30),
 Professor BOOL DEFAULT 0,
 Assistant_Professor BOOL DEFAULT 0,
 Associate_Professor BOOL DEFAULT 0,
 Assistant_Professor_Contract BOOL DEFAULT 0,
 Sch_Comp_Elec_Engg BOOL DEFAULT 0,
 Sch_Engg BOOL DEFAULT 0,
 Sch_Basic_Sci BOOL DEFAULT 0,
 Sch_Hum_Soc_Sci BOOL DEFAULT 0,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Sponsored_Research_Projects
( 
 User_ID int(5) NOT NULL,
 Completed_Nos INT(2) DEFAULT 0,
 Completed_Amount VARCHAR(40) DEFAULT 0,
 In_Progress_Nos INT (2) DEFAULT 0,
 In_Progress_Amount VARCHAR(40) DEFAULT 0,
 List_Uploaded BOOL DEFAULT 0,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);


CREATE TABLE IF NOT EXISTS Forms_Submitted
(
User_ID int(5) NOT NULL UNIQUE,
Application_Details BOOL DEFAULT 0,
Personal_Information BOOL DEFAULT 0,
Academic_Qualifications BOOL DEFAULT 0,
Teaching_Experience BOOL DEFAULT 0,
Sponsored_Research_Projects BOOL DEFAULT 0,
Thesis_Guidance BOOL DEFAULT 0,
Industrial_Experience BOOL DEFAULT 0,
Research_Papers BOOL DEFAULT 0,
Best_Papers BOOL DEFAULT 0,
Thrust_Areas_SOP BOOL DEFAULT 0,
Patents BOOL DEFAULT 0,
Other_Information BOOL DEFAULT 0,
Future_Plans BOOL DEFAULT 0,
General_Questions BOOl DEFAULT 0,
Referees BOOL DEFAULT 0,
Terms_Acceptance BOOL DEFAULT 0,
Confirmed_Applications BOOL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS Academic_Qualifications
(
Sr_No int(6) PRIMARY KEY AUTO_INCREMENT,
User_ID int(5) NOT NULL,
Degree_Examination VARCHAR(40) NOT NULL,
Specialization VARCHAR(40) NOT NULL,
University_Insti VARCHAR(50) NOT NULL,
Completion_Year Year NOT NULL,
Grade VARCHAR(10),
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Teaching_Experience
(
Sr_No int(6) PRIMARY KEY AUTO_INCREMENT,
User_ID int(5) NOT NULL,
University_Organisation VARCHAR(50) NOT NULL,
Designation VARCHAR(40) NOT NULL,
Period_From VARCHAR(50) NOT NULL,
Period_To VARCHAR(10) NOT NULL,
Total_Period VARCHAR(20),
Monthly_Salary VARCHAR(30),
Nature_of_Duties VARCHAR(200),
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Industrial_Experience
(
Sr_No int(6) PRIMARY KEY AUTO_INCREMENT,
User_ID int(5) NOT NULL,
Organisation VARCHAR(50) NOT NULL,
Designation VARCHAR(40) NOT NULL,
Period_From VARCHAR(10) NOT NULL,
Period_To VARCHAR(10) NOT NULL,
Total_Period VARCHAR(20),
Monthly_Salary VARCHAR(30),
Nature_of_Duties VARCHAR(200),
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Thesis_Guidance
(
User_ID int(5) PRIMARY KEY,
Completed INT(2) DEFAULT 0,
In_Progress INT(2) DEFAULT 0,
List_Uploaded BOOL DEFAULT 0,
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);


CREATE TABLE IF NOT EXISTS General_Questions
(
 User_ID int(5) PRIMARY KEY,
 Question_1 TEXT NOT NULL,
 Question_2 TEXT NOT NULL,
 Question_3 TEXT NOT NULL,
 Question_4 TEXT NOT NULL,
 Question_5 TEXT NOT NULL,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Research_Papers
(
 User_ID int(5) PRIMARY KEY,
 Num_Books_Pub INT(2) NOT NULL DEFAULT 0,
 Num_National_Journals INT(2) NOT NULL DEFAULT 0,
 Num_International_Journals INT(2) NOT NULL DEFAULT 0,
 Num_National_Conferences INT(2) NOT NULL DEFAULT 0,
 Num_International_Conferences INT(2) NOT NULL DEFAULT 0,
 Publications_List BOOL NOT NULL DEFAULT 0,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Best_Papers
(
 User_ID INT(5) PRIMARY KEY,
 Papers_Uploaded BOOL DEFAULT 0,
 FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Thrust_Areas_SOP
(
User_ID int(5) NOT NULL,
Thrust_Area VARCHAR(2) DEFAULT 0,
SOP TEXT,
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Patents
(
User_ID INT(5) PRIMARY KEY,
Num_Patents INT(2) DEFAULT 0,
Patents TEXT(2000),
FOREIGN KEY (User_ID) REFERENCES Accounts (User_ID)
);

CREATE TABLE IF NOT EXISTS Teaching_Exp_Num
(
User_ID INT(7),
Total_Period FLOAT(5)
);

