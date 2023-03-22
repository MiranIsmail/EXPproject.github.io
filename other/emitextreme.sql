create database systemteknik;
use systemteknik;

DELIMITER //
create procedure create_all()
begin
	Create table Users(
		mail varchar(255) Primary Key not null,
		token varchar(255),
		first_name varchar(255) not null,
		last_name varchar(255) not null,
		organization varchar(255),
		height int,
		weight int,
		age int,
		equipment varchar(255),
        password varchar(255) not null);

    Create table Chip(
		chip_id int Primary key not null,
        team_name varchar(255) not null,
        mail1 varchar(255) not null,
        mail2 varchar(255),
        foreign key (mail1) References Users(mail),
        foreign key (mail2) References Users(mail));

	Create table Track(
		track_id int primary key not null auto_increment,
        track_name varchar(255) not null,
        start_station int not null,
        end_station int not null
    );

    Create table Checkpoint(
		station_id int primary key not null,
        previouse_id int not null,
        previouse_distance int not null,
        section varchar(255) not null,
        track_id int not null,
        foreign key (track_id) references Track(track_id)
    );

	Create table Competition(
		event_id int primary key not null auto_increment,
        event_name varchar(255) not null,
		track_id int not null,
		host_mail varchar(255) not null,
        host_organization varchar(255) not null,
		sport varchar(255) not null,
        start_date date not null,
        end_date date not null,
        module_id int not null,
        open_for_entry bool not null default 0,
        public_view bool not null default 0,
        foreign key (track_id) References Track(track_id),
        foreign key (host_mail) References Users(mail)
    );

    Create table Registration(
		event_id int not null auto_increment,
        chip_id int not null,
        primary key (event_id,chip_id),
        foreign key (event_id) references Competition(event_id),
        foreign key (chip_id) references Chip(chip_id)
        );

    Create table Result(
        id int not null
		track_time varchar(255) not null,
        participant1 varchar(255) not null,
        participant2 varchar(255),
        event_id int not null,
        current_time DATETIME,
        primary key (id),
        foreign key (event_id) references Competition(event_id),
        foreign key (participant1) References Users(mail),
        foreign key (participant2) References Users(mail)
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
insert into Users  values ("Amin@afzali.com","dsfsagsrg","Amin","Afzali",null,172,45,10,"d","password");
insert into Users (`first_name`,`last_name`,`mail`,`password`) values ("f","l","m","p");
show tables;

