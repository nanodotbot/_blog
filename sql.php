// sqlite

CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    mail TEXT UNIQUE,
    password TEXT NOT NULL,
    description TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userid INTEGER NOT NULL,
    message TEXT,
    picture TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    userid INTEGER NOT NULL,
    postid INTEGER NOT NULL,
    message TEXT,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (postid) REFERENCES posts (id) ON DELETE CASCADE
);


PRAGMA foreign_keys = ON;

// mysql

CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    description text,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY(id),
    UNIQUE(username)
);
CREATE TABLE posts (
    id int NOT NULL AUTO_INCREMENT,
    userid int NOT NULL,
    message text,
    message picture,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY(id),
    FOREIGN KEY(userid) REFERENCES users(id) ON DELETE CASCADE
);
CREATE TABLE comments (
    id int NOT NULL AUTO_INCREMENT,
    userid int NOT NULL,
    postid int NOT NULL,
    message text NOT NULL,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP(),
    PRIMARY KEY(id),
    FOREIGN KEY(userid) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(postid) REFERENCES posts(id) ON DELETE CASCADE
);
