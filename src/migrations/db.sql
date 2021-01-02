CREATE TABLE `students` (`id` int, `name` varchar(255));

alter table students
    add constraint students_pk
        primary key (`id`);

create table grades
(
    id int auto_increment,
    student_id int not null,
    value ENUM('5', '6', '7', '8', '9', '10') not null,
    constraint grades_pk
        primary key (`id`)
);

create index grades_student_id_index
	on grades (`student_id`);

alter table grades
    add constraint grades_student_id_fk
        foreign key (`student_id`) references students (`id`)
            on update cascade on delete cascade;

create table school_boards
(
    id int auto_increment,
    name varchar(255) not null,
    passing_average int not null,
    return_format varchar(10) not null,
    constraint school_boards_pk
        primary key (id)
);

alter table students
    add `board_id` int not null;

alter table students
    add constraint students_school_boards_id_fk
        foreign key (`board_id`) references school_boards (`id`);

alter table school_boards
    add discard_lowest bool default false null;
