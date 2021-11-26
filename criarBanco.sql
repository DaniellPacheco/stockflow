create table item(
	id_item int primary key auto_increment not null,
    titulo varchar(100),
    descricao varchar(100),
    quantidadeInicial int,
    quantidadeEmprestada int,
	dataCriacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

create table emprestado(
	id_emprestado int primary key auto_increment not null,
    nomeCompleto varchar(100),
    email varchar(100),
    cep varchar(30),
    endereco varchar(100),
    cidade varchar(100),
    estado varchar(100),
    id_item integer,
    quantidade int,
    dataParaDevolucao date,
    dataEntrega date,
	dataCriacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (id_item) REFERENCES item(id_item)
);

create table usuario(
	id_usuario int primary key auto_increment not null,
    nomeCompleto varchar(100),
    email varchar(100),
    senha varchar(65),
	dataCriacao timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);