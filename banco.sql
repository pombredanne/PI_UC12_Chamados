create database chamados_m171

create table usuarios 
(
    id int not null primary key AUTO_INCREMENT,
    nome varchar(100),
	nomeUsuario varchar(100),
    senha varchar(16),
	admin boolean
);