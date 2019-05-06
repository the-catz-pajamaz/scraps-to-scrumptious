-- set the database to use utf8
alter database snelson54 character set utf8 collate utf8_unicode_ci;

-- these statements will drop the tables and re-add them
drop table if exists cookbook;
drop table if exists recipe;
drop table if exists 'user';


-- creates user entity
create table user (
	userId binary(16) not null,
	userEmail varchar(32) not null,
	userFirstName varchar(32) not null,
	userHandle varchar(32) not null,
	userHash varchar(32) not null,
	userLastName varchar(32) not null,
	primary key(userId),
);

-- creates recipe entity
create table recipe (
	recipeId binary(16) not null,
	recipeUserId binary(16) not null,
	recipeDescription varchar(32) not null,
	recipeIngredients varchar(32) not null,
	recipeMedia varchar(32) not null,
	recipeSteps varchar(32) not null,
	recipeTitle varchar(32) not null,
	primary key(recipeId),
	foreign key(recipeUserId) references user(userId),
	index(recipeUserId)
);

-- creates cookbook entity
create table cookbook (
	cookbookRecipeId varchar(32) not null,
	cookbookUserId varchar(32) not null,
	foreign key(cookbookRecipeId) references recipe(recipeId),
	foreign key(cookbookUserId) references user(userId),
	index(cookbookRecipeId),
	index(cookbookUserId)
);

