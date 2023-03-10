--DROP TABLES
DROP TABLE Purchaser CASCADE CONSTRAINTS;
DROP TABLE Login CASCADE CONSTRAINTS;
DROP TABLE Creator CASCADE CONSTRAINTS;
DROP TABLE Employee CASCADE CONSTRAINTS;
DROP TABLE Item CASCADE CONSTRAINTS;
DROP TABLE Buys CASCADE CONSTRAINTS;
DROP TABLE Photo CASCADE CONSTRAINTS;
DROP TABLE Art CASCADE CONSTRAINTS;

--DROP SEQUENCES
DROP SEQUENCE seq_purchaser_id;
DROP SEQUENCE seq_employee_id;

--DROP TRIGGERS
DROP TRIGGER trig_purchaser;
DROP TRIGGER trig_employee;
DROP TRIGGER check_supervisor_insert;

--DROP VIEW
DROP VIEW MaxPriceItem;
DROP VIEW FilterByContent;
DROP VIEW PurchaserThatIsCreator;

--DROP PROCEDURE
DROP PROCEDURE CreatorStats;
