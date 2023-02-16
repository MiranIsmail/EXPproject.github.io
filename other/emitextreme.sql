create database systemteknik;
use systemteknik;

DELIMITER //
create procedure create_all()
begin
	Create table Users(
		mail varchar(255) Primary Key not null,
		token varchar(255),
		firstName varchar(255) not null,
		lastName varchar(255) not null,
		organization varchar(255),
		height int,
		weight int,
		age int,
		equipment varchar(255),
        password varchar(255) not null);

    Create table Chip(
		chipId int Primary key not null,
        teamName varchar(255) not null,
        mail1 varchar(255) not null,
        mail2 varchar(255),
        foreign key (mail1) References Users(mail),
        foreign key (mail2) References Users(mail));

	Create table Track(
		trackId int primary key not null auto_increment,
        trackName varchar(255) not null,
        startStation int not null,
        endStation int not null
    );

    Create table Checkpoint(
		stationId int primary key not null,
        previousId int not null,
        previousDistance int not null,
        section varchar(255) not null,
        trackId int not null,
        foreign key (trackId) references Track(trackId)
    );

	Create table Competition(
		eventId int primary key not null auto_increment,
        eventName varchar(255) not null,
		trackId int not null,
		hostMail varchar(255) not null,
        hostOrganization varchar(255) not null,
		sport varchar(255) not null,
        startDate date not null,
        endDate date not null,
        moduleId int not null,
        openForEntry bool not null default 0,
        publicView bool not null default 0,
        foreign key (trackId) References Track(trackId),
        foreign key (hostMail) References Users(mail)
    );

    Create table Registration(
		eventId int not null auto_increment,
        chipId int not null,
        primary key (eventId,chipId),
        foreign key (eventId) references Competition(eventId),
        foreign key (chipId) references Chip(chipId)
        );

    Create table Result(
		trackTime varchar(255) not null,
        participant1 varchar(255) not null,
        participant2 varchar(255),
        eventId int not null,
        currentTime DATETIME,
        primary key (participant1,currentTime),
        foreign key (eventId) references Competition(eventId),
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

show tables;

