drop table if exists AvaliacaoEstab ;
drop table if exists DisponibilidadeEstagio ;
drop table if exists EmpresaRamo ;
drop table if exists FormadorDisciplina ;
drop table if exists ResponsavelCargo ;
drop table if exists HorarioEstab ;
drop table if exists zonaTransporte ;
drop table if exists MeiosTransporteLinhas ;
drop table if exists ProdutoEstabelecimento ;
drop table if exists Utilizador ;
drop table if exists Aluno ;
drop table if exists Formador ;
drop table if exists Administrativo ;
drop table if exists Curso ;
drop table if exists Turma ;
drop table if exists AnoLetivo ;
drop table if exists Empresa ;
drop table if exists Disciplina ;
drop table if exists Responsavel ;
drop table if exists Cargos ;
drop table if exists Estagio ;
drop table if exists RamoAtividade ;
drop table if exists Estabelecimento ;
drop table if exists HorarioFunc ;
drop table if exists Zona ;
drop table if exists Transporte ;
drop table if exists MeiosTransporte ;
drop table if exists Localidade ;
drop table if exists Linha ;
drop table if exists Produto ;
 
create table AvaliacaoEstab
(
   AnoLetivo_Ano_   Integer   not null,
   Estabelecimento_Estabelecimento_ID_   integer   not null,
   Nota   float   null DEFAULT 0.0,
 
   constraint PK_AvaliacaoEstab primary key (AnoLetivo_Ano_, Estabelecimento_Estabelecimento_ID_)
);
 
create table DisponibilidadeEstagio
(
   AnoLetivo_Ano_   Integer   not null,
   Empresa_Contribuinte_   Integer   not null,
   disponibilidade   bit   not null,
   numEstagiarios   Integer   not null,
 
   constraint PK_DisponibilidadeEstagio primary key (AnoLetivo_Ano_, Empresa_Contribuinte_)
);
 
create table EmpresaRamo
(
   Empresa_Contribuinte_   Integer   not null,
   RamoAtividade_codCAE_   Integer   not null,
 
   constraint PK_EmpresaRamo primary key (Empresa_Contribuinte_, RamoAtividade_codCAE_)
);
 
create table FormadorDisciplina
(
   Formador_num_   Integer   not null,
   Disciplina_DisciplinaID_   Integer   not null,
 
   constraint PK_FormadorDisciplina primary key (Formador_num_, Disciplina_DisciplinaID_)
);
 
create table ResponsavelCargo
(
   Responsavel_Estabelecimento_Estabelecimento_ID_   integer   not null,
   Responsavel_ResponsavelID_   Integer   not null,
   Cargos_CargoID_   Integer   not null,
 
   constraint PK_ResponsavelCargo primary key (Responsavel_Estabelecimento_Estabelecimento_ID_, Responsavel_ResponsavelID_, Cargos_CargoID_)
);
 
create table HorarioEstab
(
   Estabelecimento_Estabelecimento_ID_   integer   not null,
   HorarioFunc_HorarioFunc_ID_   integer   not null,
 
   constraint PK_HorarioEstab primary key (Estabelecimento_Estabelecimento_ID_, HorarioFunc_HorarioFunc_ID_)
);
 
create table zonaTransporte
(
   Zona_Zona_ID_   integer   not null,
   Transporte_Transporte_ID_   integer   not null,
 
   constraint PK_zonaTransporte primary key (Zona_Zona_ID_, Transporte_Transporte_ID_)
);
 
create table MeiosTransporteLinhas
(
   MeiosTransporte_MeiotransporteID_   Integer   not null,
   Linha_LinhaId_   Integer   not null,
 
   constraint PK_MeiosTransporteLinhas primary key (MeiosTransporte_MeiotransporteID_, Linha_LinhaId_)
);
 
create table ProdutoEstabelecimento
(
   Estabelecimento_Estabelecimento_ID_   integer   not null,
   Produto_produtoId_   Integer   not null,
 
   constraint PK_ProdutoEstabelecimento primary key (Estabelecimento_Estabelecimento_ID_, Produto_produtoId_)
);
 
create table Utilizador
(
   Utilizador_ID   integer   not null,
   Nome   varchar(100)   not null,
   login   varchar(25)  unique not null,
   password   varchar(50)   not null,
 
   constraint PK_Utilizador primary key (Utilizador_ID)
);
 
create table Aluno
(
   Utilizador_Utilizador_ID   integer   not null,
   Curso_Codigo   Integer   not null,
   Turma_Curso_Codigo   Integer   null,
   Turma_sigla   varchar(5)   null,
   Numero   Integer   not null,
   Observacoes   text   null,
 
   constraint PK_Aluno primary key (Numero)
);
 
create table Formador
(
   Utilizador_Utilizador_ID   integer   not null,
   num   Integer   not null,
 
   constraint PK_Formador primary key (num)
);
 
create table Administrativo
(
   Utilizador_Utilizador_ID   integer   not null,
 
   constraint PK_Administrativo primary key (Utilizador_Utilizador_ID)
);
 
create table Curso
(
   Codigo   Integer   not null,
   Designacao   text   null,
 
   constraint PK_Curso primary key (Codigo)
);
 
create table Turma
(
   Curso_Codigo   Integer   not null,
   AnoLetivo_Ano   Integer   not null,
   sigla   varchar(5)   not null,
 
   constraint PK_Turma primary key (Curso_Codigo, sigla)
);
 
create table AnoLetivo
(
   Ano   Integer   not null,
 
   constraint PK_AnoLetivo primary key (Ano)
);
 
create table Empresa
(
   Localidade_Localidade_ID   integer   not null,
   Contribuinte   Integer   not null,
   Morada   varchar(100)  unique not null,
   Localidade   varchar(50)   not null,
   telefone   Integer  unique not null,
   email   varchar(50)  unique not null,
   website   varchar(50)  unique not null,
   Observacoes   text   null,
 
   constraint PK_Empresa primary key (Contribuinte)
);
 
create table Disciplina
(
   DisciplinaID   Integer   not null,
   Nome   varchar(50)   not null,
 
   constraint PK_Disciplina primary key (DisciplinaID)
);
 
create table Responsavel
(
   Estabelecimento_Estabelecimento_ID   integer   not null,
   Observacoes   text   null,
   email   varchar(100)  unique not null,
   telefoneDireto   Integer  unique not null,
   telemovel   Integer  unique not null,
   Titulo   varchar(5)   not null,
   nome   varchar(100)   not null,
   ResponsavelID   Integer   not null,
 
   constraint PK_Responsavel primary key (Estabelecimento_Estabelecimento_ID, ResponsavelID)
);
 
create table Cargos
(
   CargoID   Integer   not null,
   Designacao   text   null,
 
   constraint PK_Cargos primary key (CargoID)
);
 
create table Estagio
(
   Aluno_Numero   Integer   not null,
   Formador_num   Integer   not null,
   Responsavel_Estabelecimento_Estabelecimento_ID   integer   not null,
   Responsavel_ResponsavelID   Integer   not null,
   Estabelecimento_Estabelecimento_ID   integer   not null,
   Estagio_ID   integer   not null,
   notaFinal   float   null DEFAULT 0.0,
   classificacaoAluno   Integer   null DEFAULT 1,
   notaRelatorio   float   null DEFAULT 0.0,
   notaProcura   float   null DEFAULT 0.0,
   notaEscola   float   null DEFAULT 0.0,
   notaEmpresa   float   null DEFAULT 0.0,
   DataInicio   datetime   null,
   DataFim   datetime   null,
 
   constraint PK_Estagio primary key (Estagio_ID)
);
 
create table RamoAtividade
(
   codCAE   Integer   not null,
   Descricao   text   null,
 
   constraint PK_RamoAtividade primary key (codCAE)
);
 
create table Estabelecimento
(
   Empresa_Contribuinte   Integer   null,
   Localidade_Localidade_ID   integer   not null,
   Estabelecimento_ID   integer   not null,
   Nome   varchar(100)   not null,
   Morada   varchar(100)  unique not null,
   Telefone   Integer  unique not null,
   email   varchar(50)  unique not null,
   Observacoes   text   null,
   aceitouFunc   bit   not null DEFAULT 0,
   Fundacao   datetime   not null,
   foto   text  unique null,
 
   constraint PK_Estabelecimento primary key (Estabelecimento_ID)
);
 
create table HorarioFunc
(
   HorarioFunc_ID   integer   not null,
   Abertura   time   not null,
   Fechamento   time   not null,
   diaSemana   varchar(20)   not null,
 
   constraint PK_HorarioFunc primary key (HorarioFunc_ID)
);
 
create table Zona
(
   Localidade_Localidade_ID   integer   not null,
   Zona_ID   integer   not null,
   Designacao   text   null,
   Mapa   text  unique null,
 
   constraint PK_Zona primary key (Zona_ID)
);
 
create table Transporte
(
   MeiosTransporte_MeiotransporteID   Integer   not null,
   Transporte_ID   integer   not null,
   Observacoes   text   null,
 
   constraint PK_Transporte primary key (Transporte_ID)
);
 
create table MeiosTransporte
(
   nome   varchar(25)   not null,
   MeiotransporteID   Integer   not null,
 
   constraint PK_MeiosTransporte primary key (MeiotransporteID)
);
 
create table Localidade
(
   Localidade_ID   integer   not null,
   CodigoPostal   varchar(10)  unique not null,
   Nome   varchar(25)   not null,
 
   constraint PK_Localidade primary key (Localidade_ID)
);
 
create table Linha
(
   LinhaId   Integer   not null,
   nome   varchar(25)   not null,
 
   constraint PK_Linha primary key (LinhaId)
);
 
create table Produto
(
   Nome   varchar(25)   not null,
   Marca   varchar(25)   not null,
   produtoId   Integer   not null,
 
   constraint PK_Produto primary key (produtoId)
);
 
alter table AvaliacaoEstab
   add constraint FK_AnoLetivo_AvaliacaoEstab_Estabelecimento_ foreign key (AnoLetivo_Ano_)
   references AnoLetivo(Ano)
   on delete cascade
   on update cascade
; 
alter table AvaliacaoEstab
   add constraint FK_Estabelecimento_AvaliacaoEstab_AnoLetivo_ foreign key (Estabelecimento_Estabelecimento_ID_)
   references Estabelecimento(Estabelecimento_ID)
   on delete cascade
   on update cascade
;
 
alter table DisponibilidadeEstagio
   add constraint FK_AnoLetivo_DisponibilidadeEstagio_Empresa_ foreign key (AnoLetivo_Ano_)
   references AnoLetivo(Ano)
   on delete cascade
   on update cascade
; 
alter table DisponibilidadeEstagio
   add constraint FK_Empresa_DisponibilidadeEstagio_AnoLetivo_ foreign key (Empresa_Contribuinte_)
   references Empresa(Contribuinte)
   on delete cascade
   on update cascade
;
 
alter table EmpresaRamo
   add constraint FK_Empresa_EmpresaRamo_RamoAtividade_ foreign key (Empresa_Contribuinte_)
   references Empresa(Contribuinte)
   on delete cascade
   on update cascade
; 
alter table EmpresaRamo
   add constraint FK_RamoAtividade_EmpresaRamo_Empresa_ foreign key (RamoAtividade_codCAE_)
   references RamoAtividade(codCAE)
   on delete cascade
   on update cascade
;
 
alter table FormadorDisciplina
   add constraint FK_Formador_FormadorDisciplina_Disciplina_ foreign key (Formador_num_)
   references Formador(num)
   on delete cascade
   on update cascade
; 
alter table FormadorDisciplina
   add constraint FK_Disciplina_FormadorDisciplina_Formador_ foreign key (Disciplina_DisciplinaID_)
   references Disciplina(DisciplinaID)
   on delete cascade
   on update cascade
;
 
alter table ResponsavelCargo
   add constraint FK_Responsavel_ResponsavelCargo_Cargos_ foreign key (Responsavel_Estabelecimento_Estabelecimento_ID_, Responsavel_ResponsavelID_)
   references Responsavel(Estabelecimento_Estabelecimento_ID, ResponsavelID)
   on delete cascade
   on update cascade
; 
alter table ResponsavelCargo
   add constraint FK_Cargos_ResponsavelCargo_Responsavel_ foreign key (Cargos_CargoID_)
   references Cargos(CargoID)
   on delete cascade
   on update cascade
;
 
alter table HorarioEstab
   add constraint FK_Estabelecimento_HorarioEstab_HorarioFunc_ foreign key (Estabelecimento_Estabelecimento_ID_)
   references Estabelecimento(Estabelecimento_ID)
   on delete cascade
   on update cascade
; 
alter table HorarioEstab
   add constraint FK_HorarioFunc_HorarioEstab_Estabelecimento_ foreign key (HorarioFunc_HorarioFunc_ID_)
   references HorarioFunc(HorarioFunc_ID)
   on delete restrict
   on update cascade
;
 
alter table zonaTransporte
   add constraint FK_Zona_zonaTransporte_Transporte_ foreign key (Zona_Zona_ID_)
   references Zona(Zona_ID)
   on delete cascade
   on update cascade
; 
alter table zonaTransporte
   add constraint FK_Transporte_zonaTransporte_Zona_ foreign key (Transporte_Transporte_ID_)
   references Transporte(Transporte_ID)
   on delete cascade
   on update cascade
;
 
alter table MeiosTransporteLinhas
   add constraint FK_MeiosTransporte_MeiosTransporteLinhas_Linha_ foreign key (MeiosTransporte_MeiotransporteID_)
   references MeiosTransporte(MeiotransporteID)
   on delete cascade
   on update cascade
; 
alter table MeiosTransporteLinhas
   add constraint FK_Linha_MeiosTransporteLinhas_MeiosTransporte_ foreign key (Linha_LinhaId_)
   references Linha(LinhaId)
   on delete cascade
   on update cascade
;
 
alter table ProdutoEstabelecimento
   add constraint FK_Estabelecimento_ProdutoEstabelecimento_Produto_ foreign key (Estabelecimento_Estabelecimento_ID_)
   references Estabelecimento(Estabelecimento_ID)
   on delete cascade
   on update cascade
; 
alter table ProdutoEstabelecimento
   add constraint FK_Produto_ProdutoEstabelecimento_Estabelecimento_ foreign key (Produto_produtoId_)
   references Produto(produtoId)
   on delete restrict
   on update cascade
;
 
 
alter table Aluno
   add constraint FK_Aluno_Utilizador foreign key (Utilizador_Utilizador_ID)
   references Utilizador(Utilizador_ID)
   on delete cascade
   on update cascade
; 
alter table Aluno
   add constraint FK_Aluno_Curso_Aluno_Curso foreign key (Curso_Codigo)
   references Curso(Codigo)
   on delete restrict
   on update cascade
; 
alter table Aluno
   add constraint FK_Aluno_AlunoTurma_Turma foreign key (Turma_Curso_Codigo, Turma_sigla)
   references Turma(Curso_Codigo, sigla)
   on delete set null
   on update cascade
;
 
alter table Formador
   add constraint FK_Formador_Utilizador foreign key (Utilizador_Utilizador_ID)
   references Utilizador(Utilizador_ID)
   on delete cascade
   on update cascade
;
 
alter table Administrativo
   add constraint FK_Administrativo_Utilizador foreign key (Utilizador_Utilizador_ID)
   references Utilizador(Utilizador_ID)
   on delete cascade
   on update cascade
;
 
 
alter table Turma
   add constraint FK_Turma_CursoTurma_Curso foreign key (Curso_Codigo)
   references Curso(Codigo)
   on delete cascade
   on update cascade
; 
alter table Turma
   add constraint FK_Turma_Ano_Turma_AnoLetivo foreign key (AnoLetivo_Ano)
   references AnoLetivo(Ano)
   on delete restrict
   on update cascade
;
 
 
alter table Empresa
   add constraint FK_Empresa_noname_Localidade foreign key (Localidade_Localidade_ID)
   references Localidade(Localidade_ID)
   on delete restrict
   on update cascade
;
 
 
alter table Responsavel
   add constraint FK_Responsavel_ResponsavelEstab_Estabelecimento foreign key (Estabelecimento_Estabelecimento_ID)
   references Estabelecimento(Estabelecimento_ID)
   on delete cascade
   on update cascade
;
 
 
alter table Estagio
   add constraint FK_Estagio_AlunoEstagio_Aluno foreign key (Aluno_Numero)
   references Aluno(Numero)
   on delete restrict
   on update cascade
; 
alter table Estagio
   add constraint FK_Estagio_EstagioFormador_Formador foreign key (Formador_num)
   references Formador(num)
   on delete restrict
   on update cascade
; 
alter table Estagio
   add constraint FK_Estagio_EstagioResponsavel_Responsavel foreign key (Responsavel_Estabelecimento_Estabelecimento_ID, Responsavel_ResponsavelID)
   references Responsavel(Estabelecimento_Estabelecimento_ID, ResponsavelID)
   on delete restrict
   on update cascade
; 
alter table Estagio
   add constraint FK_Estagio_EstagioEstab_Estabelecimento foreign key (Estabelecimento_Estabelecimento_ID)
   references Estabelecimento(Estabelecimento_ID)
   on delete restrict
   on update cascade
;
 
 
alter table Estabelecimento
   add constraint FK_Estabelecimento_EmpresaEstabelecimento_Empresa foreign key (Empresa_Contribuinte)
   references Empresa(Contribuinte)
   on delete set null
   on update cascade
; 
alter table Estabelecimento
   add constraint FK_Estabelecimento_noname_Localidade foreign key (Localidade_Localidade_ID)
   references Localidade(Localidade_ID)
   on delete restrict
   on update cascade
;
 
 
alter table Zona
   add constraint FK_Zona_noname_Localidade foreign key (Localidade_Localidade_ID)
   references Localidade(Localidade_ID)
   on delete restrict
   on update cascade
;
 
alter table Transporte
   add constraint FK_Transporte_noname_MeiosTransporte foreign key (MeiosTransporte_MeiotransporteID)
   references MeiosTransporte(MeiotransporteID)
   on delete restrict
   on update cascade
;
 
 
 
 
 
