use iWork;

GO

CREATE FUNCTION check_AllTasksPerMonth
( @username varchar(20) ,@year varchar(5), @month varchar(3) )
returns bit
AS
BEGIN

	DECLARE @start_date varchar(30);
	DECLARE @end_date varchar(30);
	DECLARE @monthDays varchar(3);
	IF(@month in (4,6,9,11)) SET @monthDays = 30;
	ELSE IF(@month = 2) SET @monthDays = 28;
	ELSE SET @monthDays = 31;
	SET @start_date = @year + '-' + @month + '-01';
	SET @end_date = @year + '-' + @month + '-' +@monthDays;
	DECLARE @result bit;
	DECLARE @countAll int;
	DECLARE @countFinished int;

	SELECT @countAll = count(*)
	FROM Tasks T
	WHERE T.regular_employee = @username AND T.deadline BETWEEN @start_date AND @end_date

	SELECT @countFinished = count(*)
	FROM Tasks T
	WHERE T.regular_employee = @username AND T.status = 1 AND T.deadline BETWEEN @start_date AND @end_date

	IF(@countFinished = @countAll) SET @result = 1
	ELSE SET @result = 0
	return @result

END
 
 GO
 

CREATE FUNCTION get_Department 
(@username varchar(20))
returns varchar(20)
AS
BEGIN
	DECLARE @dept varchar(20)	
	SELECT @dept = m.department
	FROM Staff_Members m
	WHERE m.username = @username
	return @dept
END

GO
CREATE FUNCTION get_Company
(@username varchar(20))
returns varchar(20)
AS
BEGIN
	DECLARE @comp varchar(20)	
	SELECT @comp = m.company
	FROM Staff_Members m
	WHERE m.username = @username
	return @comp
END


GO

CREATE TYPE questions AS TABLE (
    question varchar(20),
	answer bit,
	PRIMARY KEY(question,answer)
);



GO

-- EXTRA PROCEDURES

CREATE PROC currentStatusStaff
@username varchar(20), @company varchar(20) output,@department_name varchar(50) output, @job_string varchar(50) output, @department_code varchar(20) output
AS
BEGIN
	DECLARE @st1 varchar(50)
	SELECT @st1 = S.job FROM Staff_Members S WHERE S.username = @username
	DECLARE @role varchar(20)
	DECLARE @job varchar(50)
	SELECT @role = left(@st1, charindex('-', @st1) - 2)
	SELECT @job = SUBSTRING(@st1,CHARINDEX('-',@st1)+1,LEN(@st1))
	SELECT @job_string = @job + '(Your current role is : ' + @role + ')'
	SELECT @department_name = D.name,@department_code = D.code
	FROM Departments D
	WHERE D.code = dbo.get_Department(@username)
	SELECT @company = C.name
	FROM Companies C
	WHERE C.email = dbo.get_Company(@username)
END

GO

CREATE PROC viewAllMembersHR
@username varchar(20)
AS

BEGIN
	SELECT (ISNULL(U.first_name,'') + ' ' + ISNULL(U.middle_name,'') + ' ' + ISNULL(U.last_name,'') ) AS 'Name', S.company_email, S.job, S.day_off,U.username
	FROM Staff_Members S INNER JOIN Users U ON S.username = U.username
	WHERE S.company = dbo.get_Company(@username) AND S.department = dbo.get_Department(@username) AND NOT(@username=S.username)
END

GO

CREATE PROC sendMailAchiever
@username varchar(20),@achiever_username varchar(20), @year varchar(5), @month varchar(3)
AS
BEGIN
	DECLARE @full_name varchar(100);
	SELECT @full_name = (ISNULL(U.first_name,'') + ' ' + ISNULL(U.middle_name,'') + ' ' + ISNULL(U.last_name,'') )
	FROM Users U
	WHERE @achiever_username = U.username

	INSERT INTO Emails(date,subject,body)  VALUES(CURRENT_TIMESTAMP,'Congratulations!' ,
	'Congratulations '+@full_name +'.' + CHAR(10)+'You have been chosen as one of the top three highest achievers for the month of '+@month+'-'+@year+'.' +CHAR(10)+CHAR(10) + 'A high achiever is an Employee who stayed the longest hours in the company for a certain month and all tasks assigned to him/her with deadline within this month are fixed.'  )
	
	DECLARE @mailID int;
	SELECT @mailID = SCOPE_IDENTITY();

	INSERT INTO Emails_sent_by_Staff_Members_to_Staff_Members(email_number,recipient,sender) VALUES(@mailID,@achiever_username,@username);

END

GO

CREATE PROC addQuestionsJob
@username varchar(20), @job varchar(50),@question varchar(20), @answer bit
AS
BEGIN
	INSERT INTO Questions(question,answer) VALUES(@question,@answer);
	DECLARE @questionID int;
	SELECT @questionID = SCOPE_IDENTITY();
	INSERT INTO Jobs_have_Questions(company,department,job,question) VALUES(dbo.get_Company(@username),dbo.get_Department(@username),@job,@questionID);
END


GO

CREATE PROC addJobHR
@username varchar(20)=NULL , @title varchar(50)=NULL,
@short_description varchar(120) = '', @detailed_description varchar(3000) = '', @min_experience int = 0 , 
@salary Decimal(10,2)= 0, @deadline datetime = NULL, @no_of_vacancies int = 0, @working_hours int =0, @status varchar(20) output
AS
BEGIN	
	IF( EXISTS (SELECT * FROM Jobs WHERE title = @title AND company = dbo.get_Company(@username) AND department = dbo.get_Department(@username)) )
	BEGIN
		SET @status = 'Failed';
		RETURN;
	END
	INSERT INTO Jobs (title, department, company, short_description, detailed_description, 
	min_experience, salary, deadline, no_of_vacancies, working_hours) 
	VALUES (@title, dbo.get_Department(@username), dbo.get_Company(@username), @short_description, 
	@detailed_description, @min_experience, @salary, @deadline, 
	@no_of_vacancies, @working_hours)
	SET @status = 'Success';
END


GO

-- HR (1) : taking an HR member username as an input, and the appropriate Job attributes, it will create a new job in the HR's department
-- GOTTA MAKE SURE NOT DUPLICATED
CREATE PROC addJobHR_old
@username varchar(20)=NULL , @title varchar(50)=NULL,
@short_description varchar(120) = '', @detailed_description varchar(3000) = '', @min_experience int = 0 , 
@salary Decimal(10,2)= 0, @deadline datetime = NULL, @no_of_vacancies int = 0, @working_hours int =0, @questionsInput dbo.questions READONLY
AS
BEGIN
	IF (@username IS NOT NULL AND @title IS NOT NULL )

	BEGIN
		
		
		INSERT INTO Jobs (title, department, company, short_description, detailed_description, 
		min_experience, salary, deadline, no_of_vacancies, working_hours) 
		VALUES (@title, dbo.get_Department(@username), dbo.get_Company(@username), @short_description, 
		@detailed_description, @min_experience, @salary, @deadline, 
		@no_of_vacancies, @working_hours)

		DECLARE @qCount int;
		SELECT @qCount = count(*) FROM @questionsInput;
		DECLARE @i int = 0
		WHILE @i < @qCount 
		BEGIN
			SET @i = @i + 1;
			DECLARE @tempQ varchar(20);
			DECLARE @tempA bit;
			WITH myTableWithRows AS (
			SELECT (ROW_NUMBER() OVER (ORDER BY answer)) as row,*
			FROM @questionsInput)
			SELECT @tempQ = question, @tempA = answer FROM myTableWithRows WHERE row = @i 
			DECLARE @numberID int;
			INSERT INTO Questions(question,answer) VALUES (@tempQ,@tempA)
			SELECT @numberID = SCOPE_IDENTITY();
			INSERT INTO Jobs_have_Questions(company,department,job,question) VALUES (dbo.get_Company(@username), dbo.get_Department(@username), 
			@title, @numberID);
			
		END


	END
END
GO

-- HR (2) : shows information about a job given the title of it (does not show the company and the department since they're redundant as the HR will know for a fact his company and department)
CREATE PROC viewInformationJobHR
@username varchar(20),@title varchar(50)
AS
BEGIN
	IF( @username IS NOT NULL AND @title IS NOT NULL)
	SELECT J.title,J.short_description,J.detailed_description,J.salary,J.no_of_vacancies,J.min_experience,J.working_hours,J.deadline
	FROM Jobs J
	WHERE J.title = @title AND J.department =  dbo.get_Department(@username) AND J.company = dbo.get_Company(@username)
END

GO

CREATE PROC viewDeptJobs
@username varchar(20)
AS

BEGIN
	
	SELECT J.title,J.short_description,J.detailed_description,J.salary,J.no_of_vacancies,J.min_experience,J.working_hours,J.deadline
	FROM Jobs J
	WHERE J.department =  dbo.get_Department(@username) AND J.company = dbo.get_Company(@username)
END


GO

-- HR (3) : identifying a job by it's title (and dept/company fetched from the HR employee preforming the update), the procedure updates an existing job
CREATE PROC editJobHR
@username varchar(20)=NULL , @title varchar(50)=NULL,
@short_description varchar(120) = NULL, @detailed_description varchar(3000) = NULL, @min_experience int = NULL , 
@salary Decimal(10,2)= NULL, @deadline datetime= NULL, @no_of_vacancies int = NULL, @working_hours int = NULL
AS
BEGIN 
	IF(@username IS NOT NULL AND @title IS NOT NULL)
	BEGIN
		UPDATE Jobs 
		SET short_description = isNull(@short_description, short_description),
		detailed_description = isNull(@detailed_description,detailed_description), 
		min_experience = isNull(@min_experience,min_experience), 
		salary = isNull(@salary,salary), deadline = isNull(@deadline,deadline), 
		no_of_vacancies = isNull(@no_of_vacancies,no_of_vacancies) , working_hours = isNull(@working_hours,working_hours)
		WHERE department = dbo.get_Department(@username) AND company = dbo.get_Company(@username) AND title = @title 
	END
END


GO

-- HR (4) : viewing applications of a specific job in the department of the HR employee
CREATE PROC viewApplicationHR
@username varchar(20), @job varchar(50)
AS

BEGIN 
	SELECT U.username, U.first_name,U.middle_name,U.last_name, U.age,U.birth_date, U.years_of_experience, 
	J.* , APP.score
	FROM Jobs J INNER JOIN Jobs_Applied_by_Job_Seekers APP 
	ON J.title = APP.job AND J.department = APP.department	AND J.company = APP.company
	INNER JOIN Users U ON U.username = APP.job_seeker
	WHERE J.title = @job AND J.department = dbo.get_Department(@username) AND J.company = dbo.get_Company(@username) AND APP.hr_response IS NULL 


END

GO
-- HR (5) deciding on a certain application for a job in his department
CREATE PROC decideApplicationHR 
@username varchar(20), @job varchar(50), @job_seeker varchar(20), @hr_response bit
AS
	
BEGIN 
	UPDATE Jobs_Applied_by_Job_Seekers 
	SET hr_response =@hr_response
	WHERE job = @job AND job_seeker = @job_seeker AND company = dbo.get_Company(@username) AND department = dbo.get_Department(@username)
END

GO

-- HR (6) posting an announcment in his department by entering it's type and description, the date is set automatically to the date of the posting
CREATE PROC postAnnouncmentHR
@title varchar(50), @username varchar(20), @type varchar(10), @description varchar(120)
AS
BEGIN
	INSERT INTO Announcements(date,title,hr_employee,type,description)
	VALUES (CURRENT_TIMESTAMP,@title,@username,@type,@description) 
END

GO

-- HR (7) viewing the requests of all staff members (in his department) that were approved partially by the manager (taking the type as an extra input)
CREATE PROC viewRequestsHR
@username varchar(20), @type varchar(10)= NULL
AS
BEGIN
	IF(@type = 'Leave')
	BEGIN
		SELECT (ISNULL(U.first_name,'') + ' ' + ISNULL(U.middle_name,'') + ' ' + ISNULL(U.last_name,'') ) AS 'Name', R.request_date,R.start_date,R.end_date,R.total_days,L.type,U.username
		FROM Requests R INNER JOIN Leave_Requests L ON R.applicant = L.applicant AND R.start_date = L.start_date INNER JOIN Users U ON U.username = R.applicant
		WHERE U.username != @username AND hr_response IS NULL AND manager_response = 1 AND dbo.get_Department(@username) = (
				SELECT S.department
				FROM Staff_Members S
				WHERE S.username = R.applicant
			) 
			AND dbo.get_Company(@username) = (
				SELECT S.company
				FROM Staff_Members S
				WHERE S.username = R.applicant
			)
	END
	ELSE IF(@type = 'Business')
	BEGIN
		SELECT (ISNULL(U.first_name,'') + ' ' + ISNULL(U.middle_name,'') + ' ' + ISNULL(U.last_name,'') ) AS 'Name', R.request_date,R.start_date,R.end_date,R.total_days,B.destination,B.purpose,U.username
		FROM Requests R INNER JOIN Business_Trip_Requests B ON R.applicant = B.applicant AND R.start_date = B.start_date INNER JOIN Users U ON U.username = R.applicant
		WHERE U.username != @username AND hr_response IS NULL AND manager_response = 1 AND dbo.get_Department(@username) = (
				SELECT S.department
				FROM Staff_Members S
				WHERE S.username = R.applicant
			) 
			AND dbo.get_Company(@username) = (
				SELECT S.company
				FROM Staff_Members S
				WHERE S.username = R.applicant
			)
	END
END

GO 

-- HR (8) deciding on a request to finalize the decision, only seeing the request pre-approved by the manager

CREATE PROC finalizeReqHR
@username varchar(20), @hr_response bit, @start_date datetime, @applicant varchar(20)
AS
BEGIN
	IF(dbo.get_Company(@username)  = dbo.get_Company(@applicant) AND dbo.get_Department(@username) = dbo.get_Department(@applicant) )
	BEGIN
		DECLARE @days int;
		SELECT @days = R.total_days
		FROM Requests R
		WHERE R.manager_response = 1 AND R.applicant = @applicant AND R.start_date = @start_date

		UPDATE Requests
		SET hr_response = @hr_response
		WHERE manager_response = 1 AND applicant = @applicant AND start_date = @start_date
		
		IF(@hr_response = 1 AND EXISTS (SELECT * FROM Leave_Requests WHERE start_date = @start_date AND applicant = @applicant AND type = 'Annual leave') )
		BEGIN
			DECLARE @dayOff varchar(20);

			SELECT @dayOff = S.day_off
			FROM Staff_Members S
			WHERE S.username = @applicant

			DECLARE @dayCount int = 1;
			IF(DATENAME(dw,@start_date) = 'Friday' OR DATENAME(dw,@start_date) = @dayOff)
				SET @dayCount = 0;
			DECLARE @i int = 0;
			WHILE @i < @days 
			BEGIN
				
				SET @i = @i + 1;
				IF(DATENAME(dw, DATEADD(d,@i,@start_date)) = @dayOff OR DATENAME(dw, DATEADD(d,@i,@start_date)) = 'Friday')
					SET @dayCount = @dayCount - 1;
				SET @dayCount = @dayCount +1;
				
			END
			
			UPDATE Staff_Members
			SET annual_leaves = annual_leaves - @dayCount
			WHERE username = @applicant
		END
	END
END

GO

-- HR (9) viewing all attendance records during the duration passed (start&end date) of a certain employee working in the same department of the HR

CREATE PROC viewAttendanceHR
@username varchar(20), @staff varchar(20), @start_date datetime, @end_date datetime
AS
BEGIN
	SELECT A.date AS 'Day', CAST( (CAST(A.start_time AS time(0))) AS varchar(10) ) AS 'Check-in time', CAST( (CAST(A.end_time AS time(0))) AS varchar(10) ) AS 'Check-out time', 
	DATEDIFF(hh, A.start_time, A.end_time) AS 'Duration', 
	  CASE 
         WHEN (J.working_hours -  DATEDIFF(hh, A.start_time, A.end_time)) > 0 THEN J.working_hours -  DATEDIFF(hh, A.start_time, A.end_time)
         ELSE 0
      END
	AS 'Missed Hours'
	FROM Attendance_Records A INNER JOIN Staff_Members S ON A.staff = S.username 
	INNER JOIN Jobs J ON J.title = S.job AND J.company = S.company AND J.department = S.department
	WHERE S.username = @staff AND S.company = dbo.get_Company(@username) AND S.department = dbo.get_Department(@username)
	AND A.date BETWEEN @start_date AND @end_date

END


GO

-- HR (10) allows an HR member to view the total duration (in hours) a certain staff member in his department has stayed in a specific month (month and a year are passed as parametetrs)
CREATE PROC viewTotalHoursHR 
@username varchar(20), @staff varchar(20), @year varchar(5), @month varchar(3)
AS
BEGIN

	DECLARE @start_date varchar(30);
	DECLARE @end_date varchar(30);
	DECLARE @monthDays varchar(3);
	IF(@month in (4,6,9,11)) SET @monthDays = 30;
	ELSE IF(@month = 2) SET @monthDays = 28;
	ELSE SET @monthDays = 31;
	SET @start_date = @year + '-' + @month + '-01';
	SET @end_date = @year + '-' + @month + '-' +@monthDays;
	
	SELECT sum(Duration)
	FROM ( 
	SELECT DATEDIFF(hh, A.start_time, A.end_time) AS 'Duration'
	FROM Attendance_Records A INNER JOIN Staff_Members S ON A.staff = S.username 
	WHERE  S.username = @staff AND  S.company = dbo.get_Company(@username) AND S.department = dbo.get_Department(@username)
	AND A.date BETWEEN @start_date AND @end_date
	)a

		
END

GO

-- HR(11) views the top 3 employees in the department of the HR in a specific month (provided by the month and year), the top 3 are chosen by the longest duration spent
-- in the company (retrieved from their attendance records) and they have to have fullfilled all the tasks assigned to them with a deadline within the provided month

CREATE PROC viewHighestAchiever 
@username varchar(20),  @year varchar(5), @month varchar(3)
AS
BEGIN
	DECLARE @start_date varchar(30);
	DECLARE @end_date varchar(30);
	DECLARE @monthDays varchar(3);
	IF(@month in (4,6,9,11)) SET @monthDays = 30;
	ELSE IF(@month = 2) SET @monthDays = 28;
	ELSE SET @monthDays = 31;
	SET @start_date = @year + '-' + @month + '-01';
	SET @end_date = @year + '-' + @month + '-' +@monthDays;
	
	SELECT TOP 3 Name,Username, sum(Duration) AS 'HoursAttended'
	FROM ( 
	SELECT (ISNULL(U.first_name,'') + ' ' + ISNULL(U.middle_name,'') + ' ' + ISNULL(U.last_name,'') ) AS 'Name',U.username AS 'Username', DATEDIFF(hh, A.start_time, A.end_time) AS 'Duration'
	FROM Attendance_Records A INNER JOIN Staff_Members S ON A.staff = S.username INNER JOIN Users U ON S.username = U.username INNER JOIN Regular_Employees R ON R.username = S.username
	WHERE S.company = dbo.get_Company(@username) AND S.department = dbo.get_Department(@username)
	AND A.date BETWEEN @start_date AND @end_date
	)a
	WHERE dbo.check_AllTasksPerMonth(Username,@year,@month) = 1
	GROUP BY Username,a.Name
	ORDER BY HoursAttended DESC
END

----------------------------------------------------------------------------------------------- USERS

--USERS :
GO


--Users -- number 1
go

create proc Search_Company_By_Name
@name varchar(20)
as
select *
from Companies where name = @name



go


create proc Search_Company_By_Type
@type varchar(20)
as
select *
from Companies where type = @type

go

create proc Search_Company_By_Address
@address varchar(20)
as
select *
from Companies where address = @address

--Users - number 2
go

create proc View_All_Companies
as
select *
from Companies

go

--Users - number 3

create proc Departements_in_company
@email VARCHAR(50)
as
select C.*, D.*
from Departments D
	inner join Companies C on C.email = D.company
	where C.email = @email

go

create proc Departements_in_company_by_Name
@name VARCHAR(20)
as
select D.* , C.*
from Departments D
	inner join Companies C on C.email = D.company
	where C.name = @name

--Users - number  4
----------------------------------------------------->
go 

create proc View_All_Vacancies
@email VARCHAR(50) , @department_code VARCHAR(20)
as
select *
from Departments D 
	 inner join Jobs J on J.department = D.code AND D.company = J.company
	 where J.no_of_vacancies > 0 AND @email = D.company AND @department_code = D.code

--Users - number 5
go

CREATE proc Register1
@name Varchar(20), @pass Varchar(20) ,@p_email VARCHAR(50) ,@bd date ,
@exp int ,@f_name VARCHAR(20) ,@m_name VARCHAR(20) ,@l_name VARCHAR(20), @output varchar(max) = 'reg'  output
AS
BEGIN

if(exists (select * from Users where username = @name))
BEGIN
      SET @output = 'Registeration failed, the username is used. Please choose another username and try again';
	  RETURN;
END
ELSE
BEGIN
SET @output = 'Registeration successful';
insert into Users VALUES (@name , @pass , @p_email , @bd , @exp , @f_name , @m_name ,@l_name );
INSERT INTO Job_Seekers VALUES (@name);

END
END

--Users - number 6

go
create proc search_jobs1
@S VARCHAR(20) 
as 
select j.title,j.short_description,j.detailed_description,j.no_of_vacancies,j.salary,j.min_experience,j.deadline,j.working_hours , C.name AS 'Company', D.name AS 'Department'
from Jobs J
     inner join Departments D on j.department =  D.code
	 inner join Companies C on j.company = C.email
	where j.no_of_vacancies > 0 and j.short_description like '%' + @S +'%' or j.title like '%' + @S + '%'

	go

	--Users - number 7

	
	go

CREATE proc Having_Highest_Salary
as
select C.name,C.email,AVG(j.salary) AS 'avg'
from Companies C
      inner join Jobs j on j.company = C.email 
	  group by C.email,C.name
	  order by AVG(j.salary) desc


go

     -- Function used
create Function check1(@user VARCHAR(20) , @user2 VARCHAR(20))
returns bit
as
begin
declare @A bit

If (exists (select U.* from Users U where @user = U.username ) and exists (select U.* from Users U where @user2 = U.username ))

begin

if (exists (select S.username from Managers S where @user = S.username) and exists (select S.username from Managers S where @user2 = S.username))
set @A = 1
else
begin

if (exists (select * from Regular_Employees S where @user = S.username ) and exists (select * from Regular_Employees S where @user2 = S.username ))
set @A = 1
else
begin

if (exists (select * from HR_Employees H where @user = H.username) and exists (select * from HR_Employees H where @user2 = H.username))
set @A = 1
else
set @A = 0
end
end
end

else
set @A = 0

return @A
end

go



go

-- Users number (8)
CREATE PROC login
@user VARCHAR(20) , @pass VARCHAR(20), @output varchar(max) output
AS

IF ( EXISTS(select * from Users U where @user = U.username) )
BEGIN
	IF(EXISTS (SELECT * FROM USERS U WHERE @user = U.username AND @pass = U.password) )
	BEGIN
		if exists (select S.username from Managers S where @user = S.username)
			SET @output = 'Manager'
		if exists (select * from Regular_Employees S where @user = S.username )
			SET @output = 'Regular'
		if exists (select * from HR_Employees H where @user = H.username)
			SET @output = 'HR'
		if exists (select * from Job_Seekers H where @user = H.username)
			SET @output = 'Seeker'
	END
	ELSE 
		SET @output = 'Password incorrect';
END

ELSE
	SET @output = 'Not registered'; 



GO

-- Another function
create function type_Of_person(@user VARCHAR(20) )
returns varchar(20)
as
begin
declare @d varchar(20)

if exists (select S.username from Managers S where S.username = @user)
set @d = 'Manager'
else
begin
if exists (select S.username from Regular_Employees S where @user = S.username )
set @d = 'Regular'
else
set @d = 'Human Resources'
end
return @d
end




go 



--Users - Number  (9)
go

CREATE proc View_all
@user varchar(20)
as
declare @d varchar(20) = dbo.type_Of_person(@user)
if(@d = 'Manager')
begin
select *
from Users U 
     inner join Staff_Members S on U.username = S.username
	 inner join Managers M on M.username = S.username
	 where U.username = @user
end
else
begin
if(exists(select job_seeker from Jobs_Applied_by_Job_Seekers where job_seeker = @user))
begin
select * from Users U inner join Jobs_Applied_by_Job_Seekers J on U.username = J.job_seeker where U.username = @user
end
else if(exists (select * FROM Job_Seekers WHERE username = @user) )
SELECT * FROM Users WHERE username = @user
else
select * from Users U inner join Staff_Members S on U.username = S.username where U.username = @user

end

go
go
 
 --Users - number  (10)
create proc Edit_personal_information 
@name Varchar(20), @pass Varchar(20) ,@p_email VARCHAR(50) ,@bd date ,
@exp int ,@f_name VARCHAR(20) ,@m_name VARCHAR(20) ,@l_name VARCHAR(20)
as
update Users
set  password = @pass , personal_email =@p_email ,birth_date= @bd  ,
years_of_experience = @exp ,first_name = @f_name ,middle_name = @m_name , last_name = @l_name where username = @name

GO 

CREATE PROC addPreviousJob
@username varchar(20), @job varchar(50)
AS
BEGIN
	INSERT INTO User_Jobs(job,username) VALUES (@job,@username);
END
	


-----------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------ YASSIN
-- JOB SEEKERS



-- job seekers

-- US 1

-- edited
GO
create proc Apply_Job 
@username varchar(20), @title varchar(50), @department varchar(20), @company varchar(50), @output varchar(max) output
as
if(exists (select * from Job_Seekers where @username = username))
begin 
declare @exp_years int
declare @required int


select @exp_years = years_of_experience
from Users
where @username = username

select @required = min_experience
from Jobs
where @title = title and @department = department and @company = company

if(not exists (select * from Jobs_Applied_by_Job_Seekers where @username = job_seeker and @title = job and 
@department = department and @company = company ))
if(@exp_years >= @required)
begin
insert into Jobs_Applied_by_Job_Seekers values (@title, @department, @company, @username, null, null, 0) 
set @output = 'Succesfully Applied for job!' 
end
else set @output = 'Minimum experience years is not met!'
else set @output = 'You already applied to this job!'
end
else set @output =  'Unregistered User!'
go

--

-- US 2
create proc View_Questions 
@username varchar(20),@job varchar(50), @department varchar(20), @company varchar(50)
as 
if(exists (select * from Job_Seekers where @username = username))
begin
select q.number, q.question
from Jobs_Applied_by_Job_Seekers app INNER JOIN Jobs_have_Questions jq ON app.company = jq.company AND app.department = jq.department AND app.job = jq.job
INNER JOIN Questions q ON q.number = jq.question
where app.job_seeker = @username and app.company = @company and app.department = @department and app.job = @job

end
go

-- US 3
create proc Save_Score
@username varchar(20), @title varchar(50), @department varchar(20), @company varchar(50), @question int, @answer bit
as
if(exists (select * from Job_Seekers where @username = username))
begin
if(exists(select * from Questions where @question = number and @answer = answer))
update Jobs_Applied_by_Job_Seekers
set score = score + 1
where @username = job_seeker and @title = job and @department = department and @company = company
end
go

-- US 4
create proc View_Status 
@username varchar(20)
as
if(exists (select * from Job_Seekers where @username = username))
begin
select job, department, company, hr_response, manager_response, score
from Jobs_Applied_by_Job_Seekers
where @username = job_seeker
end
go

-- US 5
create proc Choose_Job
@username varchar(20), @job varchar(50), @department varchar(20), @company varchar(50), @dayoff varchar(10), 
@output varchar(max) output
as 
if(exists (select * from Job_Seekers where @username = username))
begin
declare @domain varchar(20)
select @domain = domain 
from Companies
where @company = email

declare @salary Decimal(10,2)

select @salary = salary
from Jobs
where @job = title and @department = department and @company = company
if(exists (select * from Jobs_Applied_by_Job_Seekers where @job = job and @department = department and @company = company and @username = job_seeker and 
manager_response = 1))
if(not (@dayoff = 'Friday'))
begin
	insert into Staff_Members values (@username, 30, @username + '@' + @domain, @dayoff, @salary, @job, @department, @company)

	if(exists(select* from Jobs where @job = title and @department = department and @company = company and @job like 'Manager -%'))
	begin 
	declare @dep_name varchar(20)
	select @dep_name = d.name from Departments d, Jobs j where @job = j.title and @department = j.department and @company = j.company and j.department = 
	d.code and j.company = d.company
	insert into Managers values (@username, @dep_name)
	set @output = 'Manager'
	end

	else if(exists(select* from Jobs where @job = title and @department = department and @company = company and @job like 'Regular Employee -%'))
	begin
	insert into Regular_Employees values (@username)
	set @output = 'Regular'
	end

	else 
	begin
	insert into HR_Employees values (@username)
	set @output = 'HR'
	end
	
	delete from Job_Seekers
	where @username = username

	update Jobs
	set no_of_vacancies = no_of_vacancies - 1
	where @job = title and @department = department and @company = company
end
else
	set @output = 'Invalid Dayoff'
else
	set @output = 'Job Application Not Accepted!'
end
go 

-- US 6
create proc Delete_Application
@username varchar(20), @job varchar(50), @department varchar(20), @company varchar(50),
@output varchar(max) output
as
if(exists (select * from Job_Seekers where @username = username))
begin
if(exists (select * from  Jobs_Applied_by_Job_Seekers where @username = job_seeker and @job = job and @department = department and @company = company 
and (hr_response is null or hr_response = 1) and manager_response is null))
begin
delete from Jobs_Applied_by_Job_Seekers
where @username = job_seeker and @job = job and @department = department and @company = company
set @output = 'Succesfully deleted!'
end
else
set @output = 'Cannot Delete Non Pending Application'
end
go


--------------------------------------------------------------------------------------------------------------
-- regular employee

-- US 1
create proc View_Projects
@username varchar(20)
as
if(exists (select * from Regular_Employees where @username = username))
begin
select P.*
from Managers_assign_Regular_Employees_Projects M, Projects P
where @username = M.regular_employee and M.project_name = P.name and M.company = P.company 
end
go

-- US 2
create proc View_Task
@username varchar(20), @project varchar(20), @company varchar(50)
as 
if(exists (select * from Regular_Employees where @username = username))
begin
select *
from Tasks
where @username = regular_employee and @project = project and @company = company
end
go

--edited

create proc View_Task_Comments
@username varchar(20), @name varchar(20), @project varchar(20), @company varchar(50)
as
if(exists ( select * from Task_Comments where @name = task_name and @project = project and @company = company))
begin
select * from Task_Comments where @name = task_name and @project = project and @company = company
end
go
--
-- US 3
create proc Change_Status
@username varchar(20), @name varchar(20), @project varchar(20), @company varchar(50),
@output varchar(max) output
as
if(exists (select * from Regular_Employees where @username = username))
begin
declare @deadline datetime
select @deadline = deadline
from Tasks 
where @name = name and @project = project and @company = company
if(@deadline > CURRENT_TIMESTAMP)begin
update Tasks
set status = 'Fixed'
where @name = name and @project = project and @company = company
set @output = 'Succesful'
end
else
set @output = 'Cannot change status of overdue task'
end
go

-- US 4
create proc Rechange_Status
@username varchar(20), @name varchar(20), @project varchar(20), @company varchar(50),
@output varchar(max) output
as
if(exists (select * from Regular_Employees where @username = username))
begin
declare @deadline datetime
declare @status varchar(10)
select @deadline = deadline, @status = status
from Tasks
where @username = regular_employee and @name = name and @project = project and @company = company
if(@deadline > CURRENT_TIMESTAMP and @status = 'Fixed') begin
update Tasks
set status = 'Assigned'
where @username = regular_employee and @name = name and @project = project and @company = company
set @output = 'Succesful'
end
else 
set @output = 'Cannot change status of overdue task'
end
go

------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------
------------------------------------------------------------------------------------------------------------------


-- HANY

-- STAFF MEMBER


-- Number 1

create proc check_in
@user VARCHAR(20) , @output varchar(max) output
as
if(exists(select day_off from Staff_Members where username = @user and day_off = DATENAME(weekday,GETDATE())))
set @output = 'It is a day off'
else
begin
if(exists(select R.date from Attendance_Records R where R.staff = @user and R.date = CURRENT_TIMESTAMP))
set @output = 'You alreeady checked in'
else
begin
insert into Attendance_Records Values (CURRENT_TIMESTAMP , @user , CURRENT_TIMESTAMP , null)
set @output = 'Attendance has been entered'
end
end
go 

-- number 2
go

create proc check_out
@user VARCHAR(20) ,@output varchar(max) output
as
if(exists(select day_off from Staff_Members where username = @user and day_off = DATENAME(weekday,GETDATE())))
set @output = 'It is a day off'
else
begin
update Attendance_Records
set end_time = CURRENT_TIMESTAMP where staff = @user and date = CONVERT(CHAR(10), CURRENT_TIMESTAMP, 120)
set @output = 'Check out Successfully'
end

go

--Function used

create function return_hours(
@username varchar(20))
returns int
as
begin
declare @RH int
select @RH = j.working_hours 
from Staff_Members s
inner join Jobs j on s.job = j.title and s.department = j.department and s.company = j.company 
where s.username  = @username 
return @RH
end
go


 --Staff Member 3
go
create proc View_My_Attendance 
@username varchar(20) , @start date ,@end date
AS
begin
select R.date , R.start_time , R.end_time , DATEDIFF(hour,R.start_time,R.end_time) AS duration ,

CASE
         WHEN (J.working_hours -  DATEDIFF(hh, R.start_time, R.end_time)) > 0 THEN J.working_hours -  DATEDIFF(hh, R.start_time, R.end_time)
         ELSE 0
      END
    AS 'Missing Hours'
from Attendance_Records R INNER JOIN Staff_Members S ON R.staff = S.username
INNER JOIN Jobs J ON J.title = S.job AND J.company = S.company AND J.department = S.department
 WHERE S.username = @username AND S.company = dbo.get_Company(@username) AND S.department = dbo.get_Department(@username)
    AND R.date BETWEEN @start AND @end
end





go 

go
--staff 4
-- one for leave


go


go
create proc Leave_Request_for_all
@start date , @applicant varchar(20) ,@replacement varchar(20), @end_date date ,
@type varchar(20) , @output varchar(max)output

as
begin
declare @A Varchar(60)
declare @remaining_leaves int
declare @B bit 
declare @T varchar(20)
set @B = dbo.check1(@applicant , @replacement)
set @T = dbo.type_Of_person(@applicant)
select @remaining_leaves = annual_leaves from Staff_Members where username = @applicant

if(@remaining_leaves = 0)
begin
set @output = 'You used all the allowed annual leaves'

end

if((exists(select applicant from Requests where @start < end_date and @start > start_date and applicant = @applicant)))
begin
set @output = 'It is a conflicting date'
end

if(@B = 0)
begin
set @output = 'ur replacement is not of the same type'
end

if(@B = 1)
begin
if(@T = 'Manager')
begin

set @output = 'Manager request applied'
insert into Requests values (@start ,@applicant, @end_date , CURRENT_TIMESTAMP, 1 ,1, null,NULL , NULL)
insert into Leave_Requests values (@start , @applicant , @type)
insert into Managers_apply_replace_Requests values (@start , @applicant, @applicant , @replacement)
end
if(@T = 'Human Resources')
begin
--print('H')
set @output = 'Request sent'
insert into Requests values (@start ,@applicant, @end_date , CURRENT_TIMESTAMP, null ,
null, null,null, null)
insert into Leave_Requests values (@start , @applicant , @type)
insert into HR_Employees_apply_replace_Requests values (@start , @applicant, @applicant , @replacement)
end
if(@T = 'Regular')
begin
set @output = 'Request sent'
insert into Requests values (@start ,@applicant, @end_date , CURRENT_TIMESTAMP, null ,
null, null,null, null)
insert into Leave_Requests values (@start , @applicant , @type)
insert into Regular_Employees_apply_replace_Requests values (@start , @applicant, @applicant , @replacement)
end
end
end



go

-- one for trip
go
create proc trip_for_all
(@start date , @applicant varchar(20) ,@replacement varchar(20), @end_date date ,
@destination varchar(20) , @purpose varchar(20) ,@output varchar(max) output )

as
begin
declare @A Varchar(60)
declare @remaining_leaves int
declare @B bit 
declare @T varchar(20)
set @B = dbo.check1(@applicant , @replacement)
set @T = dbo.type_Of_person(@applicant)
select @remaining_leaves = annual_leaves from Staff_Members where username = @applicant

if(@remaining_leaves = 0)
begin
set @output = 'You used all the allowed annual leaves'

end

if((exists(select applicant from Requests where @start < end_date and @start > start_date and applicant = @applicant)))
begin
set @output = 'It is a conflicting date'
end

if(@B = 0)
begin
set @output = 'ur replacement is not of the same type'
end

if(@B = 1)
begin
if(@T = 'Manager')
begin
--print('M')
insert into Requests values (@start ,@applicant, @end_date , CURRENT_TIMESTAMP, 1 ,1, null,NULL , NULL)
insert into Business_Trip_Requests values (@start , @applicant , @destination ,@purpose )
insert into Managers_apply_replace_Requests values (@start , @applicant, @applicant , @replacement)
set @A = 'Manager request applied'
end
if(@T = 'Human Resources')
begin
--print('H')
insert into Requests values (@start ,@applicant, @end_date , CURRENT_TIMESTAMP, null ,
null, null,null, null)
insert into Business_Trip_Requests values (@start , @applicant , @destination ,@purpose )
insert into HR_Employees_apply_replace_Requests values (@start , @applicant, @applicant , @replacement)
set @A = 'Request sent'
end
if(@T = 'Regular')
begin
insert into Requests values (@start ,@applicant, @end_date , CURRENT_TIMESTAMP, null ,
null, null,null, null)
insert into Business_Trip_Requests values (@start , @applicant , @destination ,@purpose )
insert into Regular_Employees_apply_replace_Requests values (@start , @applicant, @applicant , @replacement)
set @A = 'Request sent'
end
end

--print(@A)
end

go

--staff 5

go

go

create proc view_request_status 
@username varchar(20)
as
select start_date, hr_response, manager_response
from Requests
where @username = applicant
go


--staff 6



create proc delete_request 
@username varchar(20), @start_date date , @output varchar(100) output
as
if(exists (select * from Requests where @username = applicant and @start_date = start_date and hr_response is null))
begin
delete from Requests
where  @username = applicant and @start_date = start_date
set @output = 'Done Deleting'
end
else
set @output = 'Cannot Delete !!'
go


 
 --staff 7


 go

create proc send_email
@sender varchar(20), @recipient_email varchar(50), @subject varchar(20), @body varchar(500) , @output varchar(100) output
as
if(exists (select * from Staff_Members where @recipient_email = company_email))
begin
declare @recipient varchar(50)
select @recipient = username
from Staff_Members
where @recipient_email = company_email

insert into Emails values( @subject, CURRENT_TIMESTAMP, @body)
declare @serial_number int
select @serial_number = MAX(serial_number)
from Emails
insert into Emails_sent_by_Staff_Members_to_Staff_Members values ( @serial_number, @recipient, @sender)
set @output = 'Email sent'
end
else
set @output = 'Cannot send Emails to non Staff Members!'
go


--staff 8

--insert into Emails values ('aa',CURRENT_TIMESTAMP,'aa')
--insert into Emails_sent_by_Staff_Members_to_Staff_Members values (1,'lama.tag','yassin.chaddad')
--exec view_emails 'lama.tag'

go

create proc view_emails
@username varchar(20)
as
select ES.email_number as ID,Es.sender, E.subject, E.body, E.date
from Emails E, Emails_sent_by_Staff_Members_to_Staff_Members Es 
where Es.sender in (select username from Staff_Members) and E.serial_number = Es.email_number and @username = Es.recipient
go


--staff 9


create proc reply_email
@serial_number int, @username varchar(20), @body varchar(500) ,@output varchar(max) output
as
declare @recipient varchar(20)
declare @subject varchar(50)
select @recipient = Es.sender, @subject = E.subject
from Emails E, Emails_sent_by_Staff_Members_to_Staff_Members Es
where E.serial_number = Es.email_number and @username = Es.recipient and @serial_number = E.serial_number
insert into Emails values( 'R:' + @subject, CURRENT_TIMESTAMP, @body)
declare @serial_numberN int
select @serial_numberN = MAX(serial_number)
from Emails
insert into Emails_sent_by_Staff_Members_to_Staff_Members values ( @serial_numberN, @recipient,@username)
set @output = 'Email sent'

go

--staff 10


--insert into Announcements values (CURRENT_TIMESTAMP , 'aa','yassin.chaddad','agjkagkasf','jkgfajkaf')

go 

create proc view_announcements
@username varchar(20)
as
select A.title, A.date, A.type, A.description
from Announcements A, Staff_Members M, Staff_Members M1
where A.hr_employee = M.username and M1.username = @username and M1.company = M.company and   DATEDiff(day,A.date,GETDATE())< 20
go


----------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------
--MANAGER 
-------------------------------------------------------------------------------------------------------------------------

--1)
create proc view_leave_requests
@user varchar(20)
as
declare @type varchar(10)
select @type= type from Managers where username = @user
if(@type ='HR')
select r.applicant,r.start_date,r.total_days,r.end_date,r.request_date, l.start_date,l.type
from Requests r inner join Staff_Members s1 on r.applicant = s1.username 
				inner join Staff_Members s2 on s1.department = s2.department
				inner join Leave_Requests l on l.applicant=r.applicant and l.start_date = r.start_date
where s2.username=@user AND  r.manager_response is null
else
select r.applicant,r.start_date,r.total_days,r.end_date,r.request_date, l.start_date,l.type
from Requests r inner join Staff_Members s1 on r.applicant = s1.username 
				inner join Staff_Members s2 on s1.department = s2.department
				inner join Leave_Requests l on l.applicant=r.applicant and l.start_date = r.start_date
where s2.username=@user AND  r.manager_response is null and not exists(select * from HR_Employees h where h.username = r.applicant)



go

create proc view_buisness_requests
@user varchar(20)
as
declare @type varchar(10)
select @type= type from Managers where username = @user
if(@type ='HR')
select r.applicant,r.start_date,r.total_days,r.end_date,r.request_date, b.destination,b.purpose,b.start_date
from Requests r inner join Staff_Members s1 on r.applicant = s1.username 
				inner join Staff_Members s2 on s1.department = s2.department
				inner join Business_Trip_Requests b on b.applicant = r.applicant and b.start_date = r. start_date
where s2.username=@user AND  r.manager_response is null
else
select r.applicant,r.start_date,r.total_days,r.end_date,r.request_date, b.destination,b.purpose,b.start_date
from Requests r inner join Staff_Members s1 on r.applicant = s1.username 
				inner join Staff_Members s2 on s1.department = s2.department
				inner join Business_Trip_Requests b on b.applicant = r.applicant and b.start_date = r. start_date
where s2.username=@user AND  r.manager_response is null and not exists(select * from HR_Employees h where h.username = r.applicant)




-------------------------------------------------------------------------------------------------------------------------

go

--2)

create proc respond_to_requests
@manager varchar(20),@applicant varchar(20),@start datetime,@response bit, @reason varchar(20 ) = null
as
declare @type varchar(10)
select @type= type from Managers where username = @manager
declare @empType varchar(10)
if(exists (select * from HR_Employees h where h.username = @applicant ))
set @empType = 'HR'
else 
set @empType = 'Reg'
if(@type = 'HR')begin 
	if(@empType ='HR')begin
		if(@response = 0)
			update Requests
			set hr_response = 0, manager_response =0, manager= @manager , manager_reason = @reason
			where applicant = @applicant and start_date = @start
		else
			update Requests
			set hr_response = 1, manager_response =1, manager= @manager 
			where applicant = @applicant and start_date = @start
		end
	end
else begin 
		if(@response = 0)
			update Requests
			set  manager_response =0, manager= @manager , manager_reason = @reason
			where applicant = @applicant and start_date = @start
		else
			update Requests
			set  manager_response =1, manager= @manager 
			where applicant = @applicant and start_date = @start end



-------------------------------------------------------------------------------------------------------------------------
go


--3)

create proc view_applications
@job varchar(50), @username varchar(20)
as
declare @depart varchar(20)
select @depart= department from Staff_Members where username = @username
declare @company VARCHAR (50)
select @company = company from Staff_Members s where s.username = @username
select j.title,j.short_description,j.min_experience,j.no_of_vacancies,j.salary,j.deadline  ,u.first_name,u.middle_name,j.department,j.company,
		u.last_name,u.years_of_experience,u.age,u.personal_email,u.username
from Jobs j inner join Jobs_Applied_by_Job_Seekers a on j.title = a.job and j.company=a.company and j.department=a.department
	inner join Job_Seekers s on a.job_seeker = s.username
	inner join Users u  on s.username = u.username
where j.department = @depart and a.hr_response =1 and a.manager_response is null and j.company=@company

-------------------------------------------------------------------------------------------------------------------------
go

--4)

create proc acceptReject_application
@job varchar(50), @department varchar(20), @company varchar(50),@job_seeker varchar(20),@response bit
as
update Jobs_Applied_by_Job_Seekers 
set manager_response = @response
where job = @job and department = @department and company = @company and  job_seeker = @job_seeker and hr_response =1

-------------------------------------------------------------------------------------------------------------------------
go


--5)

create proc create_project
@name VARCHAR (20) , @start_date DATETIME ,
@end_date DATETIME , @manager VARCHAR (20) 
as
declare @company VARCHAR (50)
select @company = company from Staff_Members s where s.username = @manager
insert into Projects values (@name, @company,@start_date,@end_date,@manager)

-------------------------------------------------------------------------------------------------------------------------

go 



--6)

create proc assign
@manager varchar(20), @project varchar(20) ,@employee varchar(20), @output varchar(100) OUTPUT
as
set @output =''
if(exists (select * from Regular_Employees where username= @employee))begin

declare @compemp varchar(50)
select @compemp = company from Staff_Members s where s.username = @employee

declare @demp varchar(20)
select @demp = department from Staff_Members where username = @employee

declare @dman varchar(20)
select @dman = department from Staff_Members where username = @manager

declare @company varchar(50)
select @company = company from Staff_Members s where s.username = @manager

declare @man varchar(20) 
select @man = manager from projects where name = @project

declare @count int 
set @count =0
select @count = count(regular_employee)
from Managers_assign_Regular_Employees_Projects
where regular_employee=@employee and company= @company
group by regular_employee


if((@dman = @demp or @manager = @man) and @count <2 and @company = @compemp)begin
insert into Managers_assign_Regular_Employees_Projects values(@project,@company,@employee,@manager)
set @output = @employee + ' was assigned to project ' + @project +' succesfully'
end
else
set @output='Employee is assigned in more than 2 projets or not in your department' 
end
else
set @output='No Regular Employee with this name'



-------------------------------------------------------------------------------------------------------------------------

go

--7)

create proc unassign_project 
@manager varchar(20), @project varchar(20) ,@employee varchar(20), @output varchar(100) OUTPUT
as
if(not exists(select * from Tasks where regular_employee= @employee)) begin
delete from Managers_assign_Regular_Employees_Projects where regular_employee=@employee and project_name=@project
set @output ='Done'
end
else
set @output ='error'



-------------------------------------------------------------------------------------------------------------------------

go

--8)

create proc create_Task
@manager varchar(20),@project varchar(20),@task_name varchar(20), @description varchar(120) = ''
as
declare @company varchar(50)
select @company = company from Staff_Members where username = @manager
insert into Tasks (name,project, company, status, description, manager )
values (@task_name,@project,@company,'Open',@description,@manager)

-------------------------------------------------------------------------------------------------------------------------

go


--9)

create proc assign_Task
@manager varchar(20),@employee varchar(20),@task varchar(20), @project varchar(20),@deadline datetime ,@output varchar(100) OUTPUT
as
declare @company varchar(50)
select @company = company from Staff_Members where username = @manager
declare @man varchar(20)
select @man = t.manager from Tasks t where t.name =@task and t.project = @project and t.company=@company
if( exists (select * from Managers_assign_Regular_Employees_Projects a where a.regular_employee=@employee ) and
	@manager = @man)
begin
set @output = 'Assigned'
update Tasks 
set status='Assigned' , regular_employee=@employee, deadline = @deadline
where name =@task and project = @project and company=@company
end
else
begin
set @output = 'Employee not assigned to the project'
end



-------------------------------------------------------------------------------------------------------------------------

go


--10)

create proc change_Task_Employee
@manager varchar(20),@employee varchar(20),@task varchar(20), @project varchar(20), @deadline datetime = null ,@output varchar(100) OUTPUT
as
declare @company varchar(50)
select @company = company from Staff_Members where username = @manager

declare @man varchar(20)
select @man = t.manager from Tasks t where t.name =@task and t.project = @project and t.company=@company
declare @status varchar(10)
select @status= status from Tasks t where t.name =@task and t.project = @project and t.company=@company

if( (exists (select * from Managers_assign_Regular_Employees_Projects a where a.regular_employee=@employee and a.project_name= @project)) and
	@manager = @man  and @status='Assigned' )begin
set @output = 'Changed Assigned Employee'
update Tasks 
set regular_employee=@employee, deadline = @deadline
where name =@task and project = @project and company=@company
end
else begin
set @output = 'Employee not assigned to the project' end




-------------------------------------------------------------------------------------------------------------------------

go

--11)

create proc view_tasks 
@manager varchar(20), @project varchar(20),@status varchar(10)
as
declare @company varchar(50)

select @company = company from Staff_Members where username = @manager

select * 
from Tasks t
where t.company= @company and t.project=@project and t.status=@status

-------------------------------------------------------------------------------------------------------------------------

go

--12)

create proc review_task
@manager varchar(20), @project varchar(20), @task varchar(20), @response bit, @deadline datetime = null
as
declare @company varchar(50)
select @company = company from Staff_Members where username = @manager
if(@response = 1)
update Tasks
set status = 'Closed'
where name = @task and project = @project and company= @company and status = 'Fixed'
else
update Tasks
set status = 'Assigned', deadline = @deadline
where name = @task and project = @project and company= @company and status = 'Fixed'