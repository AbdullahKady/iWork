USE iWork;

GO
-- Insertion was indented using sublime, to allow for easier changes.
INSERT INTO Companies VALUES ('Apple@live.com','Apple','USA,California','Apple.com','international','delivering','Compture Software');

	INSERT INTO Departments VALUES ('HR102','Apple@live.com','Human Resources');

		INSERT INTO Jobs VALUES('HR - Human Resources Generalist','HR102','Apple@live.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
		2,12000,'2017-12-05',5,8);
		INSERT INTO Jobs VALUES('HR - Human Resources Assistant','HR102','Apple@live.com','Assists in HR','Some description for the HR - Human Resources Assistant that I dont know of?',
		1,14000,'2017-11-08',5,9);
		INSERT INTO Jobs VALUES('Manager - HR Manager','HR102','Apple@live.com','Manages the HR department','Manages the HR department, and some detailed decription about his work',
		4,19000,'2017-09-05',2,6);

			INSERT INTO Users VALUES('Solomon_William','41861','risus.Donec.egestas@faucibusorciluctus.edu','1985-06-18',6,'Denise','Jacob','William');
			INSERT INTO Users VALUES('Keaton_Merrill','93588','ac@Nunc.net','1991-11-01',11,'Portia','Harding','Merrill');
			INSERT INTO Users VALUES('Leonard_Ryan','56025','enim@nequepellentesque.org','1996-06-24',4,'Cameron','Colby','Ryan');
			INSERT INTO Users VALUES('Alec_Delaney','83305','dictum.mi.ac@Sedeu.edu','1982-11-03',11,'Aquila','Honorato','Delaney');
			INSERT INTO Users VALUES('Adolf_Hitler','921321','fuhrer@reich.com','1989-04-20',20, 'Adolf',NULL,'Hitler');
			


			INSERT INTO Staff_Members VALUES ('Solomon_William',30, 'Solomon_William@Apple.com','Saturday',12000.00,'HR - Human Resources Generalist','HR102','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Keaton_Merrill',27, 'Keaton_Merrill@Apple.com','Saturday',12000.00,'HR - Human Resources Generalist','HR102','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Leonard_Ryan',37, 'Leonard_Ryan@Apple.com','Saturday',14000.00,'HR - Human Resources Assistant','HR102','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Alec_Delaney',45, 'Alec_Delaney@Apple.com','Saturday',19000.00,'Manager - HR Manager','HR102','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Adolf_Hitler',100, 'Adolf_Hitler@Apple.com','Sunday',19000.00,'Manager - HR Manager','HR102','Apple@live.com');
				
				INSERT INTO HR_Employees VALUES ('Solomon_William');
				INSERT INTO HR_Employees VALUES ('Keaton_Merrill');
				INSERT INTO HR_Employees VALUES ('Leonard_Ryan');
				INSERT INTO Managers VALUES ('Alec_Delaney','HR');
				INSERT INTO Managers VALUES ('Adolf_Hitler','HR');



	INSERT INTO Departments VALUES ('SE302','Apple@live.com','Software Engineering');

		INSERT INTO Jobs VALUES('Regular Employee - Softawre Developer','SE302','Apple@live.com','A general Softawre Developer that developes stuff?','Software engineering and coding and other stuff as description. so details. much deepness',
		2,10000,'2017-12-05',6,10);
		INSERT INTO Jobs VALUES('Manager - Software manager','SE302','Apple@live.com','Leads teams in software engineering','Manages projects and he leads the teams through the process',
		2,18000,'2018-02-25',3,7);
		INSERT INTO Jobs VALUES('HR - Software Engineer ','SE302','Apple@live.com','The position of Human resources for software engineering','handles all Human resources for employees in the department of software engineering' ,
		2,14000,'2017-12-21',4,8);

			INSERT INTO Users VALUES('Devin_Everett','73081','semper@atortor.ca','1988-01-30',6,'Kaden','Lyle','Everett');
			INSERT INTO Users VALUES('Graiden_Pena','16097','pulvinar@commodoat.edu','1986-02-22',7,'Wing','Alden','Pena');
			INSERT INTO Users VALUES('Oren_Foster','46972','urna.nec.luctus@ultricesposuere.net','1980-08-13',14,'Cullen','Odysseus','Foster');
			INSERT INTO Users VALUES('Patrick_Fernandez','49707','elit.erat@Donecfelisorci.ca','1981-05-01',14,'Carly','Denton','Fernandez');
			INSERT INTO Users VALUES('Theodore_Roth','78930','lorem.fringilla@duinec.ca','1978-11-12',3,'Chastity','Joseph','Roth');
			INSERT INTO Users VALUES('Kuame_Downs','14963','lacus.varius.et@infaucibusorci.co.uk','1978-04-11',3,'Paula','Simon','Downs');
			INSERT INTO Users VALUES('Quinlan_Benson','39060','libero@molestieSedid.net','1991-06-28',3,'Victoria','Ian','Benson');
			
			
			INSERT INTO Staff_Members VALUES ('Devin_Everett',40, 'Devin_Everett@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Graiden_Pena',45, 'Graiden_Pena@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Oren_Foster',40, 'Oren_Foster@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Patrick_Fernandez',20, 'Patrick_Fernandez@Apple.com','Saturday',14000.00,'HR - Software Engineer ','SE302','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Theodore_Roth',23, 'Patrick_Fernandez@Apple.com','Saturday',14000.00,'HR - Software Engineer ','SE302','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Kuame_Downs',60, 'Kuame_Downs@Apple.com','Saturday',18000.00,'Manager - Software manager','SE302','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Quinlan_Benson',17, 'Quinlan_Benson@Apple.com','Saturday',18000.00,'Manager - Software manager','SE302','Apple@live.com');

				INSERT INTO Regular_Employees VALUES ('Devin_Everett');
				INSERT INTO Regular_Employees VALUES ('Graiden_Pena');
				INSERT INTO Regular_Employees VALUES ('Oren_Foster');
				INSERT INTO HR_Employees VALUES('Patrick_Fernandez');
				INSERT INTO HR_Employees VALUES('Theodore_Roth');
				INSERT INTO Managers VALUES('Kuame_Downs', 'SE');
				INSERT INTO Managers VALUES('Quinlan_Benson', 'SE');

				-- SINCE 2 ANNOUNCEMENTS WERE REQUIRED 

				INSERT INTO Announcements(date,description,hr_employee,title,type) VALUES ('2017-12-05','Free coffee at the lounge next Wednesday!','Theodore_Roth','Free Coffee!','Freebie');
				INSERT INTO Announcements(date,description,hr_employee,title,type) VALUES ('2017-12-09','Next Thursday will be off. However you will have compensations on Friday! (GUC Who?)','Theodore_Roth','Thursday is off!','Day_off');
				

				-- TESTING FOR HIGHEST ACHIEVERS : 
				INSERT INTO Users VALUES('Wrolim_Isaac',11510,'Wrolim_Isaac@felisDonectempor.org','1972-09-13',3,'Wrolim','Mango','Isaac');
				INSERT INTO Staff_Members VALUES ('Wrolim_Isaac',40, 'Wrolim_Isaac@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
				INSERT INTO Regular_Employees VALUES ('Wrolim_Isaac');
				INSERT INTO Users VALUES('John_kenn',11510,'John_kenn@felisDonectempor.org','1972-09-13',3,'John','F.','Kennedy');
				INSERT INTO Staff_Members VALUES ('John_kenn',40, 'John_kenn@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
				INSERT INTO Regular_Employees VALUES ('John_kenn');
				INSERT INTO Users VALUES('Shrooq_Ahmad',11510,'Shrooq_Ahmad@gmail.com','1972-09-13',3,'Shorooq','Ramy','Ahmad');
				INSERT INTO Staff_Members VALUES ('Shrooq_Ahmad',40, 'Shrooq_Ahmad@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
				INSERT INTO Regular_Employees VALUES ('Shrooq_Ahmad');
				INSERT INTO Users VALUES('Abdalnaby_sleem',11510,'Abdelnaby@felisDonectempor.org','1972-09-13',3,'Abdelnaby','Ahmed','Sleem');
				INSERT INTO Staff_Members VALUES ('Abdalnaby_sleem',40, 'Abdelnaby_Sleem@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
				INSERT INTO Regular_Employees VALUES ('Abdalnaby_sleem');
				INSERT INTO Users VALUES('Mohab_Rady',11510,'Mohab_D@felisDonectempor.org','1972-09-13',3,'Mohab','Shahid','Rady');
				INSERT INTO Staff_Members VALUES ('Mohab_Rady',40, 'Mohab_Rady@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
				INSERT INTO Regular_Employees VALUES ('Mohab_Rady');
				INSERT INTO Users VALUES('Ahmed_Salem',11510,'Ahmad.slm@felisDonectempor.org','1972-09-13',3,'Ahmed','Sayed','Salem');
				INSERT INTO Staff_Members VALUES ('Ahmed_Salem',40, 'Ahmed_Salem@Apple.com','Saturday',10000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');
				INSERT INTO Regular_Employees VALUES ('Ahmed_Salem');
				
				INSERT INTO Projects(company,name) VALUES ('Apple@live.com', 'project1');
				INSERT INTO Projects(company,name) VALUES ('Apple@live.com', 'project2');
				INSERT INTO Projects(company,name) VALUES ('Apple@live.com', 'project3');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Wrolim_Isaac','task10',1,'2017-08-25');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Wrolim_Isaac','task20',1,'2017-08-25');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project1','Wrolim_Isaac','task30',1,'2017-08-25');
				
				
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Wrolim_Isaac', '2017-09-10','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Wrolim_Isaac', '2017-09-11','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Wrolim_Isaac', '2017-09-12','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Wrolim_Isaac', '2017-09-13','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Wrolim_Isaac', '2017-09-14','10:00:00','17:00:00');
				
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('John_kenn', '2017-09-10','14:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('John_kenn', '2017-09-11','14:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('John_kenn', '2017-09-12','14:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('John_kenn', '2017-09-13','14:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('John_kenn', '2017-09-14','14:00:00','17:00:00');
				
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Shrooq_Ahmad', '2017-09-10','07:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Shrooq_Ahmad', '2017-09-11','07:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Shrooq_Ahmad', '2017-09-12','07:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Shrooq_Ahmad', '2017-09-13','07:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Shrooq_Ahmad', '2017-09-14','07:00:00','23:00:00');
				
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Abdalnaby_sleem', '2017-09-27','10:00:00','22:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Abdalnaby_sleem', '2017-09-18','10:00:00','22:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Abdalnaby_sleem', '2017-09-12','10:00:00','22:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Abdalnaby_sleem', '2017-09-13','10:00:00','22:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Abdalnaby_sleem', '2017-09-14','10:00:00','22:00:00');
				
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Mohab_Rady', '2017-09-10','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Mohab_Rady', '2017-09-11','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Mohab_Rady', '2017-09-12','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Mohab_Rady', '2017-09-13','10:00:00','17:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Mohab_Rady', '2017-09-14','10:00:00','17:00:00');
				
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Ahmed_Salem', '2017-09-10','10:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Ahmed_Salem', '2017-09-11','10:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Ahmed_Salem', '2017-09-12','10:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Ahmed_Salem', '2017-09-13','10:00:00','23:00:00');
				INSERT INTO Attendance_Records(staff,date,start_time,end_time) VALUES ('Ahmed_Salem', '2017-09-14','10:00:00','23:00:00');
				
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Ahmed_Salem','task1',1,'2017-09-05');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Ahmed_Salem','task2',0,'2017-09-15');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Ahmed_Salem','task3',1,'2017-09-25');
				
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Shrooq_Ahmad','task4',1,'2017-09-05');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Shrooq_Ahmad','task5',1,'2017-09-15');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Shrooq_Ahmad','task6',1,'2017-09-25');
				
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Abdalnaby_sleem','task7',1,'2017-09-05');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Abdalnaby_sleem','task8',1,'2017-09-15');
				INSERT INTO Tasks(company,project,regular_employee,name,status,deadline) VALUES ('Apple@live.com', 'project2','Abdalnaby_sleem','task9',1,'2017-09-25');

				--extra hard-coded insertions for the executions script :
				
				INSERT INTO Users VALUES('Ralph_Lauren',80510,'Ralph@Lauren.org','1981-09-22',4,'Ralph','Foxtrot','Lauren');
				INSERT INTO Job_Seekers values ('Ralph_Lauren');
				INSERT INTO Users VALUES('Anne_Frank',80510,'Anne@Auschwitz.org','1941-03-25',9,'Anne','Marie ','Frank');
				INSERT INTO Job_Seekers values ('Anne_Frank');
				INSERT INTO Users VALUES('Jack_Remon',80510,'Jack@grandons.org','1989-07-25',3,'Jackson','Rodolf','Remons');
				INSERT INTO Job_Seekers values ('Jack_Remon');
				INSERT INTO Users VALUES('Rakesh_Dajis',80510,'Rakesh@grandons.org','1990-01-12',4,'Rakesh','Mumjap','Dajis');
				INSERT INTO Job_Seekers values ('Rakesh_Dajis');
				INSERT INTO Users VALUES('Shereef_Samy',80510,'Shereef_Samy@gmail.com','1982-01-12',6,'Shereef','Mohammad','Samy');
				INSERT INTO Job_Seekers values ('Shereef_Samy');
				INSERT INTO Jobs_Applied_by_Job_Seekers(department,job,company,job_seeker) VALUES ('SE302','Regular Employee - Softawre Developer','Apple@live.com','Ralph_Lauren');
				INSERT INTO Jobs_Applied_by_Job_Seekers(department,job,company,job_seeker) VALUES ('SE302','Regular Employee - Softawre Developer','Apple@live.com','Anne_Frank');
				INSERT INTO Jobs_Applied_by_Job_Seekers(department,job,company,job_seeker) VALUES ('SE302','Manager - Software manager','Apple@live.com','Rakesh_Dajis');
				INSERT INTO Jobs_Applied_by_Job_Seekers(department,job,company,job_seeker) VALUES ('SE302','Manager - Software manager','Apple@live.com','Jack_Remon');
				INSERT INTO Jobs_Applied_by_Job_Seekers(department,job,company,job_seeker) VALUES ('SE302','Manager - Software manager','Apple@live.com','Shereef_Samy');
				INSERT INTO Users VALUES('Jasmine_Todd',123121,'theberbo@gmail.com','1991-12-23',2,'Jasmine','Hashim','Tamara');
				INSERT INTO Staff_Members VALUES ('Jasmine_Todd',30, 'Jasmine_Todd@Apple.com','Saturday',12000.00,'Regular Employee - Softawre Developer','SE302','Apple@live.com');

				insert into Requests(applicant,start_date,manager_response,end_date,request_date) values ('Jasmine_Todd', '2017-08-21',1,'2017-08-25','2017-07-17');
				insert into Requests(applicant,start_date,manager_response,end_date,request_date) values ('John_kenn', '2017-09-11',1,'2017-09-19','2017-08-11');
				insert into Requests(applicant,start_date,manager_response,end_date,request_date) values ('Oren_Foster', '2017-09-21',1,'2017-09-27','2017-06-26');
				insert into Leave_Requests(applicant,start_date,type) VALUES ('Jasmine_Todd', '2017-08-21', 'Annual leave');
				insert into Leave_Requests(applicant,start_date,type) VALUES ('John_kenn', '2017-09-11', 'Assassination');
				INSERT INTO Business_Trip_Requests(applicant,start_date,destination,purpose) VALUES ('Oren_Foster', '2017-09-21','Berlin','Sign contract #81');
				insert into Requests(applicant,start_date,end_date,manager_response,request_date) values ('Wrolim_Isaac', '2017-08-14','2017-08-26',1,'2017-07-20');
				insert into Requests(applicant,start_date,end_date,manager_response,request_date) values ('Shrooq_Ahmad', '2017-08-25','2017-08-28',1,'2017-07-17');
				insert into Requests(applicant,start_date,end_date,manager_response,request_date) values ('Abdalnaby_sleem', '2017-08-19','2017-08-23',1,'2017-07-10');
				insert into Requests(applicant,start_date,end_date,manager_response,request_date) values ('Mohab_Rady', '2017-08-16','2017-08-23',1,'2017-07-13');
				insert into Requests(applicant,start_date,end_date,manager_response,request_date) values ('Oren_Foster', '2017-08-03','2017-08-14',1,'2017-07-19');
				insert into Leave_Requests(applicant,start_date,type) VALUES ('Wrolim_Isaac', '2017-08-14', 'Annual leave');
				insert into Leave_Requests(applicant,start_date,type) VALUES ('Shrooq_Ahmad', '2017-08-25', 'Sickness');
				insert into Leave_Requests(applicant,start_date,type) VALUES ('Oren_Foster', '2017-08-03', 'Annual leave');
				INSERT INTO Business_Trip_Requests(applicant,start_date,destination,purpose) VALUES ('Abdalnaby_sleem', '2017-08-19','Al Ga7eem','Visiting Blackbeard');
				INSERT INTO Business_Trip_Requests(applicant,start_date,destination,purpose) VALUES ('Mohab_Rady', '2017-08-16','Alexandria','Finish up paper');




	INSERT INTO Departments VALUES ('D431','Apple@live.com','Design');

		INSERT INTO Jobs VALUES('Manager - Desing manager','D431','Apple@live.com','Manages the designing department','Responsible for the projects and the department of the design in Apple.',
		3,20000,'2017-12-05',3,9);
		INSERT INTO Jobs VALUES('Regular Employee - Designer','D431','Apple@live.com','Designer employee','Works on various projects in the department of the design in Apple.',
		5,12000,'2018-12-21',5,8);
		INSERT INTO Jobs VALUES('HR - Designer Human Resources','D431','Apple@live.com','Human resources in the department of design','Responsible for the Human resources for the employees of the department of the design in Apple.',
		3,17000,'2018-2-17',3,9);

			INSERT INTO Users VALUES('Paul_Maddox','57490','purus.mauris.a@eleifend.edu','1996-11-07',3,'Roanna','Jackson','Maddox');
			INSERT INTO Users VALUES('Nero_Gross','49470','Curabitur.ut@blanditmattis.org','1994-01-23',5,'Nora','Hu','Gross')
			INSERT INTO Users VALUES('Forrest_Farmer','43891','quis@lacusNulla.net','1964-12-12',2,'Matthew','Kermit','Farmer');
			INSERT INTO Users VALUES('Igor_Buckner','74244','magnis@scelerisque.co.uk','1969-06-10',2,'Russell','Timothy','Buckner');
			INSERT INTO Users VALUES('Arsenio_Soto','12297','leo.in@arcuVestibulum.edu','1974-12-18',4,'Jason','Roth','Soto');
			INSERT INTO Users VALUES('Wayne_Larsen','62639','tincidunt.nibh.Phasellus@volutpat.edu','1981-03-03',7,'Kyle','Laith','Larsen');
			
			INSERT INTO Staff_Members VALUES ('Paul_Maddox',20, 'Paul_Maddox@Apple.com','Saturday',12000.00,'Regular Employee - Designer','D431','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Nero_Gross',21, 'Nero_Gross@Apple.com','Saturday',12000.00,'Regular Employee - Designer','D431','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Forrest_Farmer',30, 'Forrest_Farmer@Apple.com','Saturday',17000.00,'HR - Designer Human Resources','D431','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Igor_Buckner',35, 'Igor_Buckner@Apple.com','Saturday',17000.00,'HR - Designer Human Resources','D431','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Arsenio_Soto',50, 'Arsenio_Soto@Apple.com','Saturday',20000.00,'Manager - Desing manager','D431','Apple@live.com');
			INSERT INTO Staff_Members VALUES ('Wayne_Larsen',37, 'Wayne_Larsen@Apple.com','Saturday',20000.00,'Manager - Desing manager','D431','Apple@live.com');

				INSERT INTO Regular_Employees VALUES ('Paul_Maddox');
				INSERT INTO Regular_Employees VALUES ('Nero_Gross');
				INSERT INTO HR_Employees VALUES('Forrest_Farmer');
				INSERT INTO HR_Employees VALUES('Igor_Buckner');
				INSERT INTO Managers VALUES('Arsenio_Soto', 'Designer');
				INSERT INTO Managers VALUES('Wayne_Larsen', 'Designer');



---------------------------------------------------------------------------------------------------------------- YASSIN

--EL Nasr


insert into Companies Values ('ELNasr@gmail.com','EL NASR','Egypt','El-Nasr.com','national','Manufacturing','Automobiles')


insert into Departments Values ('F12','ELNasr@gmail.com','Finance')
insert into Departments Values ('MECH102','ELNasr@gmail.com','Mechanical')
insert into Departments Values ('MK103','ELNasr@gmail.com','Marketing')

insert into Users Values ('Samya.Gamal','7865434','Samya.Gamal@gmail.com','1982-07-18',11,'Samya','Ahmed','Gamal')
insert into Users Values ('Lydia.Samir','1254667','Lydia.Samir@gmail.com','1991-12-12',2,'Lydia','Mina','Samir')
insert into Users Values ('Nada.Sharaf','7585698','Nada.Sharaf@gmail.com','1992-03-08',1,'Nada','Ahmed','Sharaf')
insert into Users Values ('Lama.Tag','435259','Lama.Tag@gmail.com','1987-03-29',6,'Lama','Ahmed','Tag')
insert into Users Values ('Nesma.Saad','729025','Nesma.Saad@gmail.com','1982-04-04',11,'Nesma','Mohamed','Saad')
insert into Users Values ('Loujine.Sultan','122986','Louji.S@gmail.com','1990-03-08',3,'Loujine','Ahmed','Sultan')
insert into Users Values ('Yassin.Chaddad','12213302','Yasso.Shado@gmail.com','1977-03-08',16,'Yassin','Abdallah','Chaddad')
insert into Users Values ('Sara.Zahran','126781111','Soso.Zahran@gmail.com','1981-05-05',12,'Sara','Alaa','Zahran')
insert into Users Values ('Sama.Mahmoud','1249823','Sama.Ahmed@gmail.com','1988-07-09',5,'Sama','Ahmed','Mahmoud')
insert into Users Values ('Slim.Abdenadder','12298532','Slim.Abdenadder@gmail.com','1967-07-11',26,'Slim','Ayman','Abdenadder')
insert into Users Values ('Sally.Moheb','12295632','Sally12@gmail.com','1987-08-11',6,'Sally','Ayman','Moheb')
insert into Users Values ('Mona.Shoeb','198532','Monmon@gmail.com','1990-07-19',3,'Mona','Gamal','Shoeb')
insert into Users Values ('Mahmoud.Zaher','19853245','MahmoudN@gmail.com','1965-07-19',28,'Mahmoud','Nasr','Zaher')


insert into Jobs values ('HR - HR Generalist','F12','ELNasr@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
12,15000,'2017-12-05',2,8)

insert into Jobs values ('HR - Human Resources Coordinator','F12','ELNasr@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
3,8000,'2017-12-05',2,8)

insert into Jobs values ('Manager - Finance Manager','F12','ELNasr@gmail.com',
'responsible for all areas relating to financial reporting','Obtain and maintain a thorough understanding of the financial reporting and general ledger structure.',
5,10000.00,'2017-12-05',2,8)

insert into Jobs values ('Manager - Human Resources Director','F12','ELNasr@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,15000.00,'2017-12-05',2,8)



insert into Staff_Members Values ('Yassin.Chaddad',40,'Yassin.Chaddad@El-Nasr.com','Friday',15000,'HR - HR Generalist','F12','ELNasr@gmail.com')
insert into HR_Employees values('Yassin.Chaddad')

insert into Staff_Members Values ('Lama.Tag',80,'Lama.tag@El-Nasr.com','Saturday',8000,'HR - Human Resources Coordinator','F12','ELNasr@gmail.com')
insert into HR_Employees values('Lama.Tag')


insert into Staff_Members Values ('Nesma.Saad',90,'Nesma.Saad@El-Nasr.com','Friday',15000.00,'Manager - Human Resources Director','F12','ELNasr@gmail.com')
insert into Managers values('Nesma.Saad','HR')


insert into Staff_Members Values ('Sally.Moheb',70,'Sally.Moheb@El-Nasr.com','Saturday',10000,'Manager - Finance Manager','F12','ELNasr@gmail.com')
insert into Managers values('Sally.Moheb','Finance')





--Mechanical Departement
-------------------------------------


insert into Jobs values ('HR - Human Resources Coordinator','MECH102','ELNasr@gmail.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
1,5000,'2017-12-05',2,8)


insert into Staff_Members Values ('Lydia.Samir',30,'Lydia.Samir@El-Nasr.com','Friday',5000,'HR - Human Resources Coordinator','MECH102','ELNasr@gmail.com')
insert into HR_Employees values('Lydia.Samir')



insert into Jobs values ('HR - HR Clerk','MECH102','ELNasr@gmail.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
0,3000,'2017-12-15',2,8)


insert into Staff_Members Values ('Nada.Sharaf',45,'Nada.Sharaf@El-Nasr.com','Saturday',3000,'HR - HR Clerk','MECH102','ELNasr@gmail.com')
insert into HR_Employees values('Nada.Sharaf')

insert into Jobs values ('Manager - Mechanical Manager','MECH102','ELNasr@gmail.com',
'oversee the daily activities of a team of employees.','oversee the daily activities of a team of employees who do designs, concepts, review the reports on the mechanical parts and factories of the company and take care of the mechanical departement flow. ',
25,40000,'2017-12-15',1,8)


insert into Staff_Members Values ('Slim.Abdenadder',100,'Slim.Abdenadder@El-Nasr.com','Friday',35000,'Manager - Mechanical Manager','MECH102','ELNasr@gmail.com')
insert into Managers values('Slim.Abdenadder', 'Mechanical')


insert into Jobs values ('Manager - Human Resources Director','MECH102','ELNasr@gmail.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,15000.00,'2017-12-05',2,8)


insert into Staff_Members Values ('Sara.Zahran',70,'Sara.Zahran@El-Nasr.com','Friday',15000,'Manager - Human Resources Director','MECH102','ELNasr@gmail.com')
insert into Managers values('Sara.Zahran','HR')



--Marketing Departement
-------------------------------------------------------------------





insert into Jobs values ('Manager - Human Resources Director','MK103','ELNasr@gmail.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,12000.00,'2017-12-05',3,8)


insert into Staff_Members Values ('Samya.Gamal',70,'Samya.Gamal@El-Nasr.com','Friday',12000,'Manager - Human Resources Director','MK103','ELNasr@gmail.com')
insert into Managers values('Samya.Gamal','HR')


insert into Jobs values ('HR - HR Generalist','MK103','ELNasr@gmail.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
4,6000,'2017-12-05',2,8)


insert into Staff_Members Values ('Sama.Mahmoud',45,'Sama.Mahmoud@El-Nasr.com','Saturday',6000,'HR - HR Generalist','MK103','ELNasr@gmail.com')
insert into HR_Employees values ('Sama.Mahmoud')


insert into Jobs values ('Manager - Marketing Manager','MK103','ELNasr@gmail.com','Take care of the marketing plans of the company','Take care of the marketing plan of the company and adds new creative ideas for the campaigns; solving performance problems.',
25,20000,'2017-12-25',1,8)


insert into Staff_Members Values ('Mahmoud.Zaher',90,'Mahmoud.Zaher@El-Nasr.com','Friday',20000,'Manager - Marketing Manager','MK103','ELNasr@gmail.com')
insert into Managers values ('Mahmoud.Zaher','Marketing')


insert into Jobs values ('HR - HR Clerk','MK103','ELNasr@gmail.com','Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
0,2000,'2017-12-15',2,8)


insert into Staff_Members Values ('Loujine.Sultan',45,'Loujine.Sultan@El-Nasr.com','Sunday',2000,'HR - HR Clerk','MK103','ELNasr@gmail.com')
insert into HR_Employees values ('Loujine.Sultan')





--- additional insertions for testing.

-- Job Seeker

--US1

insert into Users values ('Amin.chaddad', '2112313', 'amin.chaddad@gmail.com', '1994/7/19', 7, 'Amin', 'Abdallah', 'Chaddad')
insert into Users values ('Ali.chaddad', '4113343', 'ali.chaddad@gmail.com', '1992/10/2', 17, 'Ali', 'Abdallah', 'Chaddad')
insert into Users values ('Abdallah.chaddad', '4113343', 'abdallah.chaddad@gmail.com', '1957/6/10', 30, 'Abdallah', 'Amin', 'Chaddad')

insert into Job_Seekers values ('Amin.chaddad')
insert into Job_Seekers values ('Ali.chaddad')
insert into Job_Seekers values ('Abdallah.chaddad')


insert into Jobs values ('Regular Employee - Mechatronix Engineer', 'Mech102', 'ElNasr@gmail.com', 'making of electronic and mechanique parts',
'creation of machines with electronic technologies linked to the mechanic parts', 7, 5000, '2017-11-30', 4, 10)
insert into Jobs values ('Regular Employee - Mechanical Engineer', 'Mech102', 'ElNasr@gmail.com', 'making of mechanical parts',
'Transforming the design into a functioning machinery', 20, 15000, '2017-11-30', 2, 10)
insert into Jobs values ('Regular Employee - Accountant', 'F12', 'ElNasr@gmail.com', 'Make calculations',
'make profits and lossed calculations for the company', 13, 7000, '2017-11-30', 7, 8)


insert into Jobs_Applied_by_Job_Seekers values ('Regular Employee - Accountant', 'F12', 'ElNasr@gmail.com', 'Ali.chaddad', 1, 1, 50)
insert into Jobs_Applied_by_Job_Seekers values ('Regular Employee - Mechanical Engineer', 'Mech102', 'ElNasr@gmail.com', 'Ali.chaddad', 0, 0, 150)

insert into Questions values('pi is equal to 3.17?', 0)
insert into Questions values('velocity is a vector', 1) 
insert into Questions values('variance is average', 0) 
insert into Jobs_have_Questions values('Regular Employee - Accountant', 'F12', 'ElNasr@gmail.com', 1)
insert into Jobs_have_Questions values('Regular Employee - Accountant', 'F12', 'ElNasr@gmail.com', 3)
insert into Jobs_have_Questions values('Regular Employee - Mechanical Engineer', 'Mech102', 'ElNasr@gmail.com', 2)

insert into Staff_Members values('Abdallah.chaddad', 10, 'Abd','Monday', 10000, 'Regular Employee - Accountant', 'F12', 'ElNasr@gmail.com')
insert into Regular_Employees values('Abdallah.chaddad')

insert into Projects values('Car', 'ElNasr@gmail.com', '2017/04/08 00:00', '2018/04/08 00:00', 'Slim.Abdenadder')
insert into Projects values('Car2', 'ElNasr@gmail.com', '2017/04/08 00:00', '2018/04/08 00:00', 'Slim.Abdenadder')

insert into Managers_assign_Regular_Employees_Projects values ('Car', 'ElNasr@gmail.com', 'Abdallah.chaddad', 'Slim.Abdenadder')
insert into Managers_assign_Regular_Employees_Projects values ('Car2', 'ElNasr@gmail.com', 'Abdallah.chaddad', 'Slim.Abdenadder')

insert into Tasks values('Parts', 'Car', 'ElNasr@gmail.com', '2018/04/08 00:00', 'Assigned', 'Calculate part costs', 'Abdallah.chaddad',
'Slim.Abdenadder')
insert into Tasks values('Machinery', 'Car', 'ElNasr@gmail.com', '2017/04/08 00:00', 'Assigned', 'Calculate machinery costs', 'Abdallah.chaddad',
'Slim.Abdenadder')


insert into Announcements values (CURRENT_TIMESTAMP , 'Work Update','yassin.chaddad','update','notice that some of the projects have been modified')
insert into Announcements values ('2018/02/02' , 'Off Day','lama.tag','Announc','next Saturday is an official holiday')
insert into Announcements values ('2017/12/03' , 'Independ','lama.tag','Announc','Independence day celebrations')

-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------------------------------------------------

insert into Companies Values ('Mentor_Graphics@gmail.com','Mentor Graphics','USA,Florida',
						'Mentor_Graphics.com','international','Concent','computer hardware')

insert into Departments Values ('A&F102','Mentor_Graphics@gmail.com','Accounting')
insert into Departments Values ('R&D101','Mentor_Graphics@gmail.com','R&D')
insert into Departments Values ('IT702','Mentor_Graphics@gmail.com','Internet Technology')

insert into Users Values ('Sayed.ahmed','12211111','sayed.ahmed@gmail.com','1980-03-08',
							13,'Sayed','Alaa','Ahmed')
insert into Users Values ('Ahmed.gamal','1231111','ahmed.gamal@gmail.com','1987-02-08',
							6,'Ahmed','Alaa','gamal')
insert into Users Values ('Bahaa.ahmed','1111113','Bahaa.ahmed@gmail.com','1983-11-09',
							10,'Bahaa','Alaa El Din','Ahmed')
insert into Users Values ('Layla.ahmed','7777653','Layla.ahmed@gmail.com','1985-03-08',
							8,'Layla','El Sayed','Ahmed')
insert into Users Values ('Maria.Maqarious','1227621','Maria.m@gmail.com','1990-11-10',
							3,'Maria','John','Maqarious')
insert into Users Values ('Mohamed.Moubarak','12090921','mohamed.mob@gmail.com','1995-10-02',
							0,'Mohamed','Hemad','Moubarak')
insert into Users Values ('Abdelrahman.Hemdan','1208921','abdelrahman.hemdan@gmail.com','1985-12-14',
							7,'Abdelrahman','Hamed','Hemdan')
insert into Users Values ('Hossam.Khaled','1hja21','hossam.khaled@gmail.com','1980-12-10',
							7,'Hossam','Khaled','Saleh')
insert into Users Values ('Youssef.Abbass','12huhu21','youssef.abbass@gmail.com','1975-06-14',
							18,'Youssef','Amr','Abbass')
insert into Users Values ('Aya.Alaa','12koko21','aya.alaa@gmail.com','1990-08-11',
							5,'Aya','Alaa','Saleh')
insert into Users Values ('Deyaa.Salah','1209hufrd21','deyaa.salah@gmail.com','1960-12-14',
							34,'Deyaa','Salah','El-Maghraby')
insert into Users Values ('Sara.Fakhry','120jifg21','sara.fakhry@gmail.com','1995-05-16',
							0,'Sara','Mohamed','Fakhry')


insert into Jobs values ('HR Generalist','A&F102','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,15000,'2017-12-05',2,8)

insert into Jobs values ('Human Resources Coordinator','A&F102','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
3,8000,'2017-12-05',2,8)

insert into Jobs values ('Accounting Manager','A&F102','Mentor_Graphics@gmail.com',
'responsible for all areas relating to financial reporting','Obtain and maintain a thorough understanding of the financial reporting and general ledger structure.',
5,10000.00,'2017-12-05',2,8)

insert into Jobs values ('Human Resources Director','A&F102','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,15000.00,'2017-12-05',2,8)

insert into Staff_Members Values ('Sayed.ahmed',100,'sayed.ahmed@Mentor_Graphics.com','Friday',15000.00,
							'HR Generalist','A&F102','Mentor_Graphics@gmail.com')

insert into HR_Employees values('Sayed.ahmed')

insert into Staff_Members Values ('Ahmed.gamal',80,'ahmed.gamal@Mentor_Graphics.com','Saturday',8000.00,
							'Human Resources Coordinator','A&F102','Mentor_Graphics@gmail.com')

insert into HR_Employees values('Ahmed.gamal')

insert into Staff_Members Values ('Bahaa.ahmed',90,'Bahaa.ahmed@Mentor_Graphics.com','Friday',15000.00,
							'Human Resources Director','A&F102','Mentor_Graphics@gmail.com')

insert into Managers values('Bahaa.ahmed','HR')


insert into Staff_Members Values ('Layla.ahmed',70,'Layla.ahmed@Mentor_Graphics.com','Saturday',12000,
							'Accounting Manager','A&F102','Mentor_Graphics@gmail.com')

insert into Managers values('Layla.ahmed','Accounting')

insert into Jobs values ('Human Resources Coordinator','R&D101','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
1,5000,'2017-12-05',2,8)


insert into Staff_Members Values ('Maria.Maqarious',40,'Maria.m@Mentor_Graphics.com','Friday',5000,
							'Human Resources Coordinator','R&D101','Mentor_Graphics@gmail.com')

insert into HR_Employees values('Maria.Maqarious')



insert into Jobs values ('HR Clerk','R&D101','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
0,2000,'2017-12-15',2,8)

insert into Staff_Members Values ('Mohamed.Moubarak',45,'mohamed.mob@Mentor_Graphics.com','Saturday',2000,
							'HR Clerk','R&D101','Mentor_Graphics@gmail.com')

insert into HR_Employees values('Mohamed.Moubarak')

insert into Jobs values ('R&D Manager','R&D101','Mentor_Graphics@gmail.com',
'oversee the daily activities of a team of employees who research designs, concepts, and services.','oversee the daily activities of a team of employees who research designs, concepts, and services.',
25,35000,'2017-12-15',1,8)

insert into Staff_Members Values ('Abdelrahman.Hemdan',100,'abdelrahman.hemdan@Mentor_Graphics.com','Friday',35000,
							'R&D Manager','R&D101','Mentor_Graphics@gmail.com')

insert into Managers values('Abdelrahman.Hemdan', 'R&D')


insert into Jobs values ('Human Resources Director','R&D101','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,15000.00,'2017-12-05',2,8)



insert into Staff_Members Values ('Hossam.Khaled',70,'hossam.khaled@Mentor_Graphics.com','Friday',15000,
							'Human Resources Director','R&D101','Mentor_Graphics@gmail.com')

insert into Managers values('Hossam.Khaled','HR')



insert into Jobs values ('Human Resources Director','IT702','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,12000.00,'2017-12-05',3,8)

insert into Staff_Members Values ('Youssef.Abbass',70,'youssef.abbass@Mentor_Graphics.com','Friday',12000,
							'Human Resources Director','IT702','Mentor_Graphics@gmail.com')

insert into Managers values('Youssef.Abbass','HR')


insert into Jobs values ('HR Generalist','IT702','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
10,15000,'2017-12-05',2,8)

insert into Staff_Members Values ('Aya.Alaa',45,'aya.alaa@Mentor_Graphics.com','Saturday',7000,
							'HR Generalist','IT702','Mentor_Graphics@gmail.com')

insert into HR_Employees values ('Aya.Alaa')


insert into Jobs values ('IT Director','IT702','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
30,20000,'2017-12-25',1,8)

insert into Staff_Members Values ('Deyaa.Salah',90,'deyaa.salah@Mentor_Graphics.com','Friday',20000,
							'IT Director','IT702','Mentor_Graphics@gmail.com')

insert into Managers values ('Deyaa.Salah','IT')



insert into Jobs values ('HR Clerk','IT702','Mentor_Graphics@gmail.com',
'Implements human resources programs by providing human resources services','Supports operating units by implementing human resources programs; solving performance problems.',
0,2000,'2017-12-15',2,8)

insert into Staff_Members Values ('Sara.Fakhry',45,'sara.fakhry@Mentor_Graphics.com','Sunday',2000,
							'HR Clerk','IT702','Mentor_Graphics@gmail.com')

insert into HR_Employees values ('Sara.Fakhry')

-----------------------------------------------------------------------------------------------------------------------------
insert into Users Values ('A','12211111','A@gmail.com','1111-11-11',
							13,'A','Aa','Aaa')
insert into Users Values ('B','1231111','B@gmail.com','1987-02-08',
							6,'B','Bb','Bbb')
insert into Users Values ('C','1111113','C@gmail.com','1983-11-09',
							10,'C','Cc','Ccc')
insert into Users Values ('D','7777653','D@gmail.com','1985-03-08',
							8,'D','Dd','Ddd')
insert into Users Values ('E','1227621','E@gmail.com','1990-11-10',
							3,'E','Ee','Eee')
insert into Users Values ('F','12090921','F@gmail.com','1995-10-02',
							0,'F','Ff','Fff')
insert into Users Values ('G','1208921','G@gmail.com','1985-12-14',
							7,'G','Gg','Gg')
insert into Users Values ('H','1hja21','H@gmail.com','1980-12-10',
							7,'H','Hh','Hhh')
insert into Users Values ('I','12huhu21','I@gmail.com','1975-06-14',
							18,'I','Ii','Iii')
insert into Users Values ('J','12koko21','J@gmail.com','1990-08-11',
							5,'J','Jj','Jjj')
insert into Users Values ('K','1209hufrd21','K@gmail.com','1960-12-14',
							34,'K','Kk','Kkk')
insert into Users Values ('L','120jifg21','L@gmail.com','1995-05-16',
							0,'L','LL','LLL')

insert into Jobs values('R1','A&F102','Mentor_Graphics@gmail.com',
'R1, concepts, and services.','oversee R1 designs, concepts, and services.',
5,15000,'2017-12-15',1,8)

insert into Jobs values('R2','A&F102','Mentor_Graphics@gmail.com',
'R2, concepts, and services.','oversee R2 designs, concepts, and services.',
2,8000,'2017-12-15',1,8)


insert into Staff_Members Values ('A',100,'A@Mentor_Graphics.com','Friday',15000.00,
							'R1','A&F102','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('A')

insert into Staff_Members Values ('B',80,'B@Mentor_Graphics.com','Saturday',8000.00,
							'R2','A&F102','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('B')

insert into Staff_Members Values ('C',90,'C@Mentor_Graphics.com','Friday',15000.00,
							'R1','A&F102','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('C')


insert into Staff_Members Values ('D',70,'D@Mentor_Graphics.com','Saturday',8000,
							'R2','A&F102','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('D')

insert into Jobs values ('R1','R&D101','Mentor_Graphics@gmail.com',
'R1','Supports R1 solving performance problems.',
1,5000,'2017-12-05',2,8)


insert into Staff_Members Values ('E',40,'E@Mentor_Graphics.com','Friday',5000,
							'R1','R&D101','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('E')



insert into Jobs values ('R2','R&D101','Mentor_Graphics@gmail.com',
'R2','Supports R2 solving performance problems.',
0,2000,'2017-12-15',2,8)

insert into Staff_Members Values ('F',45,'F@Mentor_Graphics.com','Saturday',2000,
							'R2','R&D101','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('F')

insert into Jobs values ('gadgets Manager','R&D101','Mentor_Graphics@gmail.com',
'oversee the daily activities of a team of employees who research designs, concepts, and services.','oversee the daily activities of a team of employees who research designs, concepts, and services.',
20,25000,'2017-12-15',1,8)

insert into Staff_Members Values ('G',100,'G@Mentor_Graphics.com','Friday',25000,
							'gadgets Manager','R&D101','Mentor_Graphics@gmail.com')

insert into Managers values('G', 'R&D')


insert into Staff_Members Values ('H',70,'H@Mentor_Graphics.com','Friday',5000,
							'R1','R&D101','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('H')

insert into Requests(applicant,start_date) values ('B', '2015-08-21');
insert into Requests(applicant,start_date) values ('B', '2015-08-23');
insert into Requests(applicant,start_date) values ('C', '2015-09-11');
insert into Requests(applicant,start_date) values ('D', '2015-09-21');

insert into Business_Trip_Requests(start_date,applicant) values ('2015-08-21','B')
insert into Business_Trip_Requests(start_date,applicant) values ('2015-09-11','C')
insert into Leave_Requests(start_date,applicant) values ('2015-08-23','B')
insert into Leave_Requests(start_date,applicant) values ('2015-09-21','D')



---------------------------------------------------------------------------------------------------------------------------------------
insert into Jobs values ('R1','IT702','Mentor_Graphics@gmail.com',
'Implements R1','Supports R1 solving performance problems.',
5,7000.00,'2017-12-05',3,8)


insert into Jobs values ('R2','IT702','Mentor_Graphics@gmail.com',
'Implements R2','Supports R2 solving performance problems.',
0,2000,'2017-12-05',2,8)

insert into Staff_Members Values ('I',70,'I@Mentor_Graphics.com','Friday',2000,
							'R2','IT702','Mentor_Graphics@gmail.com')

insert into Regular_Employees values('I')



insert into Staff_Members Values ('J',45,'J@Mentor_Graphics.com','Saturday',7000,
							'R1','IT702','Mentor_Graphics@gmail.com')

insert into Regular_Employees values ('J')


insert into Jobs values ('Main Director','IT702','Mentor_Graphics@gmail.com',
'Implements Main','Supports Main; solving performance problems.',
25,20000,'2017-12-25',1,8)

insert into Staff_Members Values ('K',90,'K@Mentor_Graphics.com','Friday',20000,
							'Main Director','IT702','Mentor_Graphics@gmail.com')

insert into Managers values ('K','IT')



insert into Staff_Members Values ('L',45,'L@Mentor_Graphics.com','Sunday',2000,
							'R2','IT702','Mentor_Graphics@gmail.com')

insert into Regular_Employees values ('L')

insert into Users(username,birth_date,first_name,middle_name,last_name) values('x.x','1990-09-09','x','x','x')
insert into Users(username,birth_date,first_name,middle_name,last_name) values('y.y','1990-09-09','y','y','y')
insert into Users(username,birth_date,first_name,middle_name,last_name) values('z.z','1990-09-09','z','z','z')
insert into Job_Seekers values('x.x')
insert into Job_Seekers values('z.z')
insert into Job_Seekers values('y.y')
insert into Jobs_Applied_by_Job_Seekers values('R1','A&F102','Mentor_Graphics@gmail.com','x.x',1,null,50)
insert into Jobs_Applied_by_Job_Seekers values('R1','A&F102','Mentor_Graphics@gmail.com','y.y',1,null,90)
insert into Jobs_Applied_by_Job_Seekers values('R1','A&F102','Mentor_Graphics@gmail.com','z.z',0,null,30)


----------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------------------------------------------------

--EXTRA DUE TO MAIL SENT BEFORE DEADLINE 

INSERT INTO Companies VALUES ('Robusta@gmail.com','Robusta','Cairo,Egypt','Robusta.com','national','Creativity','Web development');

	INSERT INTO Departments VALUES ('WB108','Robusta@gmail.com','Web Backend');

		INSERT INTO Jobs VALUES('Regular Employee - PHP Developer','WB108','Robusta@gmail.com','Backend development, using PHP.','Does stuff in the backend using PHP, for sure not using a MSSQL database so do not worry',
		2,15000,'2017-12-15',3,7);
	INSERT INTO Departments VALUES ('WF101','Robusta@gmail.com','Web Frontend');
