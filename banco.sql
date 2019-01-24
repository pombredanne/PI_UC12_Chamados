create database chamados_m171

create table usuarios 
(
    codigo int not null primary key AUTO_INCREMENT,
    nomeCompleto varchar(100),
	nomeUsuario varchar(100),
	email varchar(100),
    senha varchar(50),
	admin boolean,
foto varchar(100)
);

create table chamados 
(
    codigo int not null primary key AUTO_INCREMENT,
    dataHoraAbertura datetime,
    descricaoProblema varchar(500),
    status varchar(50) default 'Em aberto',
    historicoStatus varchar(500) default 'Em aberto',
    nivelCriticidade varchar(50),
    solucaoProblema varchar(500),
    pausar datetime,
    retomar datetime,
    pausado boolean default 0,
    resolvido boolean,
    tempoAtual varchar(100),
    tempoTotal varchar(100),
    dataHoraEncerramento datetime,
fkSala int not null,
fkUsuario int not null,
fkTecnicoResponsavel int,
ativo boolean default 1,
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