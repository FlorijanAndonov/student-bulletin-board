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