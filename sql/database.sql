create table IF NOT EXISTS   Users(
        username 		varchar(15)	   not null,
        first_name 		varchar(10)	   not null,
		last_name		varchar(10)	   not null,
		email			varchar(30)	   not null,
		pass            char(40)       not null,
		is_admin		boolean	       not null,
		joined			timestamp,
		primary key(username)
);

create table IF NOT EXISTS Brands (
		brand           varchar(30)     not null,
		primary key (brand)
);

create table IF NOT EXISTS Categories (
		category	varchar(30) not null,
		primary key(category)
);

create table IF NOT EXISTS Inventory	(
		barcode 	   bigint(10)	        not null    auto_increment,
		name	    varchar(10)	not null,
		quantity	    integer(10)     not null,
		price		    decimal(10)   not null,
		brand	    varchar(30)    not null,
		category	    varchar(30)	not null,
		image	    varchar(20),
		i_size	    varchar(10),
		i_colour	    varchar(10),
		description	text,
		primary key(barcode),
		foreign key(brand) references Brands(brand),
		foreign key(category) references Categories(category)
);


create table IF NOT EXISTS	Orders	(
		order_id	integer(6)	not null auto_increment,
		barcode	    bigint(10)	        not null,
		username	varchar(10)     not null,
		quantity	integer(10)     not null,
		o_date	timestamp	        not null,
		primary key(order_id),
		foreign key(barcode) references Inventory(barcode),
		foreign key(username) references Users(username)
);

create table IF NOT EXISTS	Rss	(
		id 			int(11) 	not null auto_increment,
		title 		varchar(120) not null,
	    description	text,
		r_date		timestamp,
		primary key(id)
);