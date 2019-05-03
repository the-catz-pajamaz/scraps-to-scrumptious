-- set the database to use utf8
alter database snelson54 character set utf8 collate utf8_unicode_ci;

-- these statements will drop the tables and re-add them
drop table if exists user;
drop table if exists recipe;
drop table if exists cookbook;
drop table if exists cookbookRecipe;



-- creates user entity
create table user (
	userId binary(16) not null,
	userEmail varchar(32) not null,
	userHandle varchar(32) not null,
	userHash varchar(32) not null,
	userFirstName varchar(32) not null,
	user varchar(32) not null,
	primary key(userId),
	index(userId)
);
