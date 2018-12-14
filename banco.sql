create database chamados_m171

create table usuarios 
(
    codigo int not null primary key AUTO_INCREMENT,
    nomeCompleto varchar(100),
	nomeUsuario varchar(100),
	email varchar(100),
    senha varchar(50),
	admin boolean
);

create table chamados 
(
    codigo int not null primary key AUTO_INCREMENT,
    dataHora datetime,
    descricaoProblema varchar(500),
    status varchar(50) default 'Em aberto',
    nivelCriticidade varchar(50),
    solucaoProblema varchar(500),
fkSala int not null,
fkUsuario int not null,
fkTecnicoResponsavel int,
foreign key (fkSala) references salas (codigo),
foreign key (fkUsuario) references usuarios (codigo),
foreign key (fkTecnicoResponsavel) references usuarios (codigo)

);

create table salas
(
	codigo int not null primary key auto_increment,
 	numero varchar(10) not null,
    descricao varchar(200)
);