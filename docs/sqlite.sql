DROP TABLE IF EXISTS address1;
CREATE TABLE address1 (
  address_id INTEGER PRIMARY KEY AUTOINCREMENT,
  person_fid INTEGER,
  street TEXT,
  zip INTEGER,
  city TEXT
);

DROP TABLE IF EXISTS person1;
CREATE TABLE person1 (
  person_id INTEGER PRIMARY KEY AUTOINCREMENT,
  full_name TEXT,
  age INTEGER
);

DROP TABLE IF EXISTS address2;
CREATE TABLE address2 (
  address_id INTEGER PRIMARY KEY AUTOINCREMENT,
  person_firstname TEXT,
  person_lastname TEXT,
  street TEXT,
  zip INTEGER,
  city TEXT
);

DROP TABLE IF EXISTS person2;
CREATE TABLE person2 (
  person_id INTEGER PRIMARY KEY AUTOINCREMENT,
  firstname TEXT,
  lastname TEXT,
  age INTEGER
);

DROP TABLE IF EXISTS address3;
CREATE TABLE address3 (
  address_id INTEGER PRIMARY KEY AUTOINCREMENT,
  street TEXT,
  zip INTEGER,
  city TEXT
);

DROP TABLE IF EXISTS person3;
CREATE TABLE person3 (
  person_id INTEGER PRIMARY KEY AUTOINCREMENT,
  full_name TEXT,
  age INTEGER
);

DROP TABLE IF EXISTS person3_address3;
CREATE TABLE person3_address3 (
  person_fid INTEGER,
  address_fid INTEGER
);