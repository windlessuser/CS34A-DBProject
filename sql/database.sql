create table IF NOT EXISTS   UsersInfo (	    
                username 		varchar(15)	   not null,
                password		char(40) 	   not null,
                first_name 	varchar(10)	   not null,
		last_name		varchar(10)	    not null,
		email			varchar(30)	    not null,
		is_admin		boolean	     not null,
		joined		timestamp
		primary key(username)
);

create table IF NOT EXIST UserLog (
                username       varchar(15) not null,
                password       char(40)    not null,
                is_admin        boolean     not null,
                primary key(username),
                foreign key(username) references UsersInfo(username),
                foreign key(password) references UsersInfo(password),
                foreign key(is_admin) references UsersInfo(is_admin)
);

create table IF NOT EXIST UserContact (
                contactid           int(5)             not null,
                first_name 	varchar(10)	   not null,
		last_name		varchar(10)	    not null,
		email			varchar(30)	    not null,
		joined		timestamp	     not null,
               primary key (contactid),
                foreign key(first_name) references UsersInfo(first_name),
                foreign key(last_name) references UsersInfo(last_name),
                foreign key(email) references UsersInfo(email),
                foreign key(joined) references UsersInfo(joined)
);

create table IF NOT EXISTS Brands (
		brand           varchar(10)     not null,
		primary key (brand)
);

create table IF NOT EXISTS Categories (
		category	varchar(10) not null,
		primary key(category)
);
					
create table IF NOT EXISTS Inventory	(
		barcode 	    int(10)	        not null    auto_increment,
		name	    varchar(10)	not null,
		quantity	    integer(10)     not null,
		price		    decimal(10)   not null,
		brand	    varchar(10)    not null,
		category	    varchar(10)	not null,
		total_sold	    integer(10),
		image	    varchar(10),
		i_size	    varchar(10),
		i_colour	    varchar(10),
		description	text,
		added	    timestamp,
		primary key(barcode),
		foreign key(brand) references Brands(brand),
		foreign key(category) references Categories(category)
);

create table IF NOT EXISTS ItemInfo	(
		barcode 	    int(10)	        not null    auto_increment,
		name	    varchar(10)	not null,
		quantity	    integer(10)     not null,
		price		    decimal(10)   not null,
		brand	    varchar(10)    not null,
		category	    varchar(10)	not null,
		image	    varchar(10),
		primary key(barcode),
		foreign key(barcode) references Inventory(barcode),
		foreign key(name) references Inventory(name)
		foreign key(quantity) references Inventory(quantity),
		foreign key(price) references Inventory(price)
		foreign key(brand) references Brands(brand),
		foreign key(category) references Categories(category)
		foreign key(image) references Inventory(image)
);

create table IF NOT EXISTS SalesInventory	(
		barcode 	    int(10)	        not null    auto_increment,
		name	    varchar(10)	not null,
		quantity	    integer(10)     not null
		total_sold	    integer(10),
		i_size	    varchar(10),
		i_colour	    varchar(10),
		primary key(barcode),
		foreign key(barcode) references Inventory(barcode)		
                foreign key(name) references Inventory(name),
		foreign key(quantity) references Inventory(quantity),
		foreign key(total_sold) references Inventory(total_sold),
		foreign key(i_size) references Inventory(i_size),
		foreign key(i_colour) references Inventory(i_colour),

);
			
create table IF NOT EXISTS	Orders	(
		order_id	integer(6)	not null auto_increment,
		barcode	bigint(10)	not null,
		username	varchar(10) not null,
		quantity	integer(10) not null,
		sub_total	decimal(10) not null,
		o_date	timestamp	not null,
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