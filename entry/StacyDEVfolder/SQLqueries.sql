-- works like MINUS operator
select a.id 
from table1 as a 
where <condition> 
AND a.id NOT IN (select b.id 
                 from table2 as b 
                 where <condition>);


                
-- attendence query
SELECT 
    c.c_fname,
    c.c_gender,
    c.c_lname,
    c.c_grade,
    TIMESTAMPDIFF(YEAR, c.c_dob, CURDATE()) AS Age,
    c.c_school,
    pr.prog_id,
    pr.prog_name,
    ps.prog_sec,
    pr.prog_name,
    ps.prog_day
FROM prog_section ps
    JOIN program pr
        ON ps.prog_id = pr.prog_id
    JOIN enrollment e
        ON ps.prog_sec = e.prog_sec
    JOIN child c
        ON e.c_id = c.c_id
    JOIN person pe
        ON e.person_id = pe.person_id
WHERE ps.prog_sec_active = TRUE
AND ps.prog_sec = :prog_sec
ORDER BY  
    c.c_fname,
    c.c_lname;


SELECT 
    p.prog_id, 
    p.prog_name, 
    ps.prog_age_range, 
    ps.prog_day, 
    ps.prog_sec_desc, 
    ps.prog_time, 
    ps.prog_sec  
FROM prog_section ps
Join program p
    ON ps.prog_id = p.prog_id
WHERE ps.prog_sec = :prog_sec 



UPDATE 
    enrollment e
JOIN child c
    ON e.e_num = 5
    AND e.c_id = c.c_id    
JOIN prog_section ps
    ON e.prog_sec = ps.prog_sec
JOIN transportation t 
    ON ps.prog_sec = t.prog_sec
SET
    e.e_status = true,
    e.e_consent_sacm_van = false, 
    e.e_consent_attend = false, 
    e.e_consent_sm_phone = false, 
    e.e_consent_emg_med = false, 
    e.e_consent_to_publish = false,
    t.trans_type_to = "SACM Van",
    t.trans_type_from = "SACM Van"


UPDATE 
    enrollment e
JOIN child c
    ON e.e_num = 5
    AND e.c_id = c.c_id    
JOIN prog_section ps
    ON e.prog_sec = ps.prog_sec
SET
    e.e_status = true,
    e.e_consent_sacm_van = false, 
    e.e_consent_attend = false, 
    e.e_consent_sm_phone = false, 
    e.e_consent_emg_med = false, 
    e.e_consent_to_publish = false
    
    
    
UPDATE 
    transportation t
SET
    t.trans_type_to = "SACM Van",
    t.trans_type_from = "Walk"
WHERE
    t.c_id = 2
AND 
    t.prog_sec = 10


UPDATE 
    transportation t
SET
    t.trans_type_to = "SACM Van",
    t.trans_type_from = "Walk"
WHERE
    t.c_id = 6
AND 
    t.prog_sec = 1


UPDATE 
    transportation t
SET
    t.trans_type_to = "NATALIE",
    t.trans_type_from = "NATALIE"
WHERE
    t.c_id = :c_id
AND 
    t.prog_sec = :prog_sec

-- currently used to find enroolments
SELECT 
    e.e_num,
    e.c_id,
    e.person_id,
    e.prog_sec,
    e.e_status,
    e.e_consent_sacm_van,
    e.e_consent_attend,
    e.e_consent_sm_phone,
    e.e_consent_emg_med,
    e.e_consent_to_publish,
    p.prog_name, 
    ps.prog_age_range, 
    ps.prog_day, 
    ps.prog_sec_desc, 
    ps.prog_time, 
    ps.prog_sec
FROM enrollment e    
    JOIN prog_section ps 
        ON e.prog_sec = ps.prog_sec
    JOIN program p
        ON ps.prog_id = p.prog_id
WHERE ps.prog_sec_active = true
AND e.c_id = 2
AND e.e_num = 5



-- mike's working join update

UPDATE donations
JOIN program_donation ON donations.don_id = program_donation.don_id
SET
    don_date = :don_date3,
    don_desc = :don_desc3,
    don_type = :don_type3,
    prog_sec = :prog_sec3
WHERE
    donations.don_id = :don_id2


SELECT 
    t.trans_type_to,
    t.trans_type_from
FROM enrollment e
JOIN prog_section ps ON e.prog_sec = ps.prog_sec
JOIN transportation t ON ps.prog_sec = t.prog_sec
WHERE e.e_num = 1
AND t.c_id = 1





UPDATE
    enrollment e
JOIN prog_section ps ON e.prog_sec = ps.prog_sec
JOIN transportation t ON ps.prog_sec = t.prog_sec
SET
    t.trans_type_to = :trans_type_to,
    t.trans_type_from = :trans_type_from 
WHERE e.e_num = :e_num
AND t.c_id = :c_id

UPDATE
    enrollment e
JOIN prog_section ps ON e.prog_sec = ps.prog_sec
JOIN transportation t ON ps.prog_sec = t.prog_sec
SET
    t.trans_type_to = "School bus",
    t.trans_type_from = "Pick-up" 
WHERE e.e_num = 1
AND t.c_id = 1





if($don_type == "Time" || $don_type == "Service")
{
    $p_is_volunteer = true;
    $update_volunteer =
        'UPDATE person
        SET p_is_volunteer = true
        WHERE person_id = :person_id';
    $stmt5a = $db->prepare($update_volunteer);
    $stmt5a->bindValue(':person_id', $person_id);
    $stmt5a->execute();
    $stmt5a->closeCursor();

}

UPDATE person p
JOIN volunteer v ON p.person_id = v.person_id
SET p_is_volunteer = true,
    sec_skill_type = "Time or Service"
WHERE person_id = :person_id

UPDATE person p
JOIN volunteer v ON p.person_id = v.person_id
SET 
    v.sec_skill_type = "Time or Service"
WHERE v.person_id = 14


$insert_volunteer =
    'INSERT INTO volunteer
    (person_id, primary_skill_type, sec_skill_type)
VALUES
    (:person_id, :primary_skill_type, :sec_skill_type)';
$stmt = $db->prepare($insert_volunteer);
$stmt->bindValue(':person_id', $person_id);
$stmt->bindValue(':primary_skill_type', $primary_skill_type);
$stmt->bindValue(':sec_skill_type', $sec_skill_type);
$stmt->execute();
$stmt->closeCursor();











-- reports queries work
-- this first query is a list of all DONATIONs, with People and their information who gave them and their affilation  with an organization and all of its information
SELECT 
    d.person_id, 
    p.p_fname, 
    p.p_lname, 
    p.p_cell_phone, 
    p.p_email, 
    p.p_st_address, 
    p.p_city, 
    p.p_state, 
    p.p_zipcode, 
    d.don_type, 
    d.don_desc, 
    d.don_date, 
    pr.prog_name, 
    ps.prog_day, 
    o.org_name, 
    o.org_email, 
    o.org_st_address, 
    o.org_city, 
    o.org_state, 
    o.org_zipcode, 
    o.org_phone 
FROM donations d 
JOIN organizations o 
    ON o.org_id = d.org_id 
JOIN person p 
    ON p.person_id = d.person_id 
JOIN program_donation pd 
    ON pd.don_id = d.don_id 
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec 
JOIN program pr 
    ON pr.prog_id = ps.prog_id 
Order by d.don_id


--THIS WILL WORK FOR YOUR ALL DONATIONS (OF ITEM OR FUNDS) BUTTON SHOULD YOU CHOOSE TO ADD IT BACK IN
--THIS WORKS - lists ALL information for all donations of item or funds
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Item"
OR don_type = "Funds"
Order by d.don_id

--THIS WILL WORK FOR YOUR DONATIONS (OF ITEM OR FUNDS) BY KEYWORD SEARCH
--THIS WORKS - to find a don_desc from the list of all information for all donations (of item or funds) using don_desc
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
    AND d.don_desc = :don_desc
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Item"
OR don_type = "Funds"
Order by d.don_id

--THIS WILL WORK FOR YOUR DONATIONS (OF ITEM OR FUNDS) BY PROGRAM SEARCH
--THIS WORKS - to find all donations from the list of all information for all donations (of item or funds) using prog_id
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
    AND pr.prog_id = :prog_id
WHERE don_type = "Item"
OR don_type = "Funds"
Order by d.don_id

--THIS WILL WORK FOR YOUR DONATIONS (OF ITEM OR FUNDS) BY PERSON SEARCH
--THIS WORKS - to find a certain person from the list of all information for all donations (of item or funds) using person_id
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
    AND d.person_id = :person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Item"
OR don_type = "Funds"
Order by d.don_id

--THIS WILL WORK FOR YOUR DONATIONS (OF ITEM OR FUNDS) BY ORGANIZATION SEARCH
--THIS WORKS - to find a certain organization and its information from the list of all information for all donations (of item or funds) using org_id
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
    AND d.org_id = :org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Item"
OR don_type = "Funds"
Order by d.don_id


--THIS WILL WORK FOR AN ALL ACTUAL VOLUNTEERS (OF TIME OR SERVICE) IF YOU WOULD LIKE TO ADD, BUT NOT NECCESSARY. (IN ADDITION TO THE POSSIBLE VOLUNTEERS W/SKILLS LIST) 
--THIS WORKS - lists all information for all donations of Time or Service
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id

--THIS WILL WORK FOR YOUR VOLUNTEER LSIT (OF TIME OR SERVICE) BY PROGRAM SEARCH
--THIS WORKS - to find all Volunteers for a certain prog_name from the list of all information for all donations (of Servie or Time) using prog_name
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
    AND pr.prog_id = :prog_id
WHERE don_type = "Service"
OR don_type = "Time"
Order by d.don_id


--THIS WILL WORK FOR YOUR VOLUNTEER LSIT (OF TIME OR SERVICE) BY PERSON SEARCH
--THIS WORKS - to find a certain person from the list of all information for all donations (of Time or Service) using person_id
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
    AND d.person_id = :person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id

--THIS WILL WORK FOR YOUR VOLUNTEER LSIT (OF TIME OR SERVICE) BY ORGANIZATION SEARCH
--THIS WORKS - to get a list of all Volunteers from a certain organization and its information for all donations (of item or funds) using org_id
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
    AND d.org_id = :org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id

--THIS WILL WORK FOR YOUR VOLUNTEER LIST (OF TIME OR SERVICE) BY ORGANIZATION AND PROGRAM SEARCH
--THIS WORKS - to get a list of all Volunteers from a certain organization and its information from the list of all information for all donations (of Time or Service) using org_id and prog_id
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
    AND d.org_id = :org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
JOIN program pr 
    ON pr.prog_id = ps.prog_id
    AND pd.prog_id = :prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id








--THIS WILL WORK FOR YOUR VOLUNTEER LSIT (OF TIME OR SERVICE) BY DAY SEARCH
--THIS WORKS - to find a Volunteers from the list of all information for all donations (of Time or Service) using prog_day
SELECT 
    d.person_id,
    p.p_fname, 
    p.p_lname,
    p.p_cell_phone,
    p.p_email,
    p.p_st_address,
    p.p_city,
    p.p_state,
    p.p_zipcode,
    d.don_type, 
    d.don_desc,
    d.don_date, 
    pr.prog_name,
    ps.prog_day, 
    o.org_name,
    o.org_email,
    o.org_st_address,
    o.org_city,
    o.org_state,
    o.org_zipcode,
    o.org_phone
FROM donations d
JOIN organizations o 
    ON o.org_id = d.org_id
JOIN person p 
    ON p.person_id = d.person_id
JOIN program_donation pd 
    ON pd.don_id = d.don_id
JOIN prog_section ps 
    ON ps.prog_sec = pd.prog_sec
    AND ps.prog_day = :prog_day
JOIN program pr 
    ON pr.prog_id = ps.prog_id
WHERE don_type = "Time"
OR don_type = "Service"
Order by d.don_id




--get kids who havv been enrolled but not currently enrolled in any active sections

SELECT e.c_id,
        c.c_fname,
        c.c_gender,
        c.c_lname,
        c.c_grade,
        TIMESTAMPDIFF(YEAR, c.c_dob, CURDATE()) AS age,
        c.c_city,
        c.c_st_address,
        c.c_school,
        e.person_id,
        p.p_fname,
        p.p_lname,
        e.e_num,
        p.p_cell_phone
    FROM child c
        JOIN enrollment e
            ON c.c_id = e.c_id
        JOIN transportation t
            ON c.c_id = t.c_id
            AND e.prog_sec = t.prog_sec
        JOIN prog_section ps
            ON ps.prog_sec = t.prog_sec
        JOIN program pr
            ON ps.prog_id = pr.prog_id
        jOIN person p 
            ON e.person_id = p.person_id
    WHERE  e.c_id NOT IN(
                        SELECT e.c_id
                            FROM child c
                                JOIN enrollment e
                                    ON c.c_id = e.c_id
                                JOIN transportation t
                                    ON c.c_id = t.c_id
                                    AND e.prog_sec = t.prog_sec
                                JOIN prog_section ps
                                    ON ps.prog_sec = t.prog_sec
                                JOIN program pr
                                    ON ps.prog_id = pr.prog_id
                                jOIN person p 
                                    ON e.person_id = p.person_id
                            WHERE ps.prog_sec_active = true
                        )
    GROUP BY c.c_id
    ORDER BY c.c_lname,c.c_fname