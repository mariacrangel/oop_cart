SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

CREATE DATABASE IF NOT EXISTS task4  DEFAULT CHARACTER SET utf8 ;

use task4;

DROP TABLE IF EXISTS currency;

CREATE TABLE IF NOT EXISTS currency (
        ccode varchar(3) NOT NULL,
        cname varchar(25) NOT NULL,
        symbol varchar(2) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (ccode)
);

DROP TABLE IF EXISTS user;

CREATE TABLE IF NOT EXISTS user (
        uemail varchar(250) NOT NULL,
        uname varchar(250) NOT NULL,
        ulastname varchar(250),
        upassword text NOT NULL,
        uisactive boolean,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (uemail)        
);

DROP TABLE IF EXISTS shipping;

CREATE TABLE IF NOT EXISTS shipping (
        semail varchar(250) NOT NULL,
        saddress text NOT NULL,
        scompany varchar(250) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (semail),
        FOREIGN KEY (semail) REFERENCES user(uemail)
);

DROP TABLE IF EXISTS balance;

CREATE TABLE IF NOT EXISTS balance (
        bcurrencycode varchar(3) NOT NULL,
        bemail varchar(250) NOT NULL,
        btotal decimal( 10, 2 ) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (bemail),
        FOREIGN KEY (bemail) REFERENCES user(uemail),
        FOREIGN KEY (bcurrencycode) REFERENCES currency(ccode)
);

DROP TABLE IF EXISTS product;

CREATE TABLE IF NOT EXISTS product (
        pid int(11) NOT NULL AUTO_INCREMENT,
        pname varchar(250) NOT NULL,
        pdescription text NOT NULL,
        punit varchar(30) NOT NULL,
        psellprice decimal(10,2) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (pid)
);

DROP TABLE IF EXISTS photo;

CREATE TABLE IF NOT EXISTS photo (
        phid int(11) NOT NULL AUTO_INCREMENT,
        pid int(11) NOT NULL,
        phname varchar(250) NOT NULL,
        phslug varchar(250) NOT NULL,
        phtype varchar(30) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (phid),
        FOREIGN KEY (pid) REFERENCES product(pid)
);

DROP TABLE IF EXISTS rate;

CREATE TABLE IF NOT EXISTS rate (
        rid int(11) NOT NULL AUTO_INCREMENT,
        pid int(11) NOT NULL,
        rpoints int(11) NOT NULL,
        rcomments text NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (rid,pid),
        FOREIGN KEY (pid) REFERENCES product(pid)
);
DROP TABLE IF EXISTS orders;

CREATE TABLE IF NOT EXISTS orders (
        id int(11) NOT NULL AUTO_INCREMENT,
        oemail varchar(250) NOT NULL,
        ototal decimal(10,2) NOT NULL,
        odelivery boolean NOT NULL,
        shippingcost decimal(10,2) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (id),
        FOREIGN KEY (oemail) REFERENCES user(uemail)
);

DROP TABLE IF EXISTS item;

CREATE TABLE IF NOT EXISTS item (
        orderid int(11) NOT NULL,
        pid int(11) NOT NULL,
        iquantity int(11) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (orderid, pid),
        FOREIGN KEY (orderid) REFERENCES orders(id),
        FOREIGN KEY (pid) REFERENCES product(pid)
);
        