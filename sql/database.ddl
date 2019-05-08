-- set the database to use utf8
alter database snelson54 character set utf8 collate utf8_unicode_ci;

-- these statements will drop the tables and re-add them
drop table if exists cookbook;
drop table if exists recipe;
drop table if exists user;



-- creates user entity
create table user (
	userId binary(16) not null,
	userActivationToken char(32),
	userEmail varchar(128) not null unique,
	userFirstName varchar(32) not null,
	userHandle varchar(64) not null unique,
	userHash char(97) not null,
	userLastName varchar(32) not null,
	index(userEmail),
	primary key(userId)
);

-- creates recipe entity
create table recipe (
	recipeId binary(16) not null,
	recipeUserId binary(16) not null,
	recipeDescription blob,
	recipeIngredients blob,
	recipeMedia varchar(255),
	recipeSteps blob,
	recipeTitle varchar(128) not null,
	index(recipeUserId),
	primary key(recipeId),
	foreign key(recipeUserId) references user(userId)
);

-- creates cookbook entity
create table cookbook (
	cookbookRecipeId binary(16) not null,
	cookbookUserId binary(16) not null,
	index(cookbookRecipeId),
	index(cookbookUserId),
	primary key(cookbookRecipeId, cookbookUserId),
	foreign key(cookbookRecipeId) references recipe(recipeId),
	foreign key(cookbookUserId) references user(userId)
);

