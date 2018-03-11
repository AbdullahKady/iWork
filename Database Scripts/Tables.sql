GO
USE master;
GO
CREATE DATABASE iWork;
GO
USE iWork;
GO
create table Companies(
email varchar(50) primary key,
name varchar(20), 
address varchar(100),
domain varchar(20),
type varchar(20),
vision varchar(20),
specialization varchar(20)
);

create table Company_Phones(
phone VARCHAR(20), --VARCHAR because it can start by +20 for example 
company varchar(50) references Companies on delete CASCADE on update cascade,
primary key (phone, company)
);

create table Departments(
code varchar(20),
company varchar(50) references Companies on delete cascade on update cascade,
name varchar(50),
primary key (code, company)
);

create table Jobs(
title varchar(50),
department varchar(20),
company varchar(50),
short_description varchar(120),
detailed_description varchar(3000),
min_experience int,
salary Decimal(10,2),
deadline datetime, --not so sure wether it should be not null or no
no_of_vacancies int,
working_hours int,
foreign key (department, company) references Departments (code, company) ON DELETE CASCADE ON UPDATE CASCADE,
primary key (title, department, company)
);

create table Questions(
number int identity primary key,
question varchar(20),
answer bit
);

create table Jobs_have_Questions(
job varchar(50),
department varchar(20),
company varchar(50),
question int references Questions ON DELETE CASCADE ON UPDATE CASCADE,
foreign key (job, department, company) references Jobs(title, department, company) ON DELETE CASCADE ON UPDATE CASCADE,
primary key ( job, department, company, question)
);

create table Users (
username varchar(20) primary key,
password varchar(20), 
personal_email varchar(50),
birth_date date not null,
years_of_experience int,
first_name varchar(20),
middle_name varchar(20),
last_name varchar(20), 
age as (year(current_timestamp) - year(birth_date))
);

create table User_Jobs(
job varchar(50),
username varchar(20) references Users ON DELETE CASCADE ON UPDATE CASCADE,
primary key(job,username)
);

create table Job_Seekers(
username varchar(20) primary key references Users ON DELETE CASCADE ON UPDATE CASCADE
);


create table Staff_Members(
username varchar(20) primary key references Users ON DELETE CASCADE ON UPDATE CASCADE ,
annual_leaves int,
company_email varchar(50),
day_off varchar(10),
salary float,
job varchar(50),
department varchar(20),
company varchar(50) references Companies ON DELETE SET NULL ON UPDATE CASCADE,
foreign key (department, company) references Departments ,
foreign key (job, department, company) references Jobs(title, department, company)
);

create table Jobs_Applied_by_Job_Seekers(
job varchar(50),
department varchar(20),
company varchar(50),
job_seeker varchar(20) references Job_Seekers ON DELETE CASCADE ON UPDATE CASCADE,
hr_response bit,-- same as manager response
manager_response bit, --we want to return to this as we aren't sure about bit
score int ,
foreign key (job, department, company) references Jobs(title, department, company) ON DELETE CASCADE ON UPDATE CASCADE,
primary key (job, department, company, job_seeker)
);

create table Attendance_Records(
date date,
staff varchar(20) references Staff_Members ON DELETE CASCADE ON UPDATE CASCADE,
start_time time,
end_time time,
primary key(date,staff)
);

create table Emails(
serial_number int identity primary key,
subject varchar(20),
date datetime,
body varchar(500)
);

create table Emails_sent_by_Staff_Members_to_Staff_Members(
email_number int references Emails ,
recipient varchar(20) references Staff_Members,
sender varchar(20) references Staff_Members,
primary key (email_number, recipient)
);

create table HR_Employees(
username varchar(20) primary key references Staff_Members ON DELETE CASCADE ON UPDATE CASCADE
);

create table Regular_Employees(
username varchar(20) primary key references Staff_Members ON DELETE CASCADE ON UPDATE CASCADE
);

create table Managers(
username varchar(20) primary key references Staff_Members ON DELETE CASCADE ON UPDATE CASCADE,
type varchar(10),
);

create table Announcements(
date datetime,
title varchar(20),
hr_employee varchar(20) references HR_Employees ON DELETE NO ACTION ON UPDATE CASCADE,
type varchar(10),
description varchar(120),
primary key (date, title, hr_employee)
);

create table Requests(
start_date date,
applicant varchar(20) references Staff_Members ON DELETE CASCADE ON UPDATE CASCADE ,
end_date date,
request_date datetime,
total_days as (datediff(day,start_date,end_date)),
hr_response bit, -- ou varchar for values yes/no
manager_response bit, -- nafs el kalam
manager_reason varchar(20),
hr_employee varchar(20) references HR_Employees ON DELETE NO ACTION ON UPDATE NO ACTION,
manager varchar(20) references Managers ON DELETE NO ACTION ON UPDATE NO ACTION,
primary key (start_date, applicant)
);

create table Leave_Requests(
start_date date, 
applicant varchar(20),
type varchar(20),
foreign key (start_date, applicant) references Requests(start_date, applicant) ON DELETE CASCADE ,
primary key(start_date, applicant)
);

create table Business_Trip_Requests(
start_date date, 
applicant varchar(20),
destination varchar(20),
purpose varchar(20),
foreign key (start_date, applicant) references Requests(start_date, applicant) ON DELETE CASCADE ,
primary key(start_date, applicant)
);

create table HR_Employees_apply_replace_Requests(
start_date date,
applicant varchar(20),
hr_employee varchar(20) references HR_Employees ON DELETE NO ACTION ,
replacement varchar(20) references HR_Employees ON DELETE NO ACTION ,
foreign key (start_date, applicant) references Requests(start_date, applicant) ON DELETE CASCADE ON UPDATE NO ACTION,
primary key(start_date, applicant)
);

create table Regular_Employees_apply_replace_Requests(
start_date date,
applicant varchar(20),
reg_employee varchar(20) references Regular_Employees ON DELETE NO ACTION ,
replacement varchar(20) references Regular_Employees ON DELETE NO ACTION ,
foreign key (start_date, applicant) references Requests(start_date, applicant) ON DELETE CASCADE,
primary key(start_date, applicant)
);

create table Managers_apply_replace_Requests(
start_date date,
applicant varchar(20),
manager varchar(20) references Managers ON DELETE NO ACTION,
replacement varchar(20) references Managers ON DELETE NO ACTION,
foreign key (start_date, applicant) references Requests(start_date, applicant) ON DELETE CASCADE,
primary key(start_date, applicant)
);

create table Projects(
name varchar(20),
company varchar(50) references Companies ON DELETE CASCADE ON UPDATE CASCADE,
start_date datetime,
end_date datetime,
manager varchar(20) references Managers ON DELETE SET NULL ON UPDATE NO ACTION,
primary key (name, company)
);

create table Managers_assign_Regular_Employees_Projects(
project_name varchar(20), 
company varchar(50),
regular_employee varchar(20) references Regular_Employees ON DELETE CASCADE,
manager varchar(20) references Managers ON DELETE NO ACTION,
foreign key (project_name, company) references Projects(name, company) ON DELETE CASCADE,
primary key(project_name, company, regular_employee) 
);

create table Tasks(
name varchar(20),
project varchar(20),
company varchar(50),
deadline datetime,
status VARCHAR(10), -- ou varchar active/not active
description varchar(120),
regular_employee varchar(20) references Regular_Employees ON DELETE SET NULL ON UPDATE NO ACTION,
manager varchar(20) references Managers ON DELETE NO ACTION ON UPDATE NO ACTION,
foreign key (project, company) references Projects(name, company) ON DELETE CASCADE ON UPDATE CASCADE,
primary key(name, project, company)
);

create table Task_Comments(
task_name varchar(20),
project varchar(20),
company varchar(50),
comment varchar(120),
foreign key (task_name, project, company) references Tasks(name, project, company) ON DELETE CASCADE ON UPDATE NO ACTION,
primary key (task_name, project, company, comment)
);