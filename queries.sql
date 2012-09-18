SELECT Firstname, Lastname, Date_of_Birth, Degree_Examination, University_Insti, Completion_Year FROM Personal_Information NATURAL JOIN Academic_Qualifications WHERE Degree_Examination LIKE 'P%'

SELECT Firstname, Lastname, Date_of_Birth, Sch_Comp_Elec_Engg, Sch_Engg, Sch_Basic_Sci, Sch_Hum_Soc_Sci, Assistant_Professor, Associate_Professor, Assistant_Professor_Contract, Professor, Degree_Examination, University_Insti, Completion_Year, Thrust_Area FROM Personal_Information NATURAL JOIN Application_Details NATURAL JOIN Academic_Qualifications NATURAL JOIN Thrust_Areas_SOP WHERE Degree_Examination LIKE 'P%'

SELECT Firstname, Lastname, Date_of_Birth, Sch_Comp_Elec_Engg, Sch_Engg, Sch_Basic_Sci, Sch_Hum_Soc_Sci, Assistant_Professor, Associate_Professor, Assistant_Professor_Contract, Professor, Degree_Examination, University_Insti, Completion_Year, 
REPLACE(REPLACE(REPLACE(REPLACE(Thrust_Area, '1', 'Materials for Electron.'), '2', 'Energy Efficient Infrastr.'), '3', 'IT Technologies'), '4', 'Others') as Thrust_Area FROM Personal_Information NATURAL JOIN Application_Details NATURAL JOIN Academic_Qualifications NATURAL JOIN Thrust_Areas_SOP WHERE Degree_Examination LIKE 'P%'

SELECT Firstname, Lastname, Date_of_Birth, Sch_Engg,
REPLACE (Sch_Comp_Elec_Engg, 1, 'Comp_Elec') AS School_Comp_Elec,
REPLACE (Sch_Basic_Sci, '1', 'Basic_Sci') AS School_Basic,
REPLACE (Sch_Hum_Soc_Sci,'1', 'Hum_Soc') AS School_Humanities,
REPLACE (Assistant_Professor, '1', 'Asst_Prof') AS Assistant_Proff,
REPLACE (Associate_Professor, '1', 'Assoc_Prof')AS Associate_Proff,
REPLACE (Assistant_Professor_Contract, '1', 'Asst_Contr') AS Assistant_Contract,
REPLACE (Professor, '1', 'Proff') AS Professor,
Degree_Examination, University_Insti, Completion_Year, 
REPLACE(REPLACE(REPLACE(REPLACE(Thrust_Area, '1', 'Materials for Electron.'), '2', 'Energy Efficient Infrastr.'), '3', 'IT Technologies'), '4', 'Others') as 
Thrust_Area
FROM Personal_Information NATURAL JOIN Application_Details NATURAL JOIN Academic_Qualifications NATURAL JOIN Thrust_Areas_SOP WHERE Degree_Examination LIKE 'P%'
 

SELECT 
REPLACE ('Professor', '0', '') AS Professor,
Degree_Examination, University_Insti, Completion_Year, 
REPLACE(REPLACE(REPLACE(REPLACE(Thrust_Area, '1', 'Materials for Electron.'), '2', 'Energy Efficient Infrastr.'), '3', 'IT Technologies'), '4', 'Others') as 
Thrust_Area
FROM Personal_Information NATURAL JOIN Application_Details NATURAL JOIN Academic_Qualifications NATURAL JOIN Thrust_Areas_SOP WHERE Degree_Examination LIKE 'P%'


SELECT
Firstname, Lastname, CONVERT(VARCHAR(8), Date_of_Birth, 3) AS [DD/MM/YY],
Specialization as "PhD Specialization", University_Insti as "PhD Insti", Completion_Year as "PhD Yr"
FROM Personal_Information LEFT JOIN Academic_Qualifications WHERE Degree_Examination LIKE 'Ph%' 


SELECT Firstname, Lastname, DATE_FORMAT(Date_of_Birth, '%d/%m/%Y') AS Date_of_Birth

/*save view as 'PhD' */
SELECT
User_ID, Specialization AS "PhD Specialization", University_Insti AS "PhD Insti", Completion_Year AS "PhD Yr"
FROM Academic_Qualifications
WHERE Degree_Examination LIKE 'Ph%'

/* save view as 'Bachelor' */
SELECT
User_ID, Degree_Examination as "Bachelors", Specialization AS "Bach Speciali", University_Insti AS "Bach Insti", Completion_Year AS "Bach Yr", Grade as "Bach Grade"
FROM Academic_Qualifications
WHERE Degree_Examination LIKE 'B%'

=====================================================================Masters==================================================================
/* save view as Masters */
SELECT
User_ID,
Degree_Examination as 'Masters', Specialization AS "Mast Speciali", University_Insti AS "Mast Insti", Completion_Year AS "Mast Yr", Grade as "Mast Grade"
FROM Academic_Qualifications
WHERE Degree_Examination LIKE 'M%' AND Degree_Examination NOT LIKE 'madh%' AND Degree_Examination NOT LIKE 'matr%'

----------------------------------------------------------------Teaching Experience-----------------------------------------------------
SELECT 
REPLACE(REPLACE(Total_Period, ' months', ''), '2', 'Energy Efficient Infrastr.'), '3', 'IT Technologies'), '4', 'Others') as 
Thrust_Area
FROM Personal_Information NATURAL JOIN Application_Details NATURAL JOIN Academic_Qualifications NATURAL JOIN Thrust_Areas_SOP WHERE Degree_Examination LIKE 'P%'


SELECT Accounts.User_ID, Accounts.Application_ID,Personal_Information.Firstname,Personal_Information.Middlename,
Personal_Information.Lastname,Personal_Information.Date_of_Birth,Academic_Qualifications.Degree_Examination,Academic_Qualifications.Specialization,
Academic_Qualifications.University_Insti,Academic_Qualifications.Completion_Year,Academic_Qualifications.Grade 
FROM Accounts LEFT JOIN (Personal_Information,Academic_Qualifications)
ON (Personal_Information.User_ID = Accounts.User_ID AND Academic_Qualifications.User_ID = Accounts.User_ID)



SELECT User_ID, Application_ID, Firstname, Middlename, Lastname, Date_of_Birth, Degree_Examination AS 'PhD', Specialization AS 'Phd_Spec', University_Insti AS 'PhD_Uni', Completion_Year AS 'Phd_Year', Grade as 'Phd_Grade' FROM result1 WHERE Degree_Examination LIKE 'Ph%'

SELECT User_ID, sum(Total_Period) FROM Teaching_Exp_Num GROUP BY User_ID;

SELECT User_ID, sum(Total_Period) AS Total_Period_Added FROM Research_Indus_Exp GROUP BY User_ID;

SELECT
Accounts.User_ID,
Accounts.Application_ID,
Personal_Information.Firstname,
Personal_Information.Middlename,
Personal_Information.Lastname,
DATE_FORMAT(Personal_Information.Date_of_Birth, '%d/%m/%Y') AS DOB,
`Phd Specialization`,
`PhD Insti`,
`PhD Yr`,
`Masters`,
`Mast Speciali`,
`Mast Insti`,
`Mast Yr`,
`Mast Grade`,
`Bachelors`,
`Bach Speciali`,
`Bach Insti`,
`Bach Yr`,
`Bach Grade`,
Teaching_Exp_Num.Total_Period as `Teach Exp`,
Res_Indus_Exp_Added.Total_Period_Added AS `Res/Indus Exp`,
Thesis_Guided.Completed AS Thesis_Cmpl,
Thesis_Guided.In_Progress AS Thesis_Prog,
Completed_Nos AS Cmpl_Proj,
Completed_Amount AS Cmpl_Proj_Amt,
In_Progress_Nos AS Prog_Proj,
In_Progress_Amount AS Prog_Proj_Amt,
Num_Books_Pub AS BP,
Num_National_Journals AS NJ,
Num_International_Journals AS IJ,
Num_National_Conferences AS NC,
Num_International_Conferences AS IC
FROM Accounts
LEFT JOIN (Personal_Information, PhD, Masters, Bachelor, Teaching_Exp_Num, Res_Indus_Exp_Added, Thesis_Guided, Sponsored_Research_Projects, Research_Papers) 
ON (Accounts.User_ID = PhD.User_ID AND Personal_Information.User_ID = Accounts.User_ID AND Accounts.User_ID = Masters.User_ID AND 
    Accounts.User_ID = Bachelor.User_ID AND Accounts.User_ID = Teaching_Exp_Num.User_ID AND Accounts.User_ID = Res_Indus_Exp_Added.User_ID AND
    Accounts.User_ID = Thesis_Guided.User_ID AND Accounts.User_ID = Sponsored_Research_Projects.User_ID AND
    Accounts.User_ID = Research_Papers.User_ID) GROUP BY Accounts.User_ID

SELECT
Accounts.User_ID,
Accounts.Application_ID,
Personal_Information.Firstname,
Personal_Information.Middlename,
Personal_Information.Lastname,
DATE_FORMAT(Personal_Information.Date_of_Birth, '%d/%m/%Y') AS DOB,
`Phd Specialization`,
`PhD Insti`,
`PhD Yr`,
`Masters`,
`Mast Speciali`,
`Mast Insti`,
`Mast Yr`,
`Mast Grade`,
`Bachelors`,
`Bach Speciali`,
`Bach Insti`,
`Bach Yr`,
`Bach Grade`,
Teaching_Exp_Num.Total_Period as `Teach Exp`,
Res_Indus_Exp_Added.Total_Period_Added AS `Res/Indus Exp`,
Thesis_Guided.Completed AS Thesis_Cmpl,
Thesis_Guided.In_Progress AS Thesis_Prog,
Completed_Nos AS Cmpl_Proj,
Completed_Amount AS Cmpl_Proj_Amt,
In_Progress_Nos AS Prog_Proj,
In_Progress_Amount AS Prog_Proj_Amt,
Num_Books_Pub AS BP,
Num_National_Journals AS NJ,
Num_International_Journals AS IJ,
Num_National_Conferences AS NC,
Num_International_Conferences AS IC
FROM Accounts
LEFT JOIN Personal_Information ON Personal_Information.User_ID = Accounts.User_ID
LEFT JOIN PhD ON Accounts.User_ID = PhD.User_ID 
LEFT JOIN Masters ON  Accounts.User_ID = Masters.User_ID
LEFT JOIN Bachelor ON Accounts.User_ID = Bachelor.User_ID
LEFT JOIN Teaching_Exp_Num ON Accounts.User_ID = Teaching_Exp_Num.User_ID
LEFT JOIN Res_Indus_Exp_Added ON Accounts.User_ID = Res_Indus_Exp_Added.User_ID
LEFT JOIN Thesis_Guided ON Accounts.User_ID = Thesis_Guided.User_ID
LEFT JOIN Sponsored_Research_Projects ON Accounts.User_ID = Sponsored_Research_Projects.User_ID 
LEFT JOIN Research_Papers ON Accounts.User_ID = Research_Papers.User_ID

-------------------------------------SCEE-----------------------------------------------------
SELECT * FROM AssproC_CSE LEFT JOIN `Final View` ON AssproC_CSE.User_ID = `Final View`.User_ID;

SELECT * FROM Asstpro_CSE LEFT JOIN `Final View` ON Asstpro_CSE.User_ID = `Final View`.User_ID;

SELECT * FROM Pro_CSE LEFT JOIN `Final View` ON Pro_CSE.User_ID = `Final View`.User_ID;

SELECT * FROM Assopro_CSE LEFT JOIN `Final View` ON Assopro_CSE.User_ID = `Final View`.User_ID;


--------------------------------------SBSC---------------------------------------------------
SELECT * FROM AssC_Basic LEFT JOIN `Final View` ON AssC_Basic.User_ID = `Final View`.User_ID;

SELECT * FROM Ass_Basic LEFT JOIN `Final View` ON Ass_Basic.User_ID = `Final View`.User_ID;

SELECT * FROM Pro_Basic LEFT JOIN `Final View` ON Pro_Basic.User_ID = `Final View`.User_ID;

SELECT * FROM Asso_Basic LEFT JOIN `Final View` ON Asso_Basic.User_ID = `Final View`.User_ID;


--------------------------------------SHSS---------------------------------------------------
SELECT * FROM AssC_Hum LEFT JOIN `Final View` ON AssC_Hum.User_ID = `Final View`.User_ID;

SELECT * FROM Ass_Hum LEFT JOIN `Final View` ON Ass_Hum.User_ID = `Final View`.User_ID;

SELECT * FROM Pro_Hum LEFT JOIN `Final View` ON Pro_Hum.User_ID = `Final View`.User_ID;

SELECT * FROM Asso_Hum LEFT JOIN `Final View` ON Asso_Hum.User_ID = `Final View`.User_ID;



------------------------------------------------SE-------------------------------------------
SELECT * FROM AssC_Engg LEFT JOIN `Final View` ON AssC_Engg.User_ID = `Final View`.User_ID;

SELECT * FROM Ass_Engg LEFT JOIN `Final View` ON Ass_Engg.User_ID = `Final View`.User_ID;

SELECT * FROM Pro_Engg LEFT JOIN `Final View` ON Pro_Engg.User_ID = `Final View`.User_ID;

SELECT * FROM Asso_Engg LEFT JOIN `Final View` ON Asso_Engg.User_ID = `Final View`.User_ID;

Dear Sir,
       please find the attached spreadsheets for posts
in SCEE.

AP_SCEE - assistant proff
APC_SCEE - assistabt proff on contr.
ASP_SCEE - associate proff 
P_SCEE - professor

Regards,
Techhelp,
IIT Mandi


Sir,
   please find the attached spreadsheets for the recruitment of
faculty in SCEE. These contain all the information as asked by
Director sir. Please tell if you  need any further improvements.

AP_SCEE - assistant proff
APC_SCEE - assistabt proff on contr.
ASP_SCEE - associate proff
P_SCEE - professor

Regards,
Samrat

