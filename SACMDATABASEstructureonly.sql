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

INSERT INTO organizations
    (org_id, org_name,  org_email, org_desc, org_st_address, org_city, org_state, org_zipcode, org_phone)
VALUES
(1, '*** Not Affiliated ***', '', '', '', '', '', '', '');

CREATE OR REPLACE VIEW  child_guardian_info_table AS
SELECT 
    e.c_id, 
    c_fname, 
    c_lname, 
    c_dob, 
    e.person_id, 
    p_fname, 
    p_lname
FROM enrollment e
JOIN child c
    ON c.c_id = e.c_id
JOIN person p
    ON p.person_id = e.person_id
GROUP BY c_id, person_id; 

/* CREATE OR REPLACE VIEW  relationship AS
SELECT e.c_id, c_fname, c_lname, c_dob, e.person_id, p_fname, p_lname
FROM enrollment e
JOIN child c
    ON c.c_id = e.c_id
JOIN person p
    ON p.person_id = e.person_id
GROUP BY c_id, person_id; */


/* GRANT SELECT, INSERT, DELETE, UPDATE
ON SACM.* 
TO root@localhost
IDENTIFIED BY ''; */