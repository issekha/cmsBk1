create database if not exists cmsbk1 character set utf8 collate utf8_unicode_ci;
use cmsbk1;

grant all privileges on cmsbk1.* to 'cmsbk1_user'@'localhost' identified by 'secret';