DROP DATABASE IF EXISTS stockAppFinal;

CREATE DATABASE stockAppFinal;

use stockAppFinal;

CREATE TABLE Manager
(UserId CHAR(20),
Password CHAR(15),
Name 		CHAR(50),
Phone 		CHAR(12),
Email 		CHAR(60),
Portfolio_Managed 	INTEGER,
PRIMARY KEY	(UserId),
UNIQUE 			(Phone, Email));

CREATE TABLE Creditor
(	InstitutionId 	CHAR(30),
Amount_Issued			FLOAT,
Institution 			CHAR(50),
Approved 					BOOLEAN,
PRIMARY KEY				(InstitutionId));

CREATE TABLE Customer
(UserId 				CHAR(20),
Password 				CHAR(15),
Name 						CHAR(50),
Phone 					CHAR(12),
Email 					CHAR(60),
FICO_Score 			INTEGER,
InstitutionId 	CHAR(30),
PRIMARY KEY	(UserId),
UNIQUE 			(Phone),
UNIQUE (Email),
FOREIGN KEY	(InstitutionId) REFERENCES Creditor(InstitutionId)
	ON DELETE SET NULL);

CREATE TABLE Portfolio_R1
( Pid 			INTEGER,
Dates 			DATE,
Balance 		FLOAT,
Since 			DATE,
ManagerId 	CHAR(20),
PRIMARY KEY	(Pid),
FOREIGN KEY (ManagerId) REFERENCES Manager(UserId)
	ON DELETE SET NULL);

CREATE TABLE Portfolio_R2
( Pid 			INTEGER,
CustomerId 	CHAR(20),
PRIMARY KEY	(Pid, CustomerId),
FOREIGN KEY	(CustomerId) REFERENCES Customer(UserId)
	ON DELETE CASCADE);


CREATE TABLE Leverage_R1
(	Safety_Margin 	INTEGER,
Interest_Rate 		FLOAT,
PRIMARY KEY (Safety_Margin));

CREATE TABLE Leverage_R2
(	CreditId 		INTEGER,
InstitutionId CHAR(30),
UserId 				CHAR(20),
Amount 				INTEGER,
Safety_Margin INTEGER,
Approved 			BOOLEAN,
PRIMARY KEY (CreditId, InstitutionId, UserId),
FOREIGN KEY (InstitutionId) REFERENCES Creditor(InstitutionId)
	ON DELETE CASCADE,
FOREIGN KEY (UserId) REFERENCES Customer(UserId)
	ON DELETE CASCADE);

CREATE TABLE Company
( Name			CHAR(50)	NOT NULL,
Industry		CHAR(70)	NOT NULL,
Shares_Outstanding 	INTEGER,
Market_Cap 					INTEGER,
PRIMARY KEY 	(Name, Industry),
UNIQUE 				(Name));

CREATE TABLE Stocks_R1
(	Report_Id	INTEGER,
EPS		FLOAT,
Dates	DATE,
ROI		FLOAT,
PE_Ratio	FLOAT,
PRIMARY KEY	(Report_Id));

CREATE TABLE Stocks_R3
( Name				CHAR(50),
Industry		CHAR(70),
Trade_Index CHAR(15),
PRIMARY KEY (Name, Industry),
FOREIGN KEY (Name, Industry) REFERENCES Company(Name, Industry)
		ON DELETE CASCADE);

CREATE TABLE Stocks_R4
( Ticker	CHAR(4),
Price			FLOAT,
Industry	CHAR(70),
Name			CHAR(50),
Report_id	INTEGER,
PRIMARY KEY	(Ticker),
FOREIGN KEY	(Name, Industry) REFERENCES Company(Name, Industry));

CREATE TABLE Stocks_R5
( Price		FLOAT,
EPS				FLOAT,
PE_Ratio	FLOAT,
PRIMARY KEY	(Price, EPS));

CREATE TABLE Contains
( Pid			INTEGER,
UserId		CHAR(20),
Ticker		CHAR(4),
PRIMARY KEY	(Pid, UserId, Ticker),
FOREIGN KEY (Pid, UserId) REFERENCES Portfolio_R2(Pid, CustomerId)
	ON DELETE CASCADE,
FOREIGN KEY	(UserId) REFERENCES Customer(UserId)
	ON DELETE CASCADE,
FOREIGN KEY (Ticker) REFERENCES Stocks_R4(Ticker)
	ON DELETE CASCADE);

CREATE TABLE Dividends_R1
( T_id		 		 INTEGER,
	Ticker  		 CHAR(4),
Dividend_Yield FLOAT,
PRIMARY KEY	(T_id),
FOREIGN KEY (Ticker) REFERENCES Stocks_R4(Ticker)
	ON DELETE CASCADE);

CREATE TABLE Dividends_R2
(	T_id 		INTEGER,
Pid		 		INTEGER,
UserId 		CHAR(20),
Ticker		CHAR(4),
PRIMARY KEY (T_id, Pid, UserId, Ticker),
FOREIGN KEY (Pid) REFERENCES Portfolio_R1(Pid)
	ON DELETE CASCADE,
FOREIGN KEY (UserId) REFERENCES Customer(UserId)
	ON DELETE CASCADE,
FOREIGN KEY (Ticker) REFERENCES Stocks_R4(Ticker)
	ON DELETE CASCADE);

	INSERT INTO Company VALUES("salesforce.com inc.", "Software", 774,100);
	INSERT INTO Company VALUES("VMware Inc.", "Software", 664,92);
	INSERT INTO Company VALUES("Oracle Corporation", "Software", 174,78);
	INSERT INTO Company VALUES("Adobe Inc.", "Software", 532,87);
	INSERT INTO Company VALUES("Splunk Inc.", "Software", 324,81);
	INSERT INTO Company VALUES("ServiceNow Inc.", "Software", 357,83);
	INSERT INTO Company VALUES("Workday Inc.", "Software", 489,85);
	INSERT INTO Company VALUES("Alphabet Inc.", "Interactive Media and Services", 987,464);
	INSERT INTO Company VALUES("Red Hat Inc.", "Software", 623,143);
	INSERT INTO Company VALUES("AT&T Inc.", "Diversified Telecommunication Services", 723,143);
	INSERT INTO Company VALUES("Tesla Inc.", "Automobiles", 597,139);
	INSERT INTO Company VALUES("Aphria Inc.", "Pharmaceuticals", 762,278);
	INSERT INTO Company VALUES("Apple Inc.", "Technology Hardware", 996,589);
	INSERT INTO Company VALUES("RCI Hospitality Holdings Inc.", "Hotels", 443,92);
	INSERT INTO Company VALUES("Sprint Corporation", "Wireless Telecommunication Services", 609,178);
	INSERT INTO Company VALUES("Telus Corporation", "Diversified Telecommunication Services", 711,204);
	INSERT INTO Company VALUES("Honeywell International Inc.", "Industrial Conglomerates", 698,217);
	INSERT INTO Company VALUES("Activision Blizzard Inc.", "Entertainment", 557,345);
	INSERT INTO Company VALUES("Microsoft Corporation", "Software", 849,565);

	INSERT INTO Stocks_R1 VALUES (213, 2.38, '2018-11-12', 2.10, 55.72);
	INSERT INTO Stocks_R3 VALUES ('salesforce.com inc.', 'Software', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('CRM', 132.49, 'Software', 'salesforce.com inc.', 213);
	INSERT INTO Stocks_R5 VALUES (132.49, 2.38, 55.72);

	INSERT INTO Stocks_R1 VALUES (375, 6.31, '2018-11-12', 6.60, 25.01);
	INSERT INTO Stocks_R3 VALUES ('VMware Inc.', 'Software', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('VMW', 157.73, 'Software', 'VMware Inc.', 375);
	INSERT INTO Stocks_R5 VALUES (157.73, 6.31, 25.01);
	INSERT INTO Dividends_R1 VALUES (6392
	, 'VMW', 1.60);

	INSERT INTO Stocks_R1 VALUES (785, 3.45, '2018-11-08', 8.70, 14.68);
	INSERT INTO Stocks_R3 VALUES ('Oracle Corporation', 'Software', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('ORCL', 50.63, 'Software', 'Oracle Corporation', 785);
	INSERT INTO Stocks_R5 VALUES (50.63, 3.45, 14.68);
	INSERT INTO Dividends_R1 VALUES (5756
	, 'ORCL', 1.60);

	INSERT INTO Stocks_R1 VALUES (904, 7.7, '2018-11-11', 16.60, 31.18);
	INSERT INTO Stocks_R3 VALUES ('Adobe Inc.', 'Software', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('ADBE', 239.95, 'Software', 'Adobe Inc.', 904);
	INSERT INTO Stocks_R5 VALUES (239.95, 7.7, 31.18);

	INSERT INTO Stocks_R1 VALUES (867, 1.31, '2018-11-12', -17.50, 77.82);
	INSERT INTO Stocks_R3 VALUES ('Splunk Inc.', 'Software', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('SPLK', 101.64, 'Software', 'Splunk Inc.', 867);
	INSERT INTO Stocks_R5 VALUES (101.64, 1.31, 77.82);

	INSERT INTO Stocks_R1 VALUES (100, 2.85, '2018-11-12', -2.80, 60.62);
	INSERT INTO Stocks_R3 VALUES ('ServiceNow Inc.', 'Software', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('NOW', 172.97, 'Software', 'ServiceNow Inc.', 100);
	INSERT INTO Stocks_R5 VALUES (172.97, 2.85, 60.62);

	INSERT INTO Stocks_R1 VALUES (935, 1.12, '2018-11-09', -8.30, 122.03);
	INSERT INTO Stocks_R3 VALUES ('Workday Inc.', 'Software', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('WDAY', 136.18, 'Software', 'Workday Inc.', 935);
	INSERT INTO Stocks_R5 VALUES (136.18, 1.12, 122.03);

	INSERT INTO Stocks_R1 VALUES (925, 3.72, '2018-11-13', 15.70, 46.72);
	INSERT INTO Stocks_R3 VALUES ('Red Hat Inc.', 'Software', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('RHT', 173.82, 'Software', 'Red Hat Inc.', 925);
	INSERT INTO Stocks_R5 VALUES (173.82, 3.72, 46.72);

	INSERT INTO Stocks_R1 VALUES (488, 3.55, '2018-11-14', 5.20, 8.47);
	INSERT INTO Stocks_R3 VALUES ('AT&T Inc.', 'Diversified Telecommunication Services', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('T', 30.12, 'Diversified Telecommunication Services', 'AT&T Inc.', 488);
	INSERT INTO Stocks_R5 VALUES (30.12, 3.55, 8.47);
	INSERT INTO Dividends_R1 VALUES (4333
	, 'T', 6.60);

	INSERT INTO Stocks_R1 VALUES (160, 7.04, '2018-11-10', -4.20, 49.50);
	INSERT INTO Stocks_R3 VALUES ('Tesla Inc.', 'Automobiles', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('TSLA', 348.44, 'Automobiles', 'Tesla Inc.', 160);
	INSERT INTO Stocks_R5 VALUES (348.44, 7.04, 49.50);

	INSERT INTO Stocks_R1 VALUES (899, 0.21, '2018-11-14', -1.20, 49.27);
	INSERT INTO Stocks_R3 VALUES ('Aphria Inc.', 'Pharmaceuticals', 'TSX');
	INSERT INTO Stocks_R4 VALUES ('APHA', 10.25, 'Pharmaceuticals', 'Aphria Inc.', 899);
	INSERT INTO Stocks_R5 VALUES (10.25, 0.21, 49.27);

	INSERT INTO Stocks_R1 VALUES (408, 13.44, '2018-11-08', 18.80, 14.24);
	INSERT INTO Stocks_R3 VALUES ('Apple Inc.', 'Technology Hardware', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('AAPL', 191.41, 'Technology Hardware', 'Apple Inc.', 408);
	INSERT INTO Stocks_R5 VALUES (191.41, 13.44, 14.24);
	INSERT INTO Dividends_R1 VALUES (3382
	, 'AAPL', 1.60);

	INSERT INTO Stocks_R1 VALUES (613, 2.35, '2018-11-08', 8.40, 10.94);
	INSERT INTO Stocks_R3 VALUES ('RCI Hospitality Holdings Inc.', 'Hotels', 'NasdaqGM');
	INSERT INTO Stocks_R4 VALUES ('RICK', 25.7, 'Hotels', 'RCI Hospitality Holdings Inc.', 613);
	INSERT INTO Stocks_R5 VALUES (25.7, 2.35, 10.94);
	INSERT INTO Dividends_R1 VALUES (4388
	, 'RICK', 0.50);

	INSERT INTO Stocks_R1 VALUES (550, -0.07, '2018-11-10', 3.50, 0);
	INSERT INTO Stocks_R3 VALUES ('Sprint Corporation', 'Wireless Telecommunication Services', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('S', 6.12, 'Wireless Telecommunication Services', 'Sprint Corporation', 550);
	INSERT INTO Stocks_R5 VALUES (6.12, -0.07, 0);
	INSERT INTO Dividends_R1 VALUES (2222
	, 'S', 5.94);

	INSERT INTO Stocks_R1 VALUES (381, 2.28, '2018-11-10', 7.10, 15.35);
	INSERT INTO Stocks_R3 VALUES ('TELUS Corporation', 'Diversified Telecommunication Services', 'TSX');
	INSERT INTO Stocks_R4 VALUES ('TC', 35, 'Diversified Telecommunication Services', 'TELUS Corporation', 381);
	INSERT INTO Stocks_R5 VALUES (35, 2.28, 15.35);
	INSERT INTO Dividends_R1 VALUES (9239
	, 'TC', 4.70);

	INSERT INTO Stocks_R1 VALUES (527, 7.65, '2018-11-12', 13.10, 19.31);
	INSERT INTO Stocks_R3 VALUES ('Honeywell International Inc.', 'Industrial Conglomerates', 'NYSE');
	INSERT INTO Stocks_R4 VALUES ('HON', 147.77, 'Industrial Conglomerates', 'Honeywell International Inc.', 527);
	INSERT INTO Stocks_R5 VALUES (147.77, 7.65, 19.31);
	INSERT INTO Dividends_R1 VALUES (6588
	, 'HON', 2.20);

	INSERT INTO Stocks_R1 VALUES (885, 2.86, '2018-11-08', 7.00, 18.72);
	INSERT INTO Stocks_R3 VALUES ('Activision Blizzard Inc.', 'Entertainment', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('ATVI', 53.56, 'Entertainment', 'Activision Blizzard Inc.', 885);
	INSERT INTO Stocks_R5 VALUES (53.56, 2.86, 18.72);
	INSERT INTO Dividends_R1 VALUES (8569
	, 'ATVI', 0.70);

	INSERT INTO Stocks_R1 VALUES (492, 4.49, '2018-11-11', 13.10, 23.90);
	INSERT INTO Stocks_R3 VALUES ('Microsoft Corporation', 'Software', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('MSFT', 107.28, 'Software', 'Microsoft Corporation', 492);
	INSERT INTO Stocks_R5 VALUES (107.28, 4.49, 23.90);
	INSERT INTO Dividends_R1 VALUES (1986, 'MSFT', 1.80);

	INSERT INTO Stocks_R1 VALUES (667, 44.8, '2018-11-13', 11.50, 23.91);
	INSERT INTO Stocks_R3 VALUES ('Alphabet Inc.', 'Interactive Media and Services', 'NasdaqGS');
	INSERT INTO Stocks_R4 VALUES ('GOOG', 1071.05, 'Interactive Media and Services', 'Alphabet Inc.', 667);
	INSERT INTO Stocks_R5 VALUES (1071.05, 44.8, 11.50);

	insert into Manager values ('test1', 'test1', 'Manager Test', '4169047731', 'testemail@gmail.com', 0);
	insert into Manager values ('afortoun0', 'wI6fKJ8', 'Asia Fortoun', '1232978282', 'afortoun0@angelfire.com', 0);
	insert into Manager values ('esparrowhawk1', 'nYTw4g3L', 'Ephraim Sparrowhawk', '9163438963', 'esparrowhawk1@hp.com', 0);
	insert into Manager values ('cbartczak2', '09Iytctb', 'Clarke Bartczak', '7641666769', 'cbartczak2@paypal.com', 0);
	insert into Manager values ('lunderwood3', 'fvGUvEr', 'Lona Underwood', '2733901665', 'lunderwood3@nytimes.com', 0);
	insert into Manager values ('lcasarini4', 'ISU23uQ', 'Louisette Casarini', '9136817488', 'lcasarini4@goo.gl', 0);

	INSERT INTO Leverage_R1 VALUES (-10, 25.37);
	INSERT INTO Leverage_R1 VALUES (-9, 24.01);
	INSERT INTO Leverage_R1 VALUES (-8, 23);
	INSERT INTO Leverage_R1 VALUES (-7, 22.56);
	INSERT INTO Leverage_R1 VALUES (-6, 21.55);
	INSERT INTO Leverage_R1 VALUES (-5, 20.3);
	INSERT INTO Leverage_R1 VALUES (-4, 19.4);
	INSERT INTO Leverage_R1 VALUES (-3, 18.05);
	INSERT INTO Leverage_R1 VALUES (-2, 17.66);
	INSERT INTO Leverage_R1 VALUES (-1, 16.88);
	INSERT INTO Leverage_R1 VALUES (0, 15.9);
	INSERT INTO Leverage_R1 VALUES (1, 14.44);
	INSERT INTO Leverage_R1 VALUES (2, 13.52);
	INSERT INTO Leverage_R1 VALUES (3, 12.12);
	INSERT INTO Leverage_R1 VALUES (4, 11.99);
	INSERT INTO Leverage_R1 VALUES (5, 10.09);
	INSERT INTO Leverage_R1 VALUES (6, 9.89);
	INSERT INTO Leverage_R1 VALUES (7, 8.99);
	INSERT INTO Leverage_R1 VALUES (8, 7.01);
	INSERT INTO Leverage_R1 VALUES (9, 6.32);

insert into Customer values ('test0', 'test0', 'Cameron Lees', '4169047731', 'cameron.lees@gmail.com', 489, null);
insert into Customer values ('ltoe0', 'GGNcCFO3Kn', 'Loleta Toe', '823-380-0035', 'ltoe0@geocities.jp', 489, null);
insert into Customer values ('msyphas1', 'anKVFoh5OY', 'Manon Syphas', '327-141-4807', 'msyphas1@topsy.com', 245, null);
insert into Customer values ('gtempest2', '2jbWg4rb8', 'Gisele Tempest', '792-644-0181', 'gtempest2@moonfruit.com', 233, null);
insert into Customer values ('acotsford3', 'h4yA5ARb', 'Arden Cotsford', '130-348-8457', 'acotsford3@i2i.jp', 330, null);
insert into Customer values ('acane4', 'TEn2923h', 'Aurelie Cane', '541-875-9363', 'acane4@instagram.com', 146, null);
insert into Customer values ('dgillies5', 'MRR1Ql9eVwzH', 'Debbie Gillies', '816-167-8127', 'dgillies5@wunderground.com', 222, null);
insert into Customer values ('hhagger6', 'FNXIeOK', 'Hercule Hagger', '236-882-7188', 'hhagger6@amazon.co.uk', 364, null);
insert into Customer values ('mbarus7', 'LjpOw0', 'Marcella Barus', '511-171-4273', 'mbarus7@oracle.com', 284, null);
insert into Customer values ('acotman8', 'WkjFj7zO', 'Anselma Cotman', '712-179-9730', 'acotman8@youku.com', 307, null);
insert into Customer values ('lbushby9', 'RxDmPM7W2F8', 'Luz Bushby', '766-335-4111', 'lbushby9@archive.org', 439, null);
insert into Customer values ('lclinesa', 'Gfx3KcHp', 'Lennie Clines', '499-297-2199', 'lclinesa@theatlantic.com', 269, null);
insert into Customer values ('bsammonb', 'hSWbFzyd2', 'Baxter Sammon', '665-289-0312', 'bsammonb@nymag.com', 384, null);
insert into Customer values ('gdibbc', 'TAil1QoEa', 'Gertruda Dibb', '834-295-4898', 'gdibbc@usatoday.com', 182, null);
insert into Customer values ('ksweetd', 'uipYdWP', 'Kimble Sweet', '246-907-0752', 'ksweetd@ycombinator.com', 364, null);
insert into Customer values ('nmariae', 'JV1PtTQ1n06i', 'Noland Maria', '453-141-4539', 'nmariae@newsvine.com', 150, null);
insert into Manager values ('dkemberf', 'JVkWgxrR', 'Davina Kember', '162-536-2626', 'dkemberf@cisco.com', 320, 0);
insert into Manager values ('dleureng', 'Qh5cYmm', 'Dallas Leuren', '636-793-6384', 'dleureng@shinystat.com', 432, 0);
insert into Manager values ('ebellanyh', 'i5lIgZDMPZ', 'Elroy Bellany', '564-653-4756', 'ebellanyh@cpanel.net', 122, 0);
insert into Manager values ('geveritti', 'jk6K5iwl0', 'Gerry Everitt', '794-543-3366', 'geveritti@trellian.com', 327, 0);
insert into Manager values ('krapierj', 'mZ1urXnS', 'Karole Rapier', '319-183-5247', 'krapierj@ihg.com', 364, 0);
insert into Manager values ('sgilderoyk', 'lg0lDCd5O4N', 'Suzie Gilderoy', '248-945-5381', 'sgilderoyk@gnu.org', 135, 0);
insert into Manager values ('rrenonl', '1rOW3GCRjU6', 'Rabi Renon', '361-328-4544', 'rrenonl@noaa.gov', 403, 0);
insert into Manager values ('dosheam', 'ZhWJpLAr', 'Daryle O''Shea', '640-319-4651', 'dosheam@hatena.ne.jp', 372, 0);
insert into Manager values ('rsaurn', 'CMKQj2', 'Ruby Saur', '160-579-2502', 'rsaurn@upenn.edu', 334, 225);
insert into Manager values ('abargho', 'j063LGnTVJN', 'Alexis Bargh', '144-501-7446', 'abargho@sciencedirect.com', 428, 0);

insert into Creditor values (529, 5189, 'Crona, Feest and Tillman', null);
insert into Creditor values (622, 5167, 'Kuhn-Hahn', null);
insert into Creditor values (441, 8356, 'O''Conner, Lubowitz and Cremin', null);
insert into Creditor values (637, 5031, 'Metz, Hahn and Christiansen', null);
insert into Creditor values (343, 7421, 'Halvorson and Sons', null);
insert into Creditor values (799, 9805, 'Haag, Mraz and Eichmann', null);
insert into Creditor values (335, 6210, 'Hirthe LLC', null);
insert into Creditor values (417, 5834, 'Cronin, Okuneva and Hartmann', null);
insert into Creditor values (346, 7581, 'Kerluke-Homenick', null);
insert into Creditor values (310, 4837, 'Doyle, Predovic and Sporer', null);
insert into Creditor values (857, 5859, 'Sauer Group', null);
insert into Creditor values (398, 1577, 'Johnston and Sons', null);
insert into Creditor values (671, 5043, 'Bins, Pagac and Emard', null);
insert into Creditor values (881, 6025, 'Gutkowski-Thiel', null);
insert into Creditor values (229, 9348, 'Schinner, Jacobson and Spinka', null);
