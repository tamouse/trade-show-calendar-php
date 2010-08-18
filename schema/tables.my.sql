#
# MySQL CDMA Calendar table creation script
#
# Notes:
# (1) If you have decided to change the prefix of your tables from 'cdma_'
# to something else using $db_tbl_prefix then you must edit each
# 'CREATE TABLE' and 'INSERT INTO' line below to replace 'cdma_' with
# your new table prefix.
# (2) If you change the varchar lengths here, then you should check
# to see whether a corresponding length has been defined in the config file
# in the array $maxlength.

DROP TABLE IF EXISTS cdma_event;
CREATE TABLE cdma_event
(
	id				int NOT NULL auto_increment,
	event_name			varchar(100),
	location		varchar(250),
	event_admin_email	varchar(50),
	event_description		text,
	
	PRIMARY KEY (ID)
);

DROP TABLE IF EXISTS cdma_day;
CREATE TABLE cdma_day
(
	id				int NOT NULL auto_increment,
	event_id		int NOT NULL,
	day_string		varchar(10) NOT NULL,
	day				int NOT NULL,
	month			int NOT NULL,
	year			int NOT NULL,
	
	PRIMARY KEY (ID)
);

DROP TABLE IF EXISTS cdma_room;
CREATE TABLE cdma_room
(
  id               int NOT NULL auto_increment,
  event_id		   int NOT NULL,
  room_number	   int NOT NULL,
  room_name        varchar(25) DEFAULT '' NOT NULL,
  room_description      text,

  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS cdma_entry;
CREATE TABLE cdma_entry
(
  id          int NOT NULL auto_increment,
  event_id    int NOT NULL,
  day_id	  int NOT NULL,
  room_id     int NOT NULL,
  start_hour  int NOT NULL,
  start_minute int NOT NULL,
  end_hour    int NOT NULL,
  end_minute  int NOT NULL,
  user_id     int NOT NULL,
  purpose     varchar(80),
  comments    text,
  confirmed   tinyint NOT NULL DEFAULT 1,
  guests      text,
  guest_emails text,

  PRIMARY KEY (id),
  KEY idxStartHour (start_hour),
  KEY idxStartMinute (start_minute),
  KEY idxEndHour   (end_hour),
  KEY idxEndMinute (end_minute)
);


DROP TABLE IF EXISTS cdma_variables;
CREATE TABLE cdma_variables
(
  id               int NOT NULL auto_increment,
  variable_name    varchar(80),
  variable_content text,
      
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS cdma_users;
CREATE TABLE cdma_users
(
  /* The first four fields are required. Don't remove. */
  id        int NOT NULL auto_increment,
  level     smallint DEFAULT '0' NOT NULL,  /* play safe and give no rights */
  name      varchar(30),
  first_name	varchar(30),
  last_name		varchar(30),
  password  varchar(40),
  phone		varchar(20),
  email     varchar(75),
  comments  text,

  PRIMARY KEY (id)
);

INSERT INTO cdma_variables (variable_name, variable_content)
  VALUES ( 'db_version', '1');
INSERT INTO cdma_variables (variable_name, variable_content)
  VALUES ( 'local_db_version', '1');
