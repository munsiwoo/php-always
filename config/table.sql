CREATE TABLE mun_users(username varchar, password varchar, register_date datetime, primary key(username));
CREATE TABLE mun_board(no integer primary key, title varchar, contents varchar, username varchar, date datetime);

