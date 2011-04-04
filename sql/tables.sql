create table Itype
(      Item_type   varchar(10)  not null,
       primary key(Item_type)
);



create table Brands
(      Brand       varchar(10)  not null,
       primary key(Brand)
);



create table Item
(      Item_name  varchar(10)   not null,
       Brand      varchar(10)   not null,
       quant      int(4)        not null,
       primary key(item_no),
       foreign key(Item_type) references Itype(item_type),
       foreign key(Brand) references Brands(Brand)
)Engine = INNODB;



create table User
(      fname     varchar(20)    not null,
       lname     varchar(20)    not null,
       uname     varchar(20)    not null,
       pass      char(40)       not null,
       bool      numeric(1)     not null,
       primary key(uname),
       check(bool = '0' or bool = '1')
)Engine = INNODB;



create table Orders
(       Order_id   varchar(10)  not null,
        Item_name  varchar(10)  not null,
        Dates      Date         not null,
        Quant      int(4)       not null,
        primary key(Order_id),
        primary key(Item_name),
        foreign key(Item_name) references Item(Item_name)
)ENGINE = INNODB;

