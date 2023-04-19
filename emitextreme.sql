create database demo;
use demo;

DELIMITER //
create procedure create_all()
begin
	Create table Users(
        username varchar(255) Primary Key not null
		email varchar(255) not null,
		token varchar(255) unique,
		first_name varchar(255) not null,
		last_name varchar(255) not null,
		organization varchar(255),
		height int,
		weight int,
		birthdate date,
        pimage varchar(255),
        equipment varchar(255),
        token_date timestamp default current_timestamp(),
        public boolean not null default 1,
        password varchar(255) not null);

    Create table Organization(
        description varchar(255) not null,
        pimage mediumblob not null,
        password varchar(255) not null,
        country varchar(255) not null,
        email varchar(255) not null,
        token varchar(255) unique,
        org_name varchar(255) Primary key not null,
    )
    Create table Chip(
		chip_id int Primary key not null,
        team_name varchar(255) not null,
        user1 varchar(255) not null,
        user2 varchar(255),
        foreign key (user1) References Users(username),
        foreign key (user2) References Users(username));

	Create table Track(
        track_name varchar(255) Primary key not null,
        start_station int not null,
        end_station int not null
    );

    Create table Checkpoint(
		station_id int primary key not null,
        next_id int,
        next_distance int,
        terrain varchar(255) not null,
        track_name varchar(255) not null,
        coordinates varchar(255) not null,
        foreign key (track_name) references Track(track_name)
    );

	Create table Competition(
		event_id int primary key not null auto_increment,
        event_name varchar(255) not null,
		track_name varchar(255) not null,
		username varchar(255) not null,
        host_organisation varchar(255),
		sport varchar(255),
        startdate date not null,
        enddate date not null,
        open_for_entry bool not null default 0,
        public_view bool not null default 0,
        foreign key (track_name) References Track(track_name),
        foreign key (username) References Users(username)
    );

    Create table Registration(
		event_id int not null auto_increment,
        chip_id int not null,
        primary key (event_id,chip_id),
        foreign key (event_id) references Event(event_id),
        foreign key (chip_id) references Chip(chip_id)
        );

    Create table Result(
        result_id int primary key not null auto_increment,
		track_time varchar(255) not null,
        user1 varchar(255) not null,
        user2 varchar(255),
        event_id int not null,
        date_time timestamp default current_timestamp(),
        total_time time not null,
        foreign key (event_id) references Event(event_id),
        foreign key (user1) References Users(username),
        foreign key (user2) References Users(username)
    );

end; // DELIMITER ;

DELIMITER //
create procedure drop_all()
begin
	drop table Result;
    drop table Registration;
    drop table Competition;
    drop table Checkpoint;
    drop table Track;
    drop table Chip;
	drop table Users;
end; // DELIMITER ;





drop table Result;
drop table Competition;
drop table Checkpoint;
drop table Track;
drop table Registration;
drop table Chip;
drop table Users;

delete from competition where event_id= 4;

call create_all();
call drop_all();

drop procedure drop_all;
drop procedure create_all;

select * from Users;
select * from Competition;
select * from Chip;
select * from Registration;
select * from Track;
select * from Checkpoint;
select * from Result;

insert into Track (`track_name`,`start_station`,`end_station`) Values('track',1,2);
insert into Users  values ("Amin@afzali.com","dsfsagsrg","Amin","Afzali",null,172,45,10,"d","password");
insert into Users (`first_name`,`last_name`,`email`,`password`) values ("f","l","m","p");
insert into Users (`first_name`,`last_name`,`password`,`email`,`token`) values ('amin','dsf','40bd001563085fc35165329ea1ff5c5ecbdbbeef','amin@afzali','7e9749e6827d03753bd38f932d4c1d43a9c3b2a6');
update Users set token = 'd6152c47fc6908a118d9fafbc5a6a5c546eeacff' where token = '8d57022280d5df7ba5e565107514487732b7696e' ;
delete from users where mail LIKE 'Amin@afzali.com';
select * from users where mail LIKE 'a@a2';
select email from users where token like 'eb18fb7faa62b1d7f24c82b283056356ccfc847b';
insert into competition (`event_name`,`track_id`,`host_email`,`host_organization`,`sport`,`start_date`,`end_date`,`module_id`) values ('test','1','a@a2','gangsterAB','Runing','2023-01-15','2024-06-15','1');
select * from competition where `host_email` like '%a%';
insert into result (`track_time`,`event_id`,`participant1`,`current_time`) values('12s','6','a@a2','2023-02-19 15:09:56');
show tables;

