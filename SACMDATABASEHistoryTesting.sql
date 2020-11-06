DROP DATABASE IF EXISTS SACM;
CREATE DATABASE SACM;
USE SACM;

CREATE TABLE child (
    c_id                INT         NOT NULL    AUTO_INCREMENT,
    c_fname             VARCHAR(50) NOT NULL,
    c_lname             VARCHAR(50) NOT NULL,
    c_st_address        VARCHAR(50) NOT NULL,
    c_city              VARCHAR(50) NOT NULL,
    c_state             CHAR(2)     NOT NULL,
    c_zipcode           VARCHAR(9)  NOT NULL,
    c_gender            CHAR(1)     NOT NULL,
    c_email             VARCHAR(100),
    c_dob               DATE        NOT NULL,
    c_allergies         TEXT,
    c_cell_phone        VARCHAR(15),
    c_school            VARCHAR(50) NOT NULL,
    c_grade             VARCHAR(7)  NOT NULL,
    c_emg_contact_name  VARCHAR(50) NOT NULL,
    c_emg_contact_num   VARCHAR(15) NOT NULL,
    c_needs_trans       BOOL,
    c_active            BOOL    DEFAULT TRUE,

    PRIMARY KEY (c_id)
);

CREATE TABLE program (
    prog_id     INT         NOT NULL    AUTO_INCREMENT,
    prog_name   VARCHAR(50) NOT NULL,

    PRIMARY KEY (prog_id)
);

CREATE TABLE organizations (
    org_id                  INT         NOT NULL    AUTO_INCREMENT,
    org_name                VARCHAR(50) NOT NULL,
    org_email               VARCHAR(100),
    org_desc                TEXT,
    org_st_address          VARCHAR(50),
    org_city                VARCHAR(50),
    org_state               CHAR(2),
    org_zipcode             VARCHAR(9) ,
    org_phone               VARCHAR(20) NOT NULL,
    
    PRIMARY KEY (org_id)
);

CREATE TABLE prog_section (
    prog_sec                INT         NOT NULL    AUTO_INCREMENT,
    prog_id                 INT         NOT NULL,
    prog_time               VARCHAR(10),
    prog_day                VARCHAR(13) NOT NULL,
    prog_age_range          VARCHAR(30) NOT NULL,
    prog_seat_cap           INT         NOT NULL,
    prog_room               VARCHAR(50),
    prog_van_trans_avail    BOOL        NOT NULL,
    prog_sec_desc           VARCHAR(100) NOT NULL,
    prog_sec_active         BOOL        NOT NULL DEFAULT TRUE,

    PRIMARY KEY (prog_sec),
        FOREIGN KEY (prog_id) REFERENCES program(prog_id)
);

CREATE TABLE transportation (
    c_id            INT,
    prog_sec        INT,
    trans_type_to   VARCHAR(20),
    trans_type_from VARCHAR(20),

    PRIMARY KEY(c_id, prog_sec),
        FOREIGN KEY (c_id) REFERENCES child(c_id),
        FOREIGN KEY (prog_sec) REFERENCES prog_section(prog_sec)
);

CREATE TABLE person (
    person_id       INT         NOT NULL AUTO_INCREMENT,
    org_id          INT,
    p_fname         VARCHAR(50) NOT NULL,
    p_lname         VARCHAR(50) NOT NULL,
    p_st_address    VARCHAR(50),
    p_city          VARCHAR(50),
    p_state         CHAR(2),
    p_zipcode       VARCHAR(9),
    p_email         VARCHAR(100),
    p_cell_phone    VARCHAR(15),
    p_work_phone    VARCHAR(15),
    p_home_phone    VARCHAR(15),
    p_is_donor      BOOL         DEFAULT FALSE,
    p_is_volunteer  BOOL         DEFAULT FALSE,
    p_is_staff      BOOL         DEFAULT FALSE,
    p_is_guardian   BOOL         DEFAULT FALSE,
    

    PRIMARY KEY (person_id),
        FOREIGN KEY (org_id) REFERENCES organizations(org_id)
);

CREATE TABLE volunteer (
    person_id           INT         NOT NULL,
    primary_skill_type  VARCHAR(30),
    sec_skill_type      VARCHAR(30),

    PRIMARY KEY (person_id),
        FOREIGN KEY (person_id) REFERENCES person(person_id)
);

CREATE TABLE staff (
    person_id       INT         NOT NULL,
    staff_position  VARCHAR(30),

    PRIMARY KEY (person_id),
        FOREIGN KEY (person_id) REFERENCES person(person_id)
);

CREATE TABLE guardian (
    person_id   INT     NOT NULL,
    has_vehicle BOOL    NOT NULL,

    PRIMARY KEY (person_id),
        FOREIGN KEY (person_id) REFERENCES person(person_id)
);

CREATE TABLE donations (
    don_id      INT         NOT NULL    AUTO_INCREMENT,
    org_id      INT,
    person_id   INT,
    don_date    DATE        NOT NULL,
    don_desc    TEXT        NOT NULL,
    don_type    VARCHAR(20) NOT NULL,
        
    PRIMARY KEY (don_id),
        FOREIGN KEY (org_id) REFERENCES organizations(org_id),
        FOREIGN KEY (person_id) REFERENCES person(person_id)
);

CREATE TABLE program_donation (
    don_id      INT     NOT NULL,
    prog_sec    INT     NOT NULL,

    PRIMARY KEY (don_id, prog_sec),
        FOREIGN KEY (don_id) REFERENCES donations(don_id),
        FOREIGN KEY (prog_sec) REFERENCES prog_section(prog_sec)
);

CREATE TABLE teaches (
    person_id   INT     NOT NULL,
    prog_sec    INT     NOT NULL,

    PRIMARY KEY (person_id, prog_sec),
        FOREIGN KEY (person_id) REFERENCES person(person_id),
        FOREIGN KEY (prog_sec) REFERENCES prog_section(prog_sec)
);

CREATE TABLE enrollment (
    e_num                   INT     NOT NULL    AUTO_INCREMENT,
    c_id                    INT     NOT NULL,
    person_id               INT     NOT NULL,
    prog_sec                INT     NOT NULL,
    e_status                BOOL    DEFAULT TRUE,
    e_consent_sacm_van      BOOL,
    e_consent_attend        BOOL,
    e_consent_sm_phone      BOOL,
    e_consent_emg_med       BOOL,
    e_consent_to_publish    BOOL,
    
    PRIMARY KEY (e_num),
        FOREIGN KEY (c_id) REFERENCES child(c_id),
        FOREIGN KEY (person_id) REFERENCES person(person_id),
        FOREIGN KEY (prog_sec) REFERENCES prog_section(prog_sec)
);

CREATE OR REPLACE VIEW  child_guardian_info_table AS
SELECT e.c_id, c_fname, c_lname, c_dob, e.person_id, p_fname, p_lname
FROM enrollment e, child c, person p
WHERE c.c_id = e.c_id
AND p.person_id = e.person_id
GROUP BY c_id, person_id;

/* 
CREATE OR REPLACE VIEW  relationship AS
SELECT e.c_id, c_fname, c_lname, c_dob, e.person_id, p_fname, p_lname
FROM enrollment e
JOIN child c
    ON c.c_id = e.c_id
JOIN person p
    ON p.person_id = e.person_id
GROUP BY c_id, person_id; 
 */
 
INSERT INTO child
(c_id, c_fname, c_lname, c_st_address, c_city, c_state, c_zipcode, c_gender, c_email, c_dob, c_allergies, c_cell_phone, c_school, c_grade, c_emg_contact_name, c_emg_contact_num, c_needs_trans, c_active) 
 VALUES
(1, 'Brett', 'Sullivan', '644 Sunset Ct.', 'Greensburg', 'PA', '15601', 'M', '', '2009-01-01', 'sunscreen - rash - wash affected area; lactose intolerance - gas, stomachache - avoid contamination, bathroom breaks', '', 'W. C. A.', '5th', 'Kurt Malfoy', '412-555-1616', 1, 1),
(2, 'Natalie', 'Sullivan', '644 Sunset Ct.', 'Greensburg', 'PA', '15601', 'F', '', '2007-01-01', '', '', 'W. C. A.', '7th', 'Kurt Malfoy', '412-555-1616', 1, 1),
(3, 'Caleb', 'Marinez', '1 St. Claire St.', 'Greensburg', 'PA', '15601', 'M', '', '2007-01-01', '', '', 'W. C. A.', '7th', 'Marianne Marinez', '724-506-7777', 0, 1),
(4, 'Javan', 'Marinez', '1 St. Claire St.', 'Greensburg', 'PA', '15601', 'M', '', '2009-01-01', 'chocolate - hives- benadryl', '', 'W. C. A.', '5th', 'Chris Marinez', '724-506-8080', 1, 1),
(5, 'Aiden', 'Bently', '811 Sunset Ct..', 'Greensburg', 'PA', '15601', 'M', '', '2008-01-01', '', '', 'G S Middle School', '6th', 'Boy Friend', '724-555-1000', 1, 1),
(6, 'Arianna', 'Bently', '811 Sunset Ct..', 'Greensburg', 'PA', '15601', 'F', '', '2010-01-01', 'grass - rash - wash area, benadryl', '', 'Nicely Elementary', '4th', 'Boy Friend', '724-555-1000', 1, 1),
(7, 'Andrew', 'Bently', '811 Sunset Ct..', 'Greensburg', 'PA', '15601', 'M', '', '2011-01-01', '', '', 'Nicely Elementary', '3rd', 'Boy Friend', '724-555-1000', 1, 1),
(8, 'Shania', 'Blaine', '112 Harvey Ave.', 'Greensburg', 'PA', '15601', 'F', '', '2011-01-01', 'pork - vomiting - call parent or emergency contact to pickup child', '', 'Nicely Elementary', '3rd', 'Felicia Blaine  Mother', '724-999-1111', 1, 1),
(9, 'Natalia', 'Fender', '600 Lynn Rd.', 'Greensburg', 'PA', '15601', 'F', '', '2011-01-01', '', '', 'Hutchinson Elementary', '3rd', 'Tristian Fender', '724-555-9999', 1, 1);

INSERT INTO program 
(prog_id, prog_name) 
VALUES
(1, 'Sunday School'),
(2, 'Youth Group - Younger'),
(3, 'Youth Group - Older'),
(4, 'Sunbeams'),
(5, 'Leaders In Training'),
(6, 'Explorers'),
(7, 'Rangers'),
(8, 'Moonbeams'),
(9, 'Girl Guards'),
(10, 'Bible Bowl'),
(11, 'Private Music Lesson'),
(12, 'Back To School Bash'),
(13, 'Corps Cadets');

INSERT INTO organizations 
(org_id, org_name, org_email, org_desc, org_st_address, org_city, org_state, org_zipcode, org_phone) 
VALUES
(1, '*** Not Affiliated ***', '', '', '', '', '', '', ''),
(2, 'Salvation Army  Grb', 'salvationarmy@salvationarmy.org', 'Salvation Army Grg Corps.', '131 E. Otterman St.', 'Greensburg', 'PA', '15601', '724-333-3333'),
(3, 'St. Vincent De Paul Society', 'contact@ourladyofgracechurch.org', 'Catholic Lay Org. Helpline Thrift Store And Food Pantry', '1011 Mount Pleasant Road', 'Greensburg', 'PA', '15601', '724-555-9480'),
(4, 'Sheetz ', 'manager@sheetz.com', 'Convenience Store', '211 Harvey Ave.', 'Greensburg', 'PA', '15601', '724-555-7144'),
(5, 'Friends Who Count', 'friendswhocount@internet.net', 'Back to School Bashschool List', '516 S. Roadname St.', 'Greensburg', 'PA', '15601', '724-555-5211'),
(6, 'Rotary Club Of Gbg', 'rotary@rotary.com', 'Where Neighbors Friends And Problemsolvers Share Ideas', 'P.o. Box 641', 'Greensburg', 'PA', '15601', '724-555-5555'),
(7, 'D M J Transportation', 'jamie@internet.com', 'Bussing Company', '5165 Carpentertown Rd', 'Mt. Pleasant', 'PA', '15666', '724-555-5078'),
(8, 'G S School District', 'melissa@lions.net', 'Local School District', '1 Academy Hill Place Greensburg', 'Greensburg', 'PA', '15601', '724-855-5555'),
(9, 'Greensburg Hempfield Area Library', 'librarian@libriaries.org', 'Local Library', '237 S. Pennsylvania Ave.', 'Greensburg', 'PA', '15601', '724-999-5555'),
(10, 'Comrades Barber Shop', 'comrades@email.com', 'Mens And Boys Salon', '615 S. Main St.', 'Greensburg', 'PA', '15601', '724-555-1234'),
(11, 'J C Pennys', 'contactperson@jcpenny.com', 'Department At Westmoreland Mall', '5256 Route 30', 'Greensburg', 'PA', '15601', '724-555-1111'),
(12, 'Seton Hill University', 'contact@setonhill.edu', 'Local University', '1 Seton Hill Drive', 'Greensburg', 'PA', '15601', '800-555-5555');

INSERT INTO prog_section
(prog_sec, prog_id, prog_time, prog_day, prog_age_range, prog_seat_cap, prog_room, prog_van_trans_avail, prog_sec_desc, prog_sec_active) 
VALUES
(1, 1, '9:30 AM', 'Sunday', 'K-5th', 0, 'Dropin Center', 0, '2018/2019', 0),
(2, 1, '9:30 AM', 'Sunday', '6th-12th', 0, 'Teen Room', 0, '2018/2019', 0),
(3, 1, '9:30 AM', 'Sunday', 'Nursery-Pre K', 0, 'Nursery', 0, '2018/2019', 0),
(4, 11, '3:00 PM', 'Monday', 'K-12th', 0, 'Stage', 0, '2018/2019', 0),
(5, 11, '3:15 PM', 'Monday', 'K-12th', 0, 'Stage', 0, '2018/2019', 0),
(6, 11, '3:30 PM', 'Monday', 'K-12th', 0, 'Stage', 0, '2018/2019', 0),
(7, 11, '3:00 PM', 'Tuesday', 'K-12th', 0, 'Stage', 0, '2018/2019', 0),
(8, 11, '3:15 PM', 'Tuesday', 'K-12th', 0, 'Stage', 0, '2018/2019', 0),
(9, 11, '3:30 PM', 'Tuesday', 'K-12th', 0, 'Stage', 0, '2018/2019', 0),
(10, 10, '4:30 PM', 'Tuesday', '6th-12th', 0, 'Fellowship Hall', 0, '2018/2019', 0),
(11, 6, '4:30 PM', 'Wednesday', '1st-5th', 0, 'Fellowship Class Room', 0, '2018/2019', 0),
(12, 13, '5:00 PM', 'Tuesday', '7th-12th', 0, 'Fellowship Hall', 0, '2018/2019', 0),
(13, 9, '5:00 PM', 'Wednesday', '6th-12th', 0, 'Drop-in Center', 0, '2018/2019', 0),
(14, 8, '5:00 PM', 'Wednesday', 'Nursery-K', 0, 'Chapel Class', 0, '2018/2019', 0),
(15, 7, '5:00 PM', 'Wednesday', '6th-12th', 0, 'Fellowship Class Room', 0, '2018/2019', 0),
(16, 12, '9:00 AM', 'Special Event', 'K-12th', 0, 'St Clair Park', 0, '2018/2019', 0),
(17, 12, '9:00 AM', 'Special Event', 'K-12th', 0, 'St Clair Park', 0, '2019/2020', 1),
(18, 1, '9:30 AM', 'Sunday', 'Nursery-Pre K', 0, 'Nursery', 0, '2019/2020', 1),
(19, 1, '9:30 AM', 'Sunday', 'K-5th', 0, 'Drop-in Center', 0, '2019/2020', 1),
(20, 1, '9:30 AM', 'Sunday', '6th-12th', 0, 'Teen Room', 0, '2019/2020', 1),
(21, 11, '3:00 PM', 'Monday', 'K-12th', 2, 'Stage', 0, '2019/2020', 1),
(22, 11, '3:15 PM', 'Monday', 'K-12th', 2, 'Stage', 0, '2019/2020', 1),
(23, 11, '3:30 PM', 'Monday', 'K-12th', 2, 'Stage', 0, '2019/2020', 1),
(24, 10, '5:30 PM', 'Tuesday', '6th-12th', 0, 'Fellowship Hall', 0, '2019/2020', 1),
(25, 13, '4:30 PM', 'Tuesday', '7th-12th', 0, 'Fellowship Hall', 0, '2019/2020', 1),
(26, 6, '4:30 PM', 'Wednesday', '1st-5th', 0, 'Fellowship Class Room', 0, '2019/2020', 1),
(27, 9, '5:00 PM', 'Wednesday', '6th-12th', 0, 'Drop-in Center', 0, '2019/2020', 1),
(28, 8, '5:00 PM', 'Wednesday', 'Pre K-K', 0, 'Chapel Class', 0, '2019/2020', 1),
(29, 7, '5:00 PM', 'Wednesday', '6th-12th', 0, 'Fellowship Class Room', 0, '2019/2020', 1),
(30, 4, '5:00 PM', 'Wednesday', '1st-5th', 0, 'Teen Room', 0, '2019/2020', 1);

INSERT INTO transportation 
(c_id, prog_sec, trans_type_to, trans_type_from) 
VALUES
(1, 1, 'Van', 'Van'),
(1, 7, 'Bus', 'Pick-up'),
(1, 11, 'Bus', 'Van'),
(1, 16, 'Walk', 'Walk'),
(1, 17, 'Walk', 'Walk'),
(1, 19, 'Van', 'Van'),
(1, 21, 'Bus', 'Pick-up'),
(1, 26, 'Bus', 'Van'),
(2, 8, 'Bus', 'Van'),
(2, 10, 'Van', 'Van'),
(2, 12, 'Bus', 'Van'),
(2, 13, 'Bus', 'Van'),
(2, 16, 'Walk', 'Walk'),
(2, 17, 'Walk', 'Walk'),
(2, 22, 'Bus', 'Van'),
(2, 24, 'Bus', 'Van'),
(2, 25, 'Bus', 'Van'),
(2, 27, 'Bus', 'Van'),
(3, 4, 'Drop-off', 'Walk'),
(3, 12, 'Walk', 'Walk'),
(3, 15, 'Drop-off', 'Walk'),
(3, 16, 'Walk', 'Walk'),
(3, 17, 'Walk', 'Walk'),
(3, 23, 'Bus', 'Walk'),
(3, 24, 'Bus', 'Van'),
(3, 29, 'Bus', 'Walk'),
(4, 1, 'Van', 'Van'),
(4, 7, 'Bus', 'Van'),
(4, 11, 'Van', 'Van'),
(4, 16, 'Walk', 'Walk'),
(4, 17, 'Walk', 'Walk'),
(4, 19, 'Walk', 'Walk'),
(4, 21, 'Bus', 'Walk'),
(4, 26, 'Bus', 'Van'),
(5, 2, 'Van', 'Van'),
(5, 8, 'Bus', 'Pick-up'),
(5, 10, 'Van', 'Van'),
(5, 15, 'Van', 'Van'),
(5, 16, 'Walk', 'Walk'),
(5, 17, 'Walk', 'Walk'),
(5, 20, 'Van', 'Van'),
(5, 24, 'Drop-off', 'Pick-up'),
(5, 29, 'Bus', 'Van'),
(6, 1, 'Walk', 'Van'),
(6, 16, 'Walk', 'Walk'),
(6, 17, 'Walk', 'Walk'),
(6, 19, 'Van', 'Van'),
(6, 23, 'Drop-off', 'Pick-up'),
(6, 30, 'Bus', 'Van'),
(7, 1, 'Van', 'Van'),
(7, 16, 'Walk', 'Walk'),
(7, 17, 'Walk', 'Walk'),
(7, 19, 'Van', 'Van'),
(7, 26, 'Drop-off', 'Pick-up'),
(7, 30, 'Van', 'Van'),
(8, 1, 'Van', 'Van'),
(8, 16, 'Drop-off', 'Pick-up'),
(8, 17, 'Walk', 'Walk'),
(8, 30, 'Van', 'Pick-up'),
(9, 1, 'Van', 'Van'),
(9, 9, 'Bus', 'Pick-up'),
(9, 16, 'Walk', 'Walk'),
(9, 17, 'Walk', 'Walk'),
(9, 22, 'Drop-off', 'Pick-up');

INSERT INTO person 
(person_id, org_id, p_fname, p_lname, p_st_address, p_city, p_state, p_zipcode, p_email, p_cell_phone, p_work_phone, p_home_phone, p_is_donor, p_is_volunteer, p_is_staff, p_is_guardian) 
VALUES
(1, 2, 'Marianne', 'Marinez', '1 St. Claire St.', 'Greensburg', 'PA', '15601', 'Marianne@Marinez.org', '724-555-7777', '724-333-3333', '', 1, 0, 1, 1),
(2, 2, 'Chris', 'Marinez', '1 St. Claire St.', 'Greensburg', 'PA', '15601', 'chis@Marinez.org', '724-506-8080', '', '724-333-3333', 0, 0, 1, 1),
(3, 2, 'Cpt. Z', 'Zlastname', '1 Town Rd.', 'Greensburg', 'PA', '15601', 'z@army.org', '536-555-1818', '724-333-3333', '', 0, 0, 1, 0),
(4, 2, 'Balindia', 'Jovalvich', '12 Diffroad St.', 'Jeannette', 'PA', '15644', 'belinda.jovalvich@use.salvationarmy.org', '724-555-9953', '724-333-3333', '', 1, 1, 1, 0),
(5, 2, 'Lt. Shey', 'Martinez', '1 Apartment St.', 'Greensburg', 'PA', '15601', 'chey.martinez@use.salvationarmy.org', '203-555-5686', '724-333-3333', '', 0, 0, 1, 0),
(6, 12, 'Charlie', 'Smith', '1 College Dorm Rd.', 'Greensburg', 'PA', '15601', 'charlie@internforsetonhill.edu', '205-555-5686', '', '', 1, 1, 0, 0),
(7, 1, 'Stacy', 'Sullivan', '644 Sunset Ct.', 'Greensburg', 'PA', '15601', 'stacyeld@yahoo.com', '410-955-5555', '', '', 1, 1, 0, 1),
(8, 1, 'Katie', 'Bently-Marcel', '811 Sunset Ct..', 'Greensburg', 'PA', '15601', 'Bently-Marcel@yahoo.com', '724-555-8721', '', '', 0, 0, 0, 1),
(9, 11, 'Gina', 'Davis', '105 Main St.', 'Greensburg', 'PA', '15601', 'gina@davis.com', '724-333-5555', '', '', 1, 0, 0, 0),
(10, 4, 'Terrance', 'Davis', '105 Main St. ', 'Greensburg', 'PA', '15601', 'terrance@davis.com', '724-444-5555', '', '', 1, 1, 0, 0),
(11, 10, 'Anthony', 'Harris', '505 Center Ave.', 'Greensburg', 'PA', '15601', 'anthony@harrris.com', '724-111-2222', '', '', 1, 1, 0, 0),
(12, 3, 'Carrol', 'Harris', '505 Center Ave.', 'Greensburg', 'PA', '15601', 'carrol@harris.com', '724-222-3333', '', '', 1, 1, 0, 0),
(13, 6, 'Thomas', 'Marcus', '363 Maple St.', 'Greensburg', 'PA', '15601', 'thomas@marcus.com', '724-333-1111', '', '', 1, 1, 0, 0),
(14, 1, 'Felicia', 'Blaine', '112 Harvey Ave.', 'Greensburg', 'PA', '15601', 'felicia@blaine.com', '724-999-1111', '', '', 1, 1, 0, 1),
(15, 7, 'Mark', 'Blaine', '112 Harvey Ave.', 'Greensburg', 'PA', '15601', 'mark@blaine.com', '724-333-3333', '', '', 1, 1, 0, 1),
(16, 1, 'Carol', 'Chester', '1234 Sheetz Dr.', 'Mt. Pleasant', 'PA', '15666', 'sandy@Chester.com', '724-123-1234', '', '', 1, 1, 0, 0),
(17, 1, 'Richy', 'Rich', '9999 Big Money Dr.', 'Pittsburgh', 'PA', '15671', 'richy@rich.com', '412-555-9999', '', '', 0, 0, 0, 0),
(18, 4, 'Cheryl', 'Noble', '567 Raymont Rd.', 'Greensburg', 'PA', '15601', 'cheryl@noble.com', '724-555-9542', '', '', 0, 1, 0, 0),
(19, 8, 'Tristian', 'Fender', '600 Lynn Rd.', 'Greensburg', 'PA', '15601', 'tristian@fender.com', '724-555-9999', '', '', 0, 0, 0, 1),
(20, 5, 'Trina', 'Fender', '600 Lynn Rd.', 'Greensburg', 'PA', '15601', 'trina@fender.com', '412-999-9999', '', '', 1, 0, 0, 1),
(21, 1, 'Salvador', 'Martinez', '789 Penn. Ave.', 'Greensburg', 'PA', '15601', '', '724-888-9595', '', '', 1, 1, 0, 0),
(22, 1, 'Cassandra ', 'Smith', '7015 Lynn Rd.', 'Greensburg', 'PA', '15601', '', '724-555-7777', '', '', 0, 1, 0, 0),
(23, 12, 'Candice', 'Burgeon', '7654 Pittsburgh St.', 'Greensburg', 'PA', '15601', 'candice@burgean.com', '724-999-5454', '', '', 1, 1, 0, 0),
(24, 1, 'Ashanti', 'Diddy', '2000 Holly St.', 'Greensburg', 'PA', '15601', 'ashanti@diddy.com', '412-444-7878', '', '', 1, 1, 0, 0),
(25, 9, 'Sharon', 'Stevens', '109087 Pittsburgh St.', 'Greensburg', 'PA', '15601', 'sharon@stevens.com', '412-987-9874', '', '', 1, 1, 0, 0);

INSERT INTO 
volunteer 
(person_id, primary_skill_type, sec_skill_type) 
VALUES
(4, 'Time', 'Service'),
(6, 'Cooking', 'Teaching'),
(7, 'Time', 'Service'),
(10, 'Cooking', 'Landscaping'),
(11, 'Teaching', 'Sports'),
(12, 'Cooking', 'Teaching'),
(13, 'Time', 'Service'),
(14, 'Time', 'Service'),
(15, 'Time', 'Service'),
(16, 'Dance', 'Baking'),
(18, 'Storytelling', 'Crocheting'),
(21, 'Spanish Speaking', 'Soccer'),
(22, 'Crafts', 'Praise Band'),
(23, 'Dance', 'Landscaping'),
(24, 'Choreography', 'Singing'),
(25, 'Decorating', 'Baking');

INSERT INTO staff 
(person_id, staff_position) 
VALUES
(1, 'Youth Pastor'),
(2, 'Worship Pastor'),
(3, 'Captain'),
(4, 'Business Administrative Assist'),
(5, 'Lieutenant');

INSERT INTO guardian 
(person_id, has_vehicle) 
VALUES
(1, 1),
(2, 1),
(7, 1),
(8, 1),
(14, 1),
(15, 1),
(19, 1),
(20, 1);


INSERT INTO donations 
(don_id, org_id, person_id, don_date, don_desc, don_type) 
VALUES
(3, 3, 12, '2019-02-23', 'Groceries', 'Item'),
(4, 5, 9, '2019-02-23', 'Shampoo', 'Item'),
(5, 9, 9, '2019-02-23', 'Party Hats', 'Item'),
(6, 6, 13, '2019-02-23', 'Face Painting', 'Time'),
(7, 2, 4, '2019-02-23', 'Face Painting', 'Time'),
(8, 12, 6, '2019-02-23', 'Teaching Intern', 'Time'),
(9, 1, 16, '2019-02-28', 'Cotton Candy Maker Table', 'Time'),
(10, 1, 16, '2019-02-28', 'Cotton Candy Maker Table', 'Time'),
(11, 1, 16, '2019-02-28', 'Bars Of Soap', 'Item'),
(12, 1, 16, '2019-02-25', 'Check For 500', 'Funds'),
(13, 1, 17, '2019-02-25', 'Check For 200', 'Funds'),
(14, 1, 21, '2019-02-25', 'Teaching Bilingual Class', 'Time'),
(15, 3, 12, '2019-02-25', 'Bars Of Soap', 'Item'),
(16, 1, 20, '2019-02-25', 'Check For 500', 'Funds'),
(17, 1, 24, '2019-02-25', 'Choreographed Dance Routine Solos', 'Service'),
(18, 1, 23, '2019-02-25', 'Kona Ice Truck', 'Service'),
(19, 1, 7, '2019-02-25', 'Hair Cuts', 'Service'),
(20, 1, 14, '2019-02-25', 'Chiropractic Adjustments', 'Service'),
(21, 6, 13, '2019-02-25', 'Check For 1,000 ', 'Funds'),
(22, 1, 1, '2019-02-25', 'Socks', 'Item'),
(23, 9, 25, '2019-02-25', 'Decorate For Bible Bowl Scrimmage', 'Time'),
(24, 1, 7, '2020-03-03', 'Conditioner', 'Item'),
(25, 2, 1, '2020-03-03', 'Sugar', 'Item'),
(26, 1, 4, '2020-03-03', 'Construction Paper', 'Item'),
(27, 12, 6, '2020-03-03', 'Check For 200', 'Funds'),
(28, 11, 9, '2020-03-03', 'Check For 1,000', 'Funds'),
(29, 4, 10, '2020-03-03', 'Pizza', 'Item'),
(30, 10, 11, '2020-03-03', 'Coupons For Free Haircuts', 'Item'),
(31, 3, 12, '2020-03-03', 'Check For 500', 'Funds'),
(32, 6, 13, '2020-03-03', 'Check For 1,000', 'Funds'),
(33, 6, 13, '2020-03-03', 'Face Painting', 'Time'),
(34, 1, 4, '2020-03-03', 'Face Painting', 'Time'),
(35, 12, 6, '2020-03-03', 'Teaching Intern', 'Time'),
(36, 1, 16, '2020-03-03', 'Cotton Candy Maker Table', 'Time'),
(37, 1, 16, '2020-03-03', 'Cotton Candy Maker Table', 'Time'),
(38, 1, 21, '2020-03-03', 'Teaching Bilingual Class', 'Time'),
(39, 1, 21, '2020-03-03', 'Translate At Competition', 'Service'),
(40, 1, 24, '2020-03-03', 'Choreographed Dance Routine Solos', 'Service'),
(41, 7, 15, '2020-03-03', 'Chiropractic Adjustments', 'Service');

INSERT INTO program_donation 
(don_id, prog_sec) 
VALUES
(3, 10),
(4, 14),
(5, 11),
(6, 1),
(7, 1),
(8, 14),
(9, 16),
(10, 11),
(11, 16),
(12, 16),
(13, 16),
(14, 1),
(15, 16),
(16, 16),
(17, 13),
(18, 16),
(19, 16),
(20, 16),
(21, 16),
(22, 16),
(23, 10),
(24, 17),
(25, 17),
(26, 30),
(27, 18),
(28, 21),
(29, 24),
(30, 26),
(31, 27),
(32, 29),
(33, 18),
(34, 18),
(35, 28),
(36, 17),
(37, 26),
(38, 18),
(39, 24),
(40, 27),
(41, 17);

INSERT INTO teaches 
(person_id, prog_sec) 
VALUES
(1, 1),
(1, 10),
(1, 12),
(1, 13),
(1, 16),
(1, 17),
(1, 19),
(1, 24),
(1, 25),
(1, 27),
(2, 2),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 11),
(2, 15),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 26),
(2, 29),
(3, 30),
(5, 3),
(5, 18),
(6, 14),
(6, 28);

INSERT INTO enrollment 
(e_num, c_id, person_id, prog_sec, e_status, e_consent_sacm_van, e_consent_attend, e_consent_sm_phone, e_consent_emg_med, e_consent_to_publish) 
VALUES
(1, 1, 7, 7, 1, 1, 1, 1, 1, 1),
(2, 1, 7, 1, 1, 1, 1, 1, 1, 1),
(3, 1, 7, 11, 1, 1, 1, 1, 1, 1),
(4, 2, 7, 10, 1, 1, 1, 1, 1, 1),
(5, 2, 7, 12, 1, 1, 1, 1, 1, 1),
(6, 2, 7, 13, 1, 1, 1, 1, 1, 1),
(7, 2, 7, 8, 1, 1, 1, 1, 1, 1),
(8, 3, 1, 12, 1, 1, 1, 1, 1, 1),
(9, 3, 1, 4, 1, 1, 1, 1, 1, 1),
(10, 3, 1, 15, 1, 1, 1, 1, 1, 1),
(11, 4, 2, 7, 1, 1, 1, 1, 1, 1),
(12, 4, 2, 1, 1, 1, 1, 1, 1, 1),
(13, 4, 2, 11, 1, 1, 1, 1, 1, 1),
(14, 5, 8, 2, 1, 1, 1, 1, 1, 1),
(15, 5, 8, 8, 1, 1, 1, 1, 1, 1),
(16, 5, 8, 10, 1, 1, 1, 1, 1, 1),
(17, 5, 8, 15, 1, 1, 1, 1, 1, 1),
(18, 6, 8, 1, 1, 1, 1, 1, 1, 1),
(19, 7, 8, 1, 1, 1, 1, 1, 1, 1),
(20, 8, 14, 16, 1, 1, 1, 1, 1, 1),
(21, 8, 15, 1, 1, 1, 1, 1, 1, 1),
(22, 7, 8, 16, 1, 1, 1, 1, 1, 1),
(23, 6, 8, 16, 1, 1, 1, 1, 1, 1),
(24, 5, 8, 16, 1, 1, 1, 1, 1, 1),
(25, 4, 2, 16, 1, 1, 1, 1, 1, 1),
(26, 3, 1, 16, 1, 1, 1, 1, 1, 1),
(27, 2, 7, 16, 1, 1, 1, 1, 1, 1),
(28, 1, 7, 16, 1, 1, 1, 1, 1, 1),
(29, 9, 19, 16, 1, 1, 1, 1, 1, 1),
(30, 9, 20, 9, 1, 1, 1, 1, 1, 1),
(31, 9, 19, 1, 1, 1, 1, 1, 1, 1),
(32, 1, 7, 17, 1, 1, 1, 1, 1, 1),
(33, 1, 7, 19, 1, 1, 1, 1, 1, 1),
(34, 1, 7, 21, 1, 1, 1, 1, 1, 1),
(35, 1, 7, 26, 1, 1, 1, 1, 1, 1),
(36, 2, 7, 17, 1, 1, 1, 1, 1, 1),
(37, 2, 7, 25, 1, 1, 1, 1, 1, 1),
(38, 2, 7, 27, 1, 1, 1, 1, 1, 1),
(39, 2, 7, 24, 1, 1, 1, 1, 1, 1),
(40, 2, 7, 22, 1, 1, 1, 1, 1, 1),
(41, 3, 2, 17, 1, 1, 1, 1, 1, 1),
(42, 3, 1, 24, 1, 1, 1, 1, 1, 1),
(43, 3, 2, 23, 1, 1, 1, 1, 1, 1),
(44, 3, 2, 29, 1, 1, 1, 1, 1, 1),
(45, 4, 1, 17, 1, 1, 1, 1, 1, 1),
(46, 4, 1, 19, 1, 1, 1, 1, 1, 1),
(47, 4, 1, 21, 1, 1, 1, 1, 1, 1),
(48, 4, 1, 26, 1, 1, 1, 1, 1, 1),
(49, 5, 8, 17, 1, 1, 1, 1, 1, 1),
(50, 5, 8, 20, 1, 1, 1, 1, 1, 1),
(51, 5, 8, 24, 1, 1, 1, 1, 1, 1),
(52, 5, 8, 29, 1, 1, 1, 1, 1, 1),
(53, 6, 8, 17, 1, 1, 1, 1, 1, 1),
(54, 6, 8, 19, 1, 1, 1, 1, 1, 1),
(55, 6, 8, 23, 1, 1, 1, 1, 1, 1),
(56, 6, 8, 30, 1, 1, 1, 1, 1, 1),
(57, 7, 8, 17, 1, 1, 1, 1, 1, 1),
(58, 7, 8, 30, 1, 1, 1, 1, 1, 1),
(59, 7, 8, 26, 1, 1, 1, 1, 1, 1),
(60, 8, 14, 17, 1, 1, 1, 1, 1, 1),
(61, 8, 14, 30, 1, 1, 1, 1, 1, 1),
(62, 9, 20, 17, 1, 1, 1, 1, 1, 1),
(63, 9, 20, 22, 1, 1, 1, 1, 1, 1),
(64, 7, 8, 19, 1, 1, 1, 1, 1, 1);
