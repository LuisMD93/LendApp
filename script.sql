create database lend_app;

use lend_app;

drop table  if exists users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    api_token VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,

    creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modificationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

drop procedure  if exists add_user;
Delimiter //
create procedure add_user(in p_user_name_ VARCHAR(45) ,in p_email_ VARCHAR(45) ,in p_password_ VARCHAR(45) ,in p_api_token_ VARCHAR(45) ,in p_phone_ VARCHAR(45) )
begin 
 INSERT INTO users (username, email, password, api_token, phone, creationDate, modificationDate)
    VALUES (p_user_name_, p_email_, p_password_, p_api_token_, p_phone_, NOW(), NOW());
end //
delimiter ;
call add_user('luismd','luismd@persona.com','luismd1925','SecretlKey_1993','+57 3127430341');

drop procedure  if exists get_All_Users;
Delimiter //
create procedure get_All_Users()
begin 
       select * from users ;
end //
delimiter ;

call get_All_Users();

drop procedure  if exists exists_user;
Delimiter //
create procedure exists_user(in p_email_ varchar(20),in p_phone_ varchar(15))
begin 
       select email , phone from users where email = p_email_ and phone = p_phone_;
end //
delimiter ;

call exists_user('luismd@persona.com','+57 3127430341');

drop procedure  if exists search_by_phone_User;
Delimiter //
create procedure search_by_phone_User(in phone varchar(20))
begin 
     SELECT * FROM users WHERE REPLACE(phone, '+57 ', '') = phone_param;      
end //
delimiter ;

drop procedure  if exists login_user;
Delimiter //
create procedure login_user(in _name varchar(20),in phone_param varchar(20))
begin 
     select * from users where username = _name and  REPLACE(phone, '+57 ', '') = phone_param;      
end //
delimiter ;

call login_user('luismd','3127430341');

CALL search_by_phone_User();

drop procedure  if exists delete_by_id_Users;
delimiter //
create procedure delete_by_id_Users(in _id int)
begin 
       delete from users where id = _id;
end //
delimiter ;
CALL delete_by_id_Users(3);


drop procedure  if exists search_User_by_Id;
delimiter //
create procedure search_User_by_Id(in _id int)
begin 
       select * from users where id = _id;
end //
delimiter ;
call search_User_by_Id(2);



drop procedure  if exists update_User_by_id;
delimiter //
create procedure update_User_by_id(in _id int, in p_user_name_ varchar(45), in p_password_ varchar(15), in p_email_ varchar(20), in p_token_ varchar(35),in p_phone_ varchar(20))
begin 
       update  users  set username = p_user_name_ ,email = p_email_, password = p_password_,api_token =  p_token_, phone = p_phone_  ,modificationDate = NOW() where id = _id;
end //
delimiter ;
call update_User_by_id(8,'Damaris','dama@persona.com','secreto99','token_xyz_99','+57 3242134567');

-- SECCION DE REPORTES 

/*
        createReport
        function getAllReporT
        deleteReportById
        updateReport

*/

drop table if exists reports;
create table reports(
   id INT AUTO_INCREMENT PRIMARY KEY,
   loan_location varchar(30) NOT NULL,
   product_name varchar(30) NOT NULL,
   amount int NOT NULL,
   description text not null,
   lendStatus boolean not null,
   id_user int NOT NULL,
   foreign key(id_user) references users(id),
   creationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
   modificationDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

);


drop procedure if exists add_report;
delimiter //
create procedure add_report(in p_loan_location varchar(30),in p_product_name varchar(30),in p_amount int,in description text,in lendStatus boolean,in p_id_user int)
begin
     insert into reports values (0,p_loan_location ,p_product_name ,p_amount ,description ,lendStatus,p_id_user,NOW(),NOW());
end //
delimiter ;

------

DROP PROCEDURE IF EXISTS add_report;
DELIMITER //
CREATE PROCEDURE add_report(
    IN p_loan_location VARCHAR(30),
    IN p_product_name VARCHAR(30),
    IN p_amount INT,
    IN p_description TEXT,
    IN p_lend_status TINYINT(1),
    IN p_id_user INT
)
BEGIN
    INSERT INTO reports 
        (id, loan_location, product_name, amount, description, lendStatus, id_user, creationDate, modificationDate)
    VALUES 
        (0, p_loan_location, p_product_name, p_amount, p_description, p_lend_status, p_id_user, NOW(), NOW());
END //
DELIMITER ;

------

call add_report("Estacion","pan frances personal",2,"se prestaron una cantidad de pan lo llevo el domiciliario",true,6);

drop procedure if exists get_all_reports;
delimiter //
create procedure get_all_reports()
begin
    select * from reports;
end //
delimiter ;

call get_all_reports();

drop procedure if exists delete_report;
delimiter //
create procedure delete_report(in _id int)
begin
    delete from reports where id=_id;
end //
delimiter ;

call delete_report(5);

drop procedure if exists update_report;
delimiter //
create procedure update_report(in _id int ,in p_loan_location varchar(30),in p_product_name varchar(30),in p_amount int,in _description text)
begin
    update reports set loan_location = p_loan_location, product_name = p_product_name,amount = p_amount ,description = _description,modificationDate = NOW() where id=_id;
end //
delimiter ;

call update_report(1,"Guayacanes","pan frances personal",40,"se prestaron una cantidad de pan lo llevo el domiciliario atiempo");

drop procedure if exists update_status_report;
delimiter //
create procedure update_status_report(in id_report int ,in _status boolean)
begin
    update reports set lendStatus = _status where id=id_report;
end //
delimiter ;

call update_status_report(1,false);

-- 1 significa que la deuda esta vigente 0 es por que ya esta pago
drop procedure if exists PaymentStatus;
delimiter //
create procedure PaymentStatus(in p_id int)
begin
   select lendStatus from reports where id=p_id and lendStatus=1;
end //
delimiter ;

call PaymentStatus(7);



drop procedure if exists ChangeToPaidStatus;
delimiter //
create procedure ChangeToPaidStatus(in p_id int,out affected_rows int)
begin

update reports set lendStatus = false where id = p_id and lendStatus=true;
SET affected_rows = ROW_COUNT();

end //
delimiter ;

CALL ChangeToPaidStatus(7, @affected_rows);
SELECT @affected_rows AS filas_afectadas;

drop procedure if exists exists_report;
delimiter //
create procedure exists_report(in id_report int)
begin
   select loan_location from reports where id = id_report;
end //
delimiter ;

call exists_report(10);

drop procedure if exists update_Report_by_id;
delimiter //
create procedure update_Report_by_id (in p_id int, in p_location varchar(30) ,in p_name varchar(30),in p_amount int, in p_description text)
begin
       update reports set loan_location = p_location,product_name =p_name,amount = p_amount,description = p_description where id = p_id;
end //
delimiter ;

CALL update_Report_by_id(
    3,
    'Tienda Samsung',
    'lavadora Samsung ',
    80,
    'Compra de lavadora móvil en 90 cuotas'
);


select id,loan_location,product_name,amount,lendStatus,id_user,creationDate,modificationDate from reports;