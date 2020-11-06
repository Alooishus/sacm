SELECT p_fname,
    p_lname,
    don_type
FROM person p
JOIN organizations o ON p.org_id = o.org_id
JOIN donations d ON o.org_id = d.org_id
JOIN program_donation pd ON d.don_id = pd.don_id
JOIN prog_section ps ON ps.prog_sec = pd.prog_sec
JOIN program pr ON pr.prog_id = ps.prog_id
WHERE o.org_name = "Salvation Army  Grb"
AND prog_name = "Sunday School"
AND p_is_volunteer = TRUE
AND don_type = "Time"
OR don_type = "Service"

select * from organizations
where org_name = 'Salvation Army Grb'

select * from person
select * from donations

SELECT p_fname,
    p_lname,
    org_name,
    p_cell_phone,
    prog_name,
    prog_day,
    don_type,
    prog_sec_desc
FROM person p
JOIN organizations o ON p.org_id = o.org_id
JOIN donations d ON o.org_id = d.org_id
JOIN program_donation pd ON d.don_id = pd.don_id
JOIN prog_section ps ON ps.prog_sec = pd.prog_sec
JOIN program pr ON pr.prog_id = ps.prog_id
WHERE p.person_id = 16
AND don_type = "Time"
OR don_type = "Service"

selec