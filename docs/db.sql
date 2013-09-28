#
# SQLite notes table
#

drop table note; drop table tag; drop table note_tag;

create table main.note(
    id integer PRIMARY KEY AUTOINCREMENT,
    title varchar(128) null,
    content text,
    active tinyint(1) default 0,
    insert_time datetime,
    update_time datetime
);

create table main.tag(
    id integer PRIMARY KEY AUTOINCREMENT,
    name varchar(32)
);

create table main.note_tag(
    id integer PRIMARY KEY AUTOINCREMENT,
    note_id integer,
    tag_id integer,
    FOREIGN KEY(note_id) REFERENCES note(id),
    FOREIGN KEY(tag_id) REFERENCES tag(id)
);