use pokmonGAF;

create table Usuario(
id_usuario varchar(8) primary key,
nome_usuario varchar(30),
email varchar(50) not null unique check(email like "%@%"),
senha varchar(15) not null,
pontos int default 1000
);

create table Tipo(
id_tipo int check (id_tipo >= 1 and id_tipo <=20) primary key,
nome_tipo varchar(20) not null,
descricao varchar(150) not null
);

create table Item(
id_item int check (id_item >= 1 and id_item <=340) primary key,
nome_item varchar (30) not null,
descricao varchar(150) not null,
buffs int check (buffs >=0 and buffs <=30)
);

create table Habilidade(
id_habilidade int check (id_habilidade >= 1 and id_habilidade <= 934) primary key,
nome_habilidade varchar(30) not null,
descricao varchar(150) not null,
dano int check (dano >= 0),
efeito_colateral varchar(50) default "Nada",
chance_efeito float check (chance_efeito >= 0.0 and chance_efeito <= 1.0)
);

create table Pokemon(
id_pokemon int check (id_pokemon >= 1 and id_pokemon <= 1008) primary key,
nome_pokemon varchar(30) not null,
hp int check (hp >= 0 and hp <= 255),
atk int check (atk >= 0 and atk <= 255),
def int check (def >= 0 and def <= 255),
spatk int check (spatk >= 0 and spatk <= 255),
spdef int check (spdef >= 0 and spdef <= 255),
spe int check (spe >= 0 and spe <= 255),
acc int check (acc >= 0 and acc <= 100),
evas int check (evas >= 0 and evas <= 100),
bst int check (bst >= 0 and bst <= 1530),
tipo int foreign key references Tipo(id_tipo),
item int foreign key references Item(id_item),
habilidade int foreign key references Habilidade(id_habilidade)
);

create table Equipe(
id_equipe int primary key,
nome_equipe varchar(30) not null,
regimento varchar(50) not null,
slot1 int foreign key references Pokemon(id_pokemon),
slot2 int foreign key references Pokemon(id_pokemon),
slot3 int foreign key references Pokemon(id_pokemon),
slot4 int foreign key references Pokemon(id_pokemon),
slot5 int foreign key references Pokemon(id_pokemon),
slot6 int foreign key references Pokemon(id_pokemon)
);