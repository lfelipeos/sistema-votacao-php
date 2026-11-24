create database if not exists votacao_db
character set utf8mb4
collate utf8mb4_unicode_ci;

use votacao_db;

create table if not exists chapas (
	id int auto_increment primary key,
	codigo_chapa varchar(20) not null unique,
	nome_chapa varchar(100) not null,
	matricula_lider varchar(30) not null,
	nome_lider varchar(100) not null,
	matricula_vice varchar(30) not null,
	nome_vice varchar(100) not null,
	criado_em timestamp default CURRENT_TIMESTAMP	
) engine=InnoDB;

create table if not exists votos (
	id int auto_increment primary key,
	matricula_aluno varchar(30) not null unique,
	chapa_id int not null,
	data_voto timestamp default CURRENT_TIMESTAMP,
	foreign key (chapa_id) references chapas(id) on delete cascade 
) engine=InnoDB;