-- ----------------------------
-- Tabelas sem FKs de outras tabelas ou com chaves que devem ser inseridas primeiro
-- ----------------------------

-- Inserção de Utilizadores
INSERT INTO utilizador (Utilizador_ID, Nome, login, password) VALUES
(1, 'Diogo Ferreira', 'dferreira', 'M0nch3g0!2025'),
(2, 'Ana Sousa', 'asousa', 'CafeDaManha#72'),
(3, 'Rui Martins', 'rmartins', '7h!sIsAStr0ngP@ss'),
(4, 'Inês Costa', 'icosta', 'Soleador_89'),
(5, 'João Almeida', 'jalmeida', 'DragonBike$17');

-- Cursos
INSERT INTO curso (Codigo, Designacao) VALUES
(1, 'Licenciatura em Engenharia Informática'),
(2, 'Licenciatura em Engenharia Eletrotécnica'),
(3, 'Licenciatura em Gestão'),
(4, 'Licenciatura em Ciências da Computação'),
(5, 'Licenciatura em Design Gráfico');

-- Anos Letivos
INSERT INTO anoletivo (Ano) VALUES
(1),
(2),
(3);

-- Disciplinas
INSERT INTO disciplina (DisciplinaID, Nome) VALUES
(1, 'Matemática'),
(2, 'Física'),
(3, 'Química'),
(4, 'Biologia'),
(5, 'Informática'),
(6, 'Programação'),
(7, 'Engenharia de Software'),
(8, 'Redes de Computadores'),
(9, 'Sistemas Operativos'),
(10, 'Gestão de Projetos');

-- Cargos
INSERT INTO cargos (CargoID, Designacao) VALUES
(1, 'Gerente Geral'),
(2, 'Diretor de Operações'),
(3, 'Chefe de Recursos Humanos'),
(4, 'Responsável de Marketing'),
(5, 'Supervisor de Produção'),
(6, 'Coordenador de Vendas'),
(7, 'Administrador Financeiro'),
(8, 'Responsável de Logística'),
(9, 'Gestor de Qualidade'),
(10, 'Assistente Administrativo');

-- Ramo de Atividade
INSERT INTO ramoatividade (codCAE, Descricao) VALUES
(1010, 'Indústria Alimentar'),
(4511, 'Comércio de Automóveis'),
(4719, 'Comércio a Retalho em Estabelecimentos Não Especializados'),
(5510, 'Hotelaria'),
(5610, 'Restauração e Similares'),
(6201, 'Desenvolvimento de Software'),
(6820, 'Mediação e Gestão Imobiliária'),
(7410, 'Consultoria e Serviços Técnicos'),
(8559, 'Formação Profissional e Ensino'),
(9311, 'Gestão de Instalações Desportivas');

-- Localidades (Necessária antes de Empresa, Estabelecimento e Zona)
INSERT INTO localidade (Localidade_ID, CodigoPostal, Nome) VALUES
(1, '2665-620', 'Lisboa'),
(2, '4990-670', 'Viana do Castelo'),
(3, '8500-301', 'Portimão'),
(4, '2830-361', 'Barreiro'),
(5, '1750-174', 'Lisboa');

-- Meios de Transporte (Necessária antes de Transporte)
INSERT INTO meiostransporte (nome, MeiotransporteID) VALUES
('Carris', 1),
('CP - Comboios de Portugal', 2),
('Fertagus', 3),
('Metro de Lisboa', 4),
('Metro do Porto', 5),
('Transtejo Soflusa', 6),
('Rodoviária de Lisboa', 7),
('Rede Expressos', 8),
('Transportes Sul do Tejo', 9),
('Uber', 10),
('Bolt', 11),
('FlixBus', 12),
('Carris Metropolitana', 13),
('Transtejo', 14),
('CP Regional', 15);

-- Produtos (Necessária antes de ProdutoEstabelecimento)
INSERT INTO produto (Nome, Marca, produtoId) VALUES
('', 'HP', 1),
('', 'Lenovo', 2),
('', 'Logitech', 3),
('', 'Microsoft', 4),
('', 'Asus', 5),
('', 'Nestlé', 6),
('', 'Compal', 7),
('', 'Delta Cafés', 8),
('', 'Super Bock', 9),
('', 'Sagres', 10),
('', 'Coca-Cola', 11),
('', 'Lipton', 12),
('', 'Luso', 13),
('', 'Sumol', 14),
('', 'Pastelaria Portuguesa', 15),
('', 'Bosch', 16),
('', 'Makita', 17),
('', 'Galp Energia', 18),
('', 'Energias Algarve', 19),
('', 'Varta', 20);

-- Horário Funcionamento (Necessária antes de HorarioEstab)
INSERT INTO horariofunc (HorarioFunc_ID, Abertura, Fechamento, diaSemana) VALUES
(1, '09:00:00', '18:00:00', 'Segunda-feira'),
(2, '09:00:00', '18:00:00', 'Terça-feira'),
(3, '09:00:00', '18:00:00', 'Quarta-feira'),
(4, '09:00:00', '18:00:00', 'Quinta-feira'),
(5, '09:00:00', '18:00:00', 'Sexta-feira'),
(6, '10:00:00', '14:00:00', 'Sábado'),
(7, '00:00:00', '00:00:00', 'Domingo');

-- Linhas de Transporte (Necessária antes de MeiosTransporteLinhas)
INSERT INTO linha (LinhaId, nome) VALUES
(1, 'Carris 758 - Cais do Sodr'),
(2, 'Carris Metropolitana 3008'),
(3, 'Metro de Lisboa - Linha A'),
(4, 'Metro de Lisboa - Linha V'),
(5, 'Metro do Porto - Linha D '),
(6, 'CP Linha de Cascais'),
(7, 'CP Linha de Sintra'),
(8, 'Fertagus - Setúbal ? Roma'),
(9, 'Transtejo - Cacilhas ? Ca'),
(10, 'Rede Expressos - Lisboa ?'),
(11, 'Rodoviária de Lisboa 201 '),
(12, 'Transportes Sul do Tejo 1'),
(13, 'FlixBus - Lisboa Oriente '),
(14, 'CP Regional - Lisboa ? Év'),
(15, 'EVA Transportes - Faro ? ');

-- Turmas (Necessária antes de Alunos)
INSERT INTO turma (Curso_Codigo, AnoLetivo_Ano, sigla) VALUES
(1, 1, 'LEI1'),
(2, 1, 'LEE1'),
(3, 1, 'LG1'),
(4, 1, 'LCC'),
(1, 2, 'LEI2'),
(2, 2, 'LEE2');

-- ----------------------------
-- Tabelas com dependências agora satisfeitas
-- ----------------------------

-- Empresas (Depende de Localidades)
INSERT INTO empresa (Localidade_Localidade_ID, Contribuinte, Morada, Localidade, telefone, email, website, Observacoes) VALUES
(3, 502345678, 'Urbanização das Gaivotas Lote 4', 'Portimão', 289654987, 'contacto@algarvesolar.pt', 'www.algarvesolar.pt', 'Energia solar e sustentabilidade'),
(4, 503218765, 'Praça da Liberdade 7', 'Barreiro', 212345678, 'suporte@barreirotech.pt', 'www.barreirotech.pt', 'Soluções de manutenção informática'),
(1, 504567890, 'Rua das Amoreiras 10', 'Lisboa', 213876543, 'admin@liscon.pt', 'www.liscon.pt', 'Construção e obras públicas'),
(3, 505432198, 'Rua da Praia 90', 'Portimão', 282987654, 'info@portimar.pt', 'www.portimar.pt', 'Turismo e hotelaria'),
(5, 506789123, 'Estrada de Benfica 230', 'Lisboa', 217654321, 'geral@lisfood.pt', 'www.lisfood.pt', 'Distribuição alimentar'),
(2, 507654321, 'Avenida do Atlântico 45', 'Viana do Castelo', 258765432, 'geral@atlanticlog.pt', 'www.atlanticlog.pt', 'Logística e transportes marítimos'),
(1, 509123456, 'Rua das Flores 12', 'Lisboa', 218456789, 'contacto@alfatech.pt', 'www.alfatech.pt', 'Empresa de desenvolvimento de software');

-- Estabelecimentos (Depende de Localidades e opcionalmente de Empresas)
INSERT INTO estabelecimento (Empresa_Contribuinte, Localidade_Localidade_ID, Estabelecimento_ID, Nome, Morada, Telefone, email, Observacoes, aceitouFunc, Fundacao, foto) VALUES
(509123456, 1, 1001, 'AlfaTech Hub', 'Rua das Flores 12, 2665-620 Lisboa', 218456789, 'hub@alfatech.pt', 'Coworking e incubadora', b'1', '2015-06-01 00:00:00', 'images/estab1.jpg'),
(507654321, 2, 1002, 'Atlantic Logistics Depot', 'Avenida do Atlântico 45, 4990-670 Viana do Castelo', 258765432, 'depo@atlanticlog.pt', 'Armazém e logística', b'1', '2010-09-15 00:00:00', 'images/estab2.jpg'),
(NULL, 3, 1003, 'Praia Bar & Hostel', 'Rua da Praia 90, 8500-301 Portimão', 282987654, 'reservas@praiahostel.pt', 'Hostel pequeno junto à praia', b'0', '2018-03-20 00:00:00', NULL),
(503218765, 4, 1004, 'Barreiro Tech Center', 'Praça da Liberdade 7, 2830-361 Barreiro', 212345678, 'info@barreirotech.pt', 'Serviços técnicos e formação', b'1', '2008-11-05 00:00:00', 'images/estab4.jpg'),
(NULL, 1, 1005, 'Café das Amoreiras', 'Rua das Amoreiras 10, 2665-620 Lisboa', 213876543, 'cafedasamoreiras@mail.pt', 'Café local com esplanada', b'0', '2020-07-10 00:00:00', NULL),
(506789123, 5, 1006, 'LisFood Distribuição', 'Estrada de Benfica 230, 1750-174 Lisboa', 217654321, 'logistica@lisfood.pt', 'Centro de distribuição alimentar', b'1', '2002-02-25 00:00:00', 'images/estab6.jpg'),
(NULL, 3, 1007, 'Algarve Solar Studio', 'Urbanização das Gaivotas Lote 4, 8500-301 Portimão', 289654987, 'contacto@algarvesolar.pt', 'Loja de painéis solares (loja sem empresa)', b'1', '2019-05-14 00:00:00', 'images/estab7.jpg'),
(504567890, 1, 1008, 'LisCon Construções', 'Avenida Central 5, 2665-620 Lisboa', 213000111, 'geral@liscon.pt', 'Escritório central de obras', b'1', '1998-01-20 00:00:00', NULL);

-- Empresa-Ramo (Depende de Empresa e RamoAtividade)
INSERT INTO empresaramo (Empresa_Contribuinte_, RamoAtividade_codCAE_) VALUES
(502345678, 1010),
(503218765, 6201),
(504567890, 4511),
(505432198, 5510),
(506789123, 4719),
(507654321, 5610),
(509123456, 7410);

-- Responsáveis (Depende de Estabelecimentos)
INSERT INTO responsavel (Estabelecimento_Estabelecimento_ID, Observacoes, email, telefoneDireto, telemovel, Titulo, nome, ResponsavelID) VALUES
(1001, 'Responsável pelo espaço tecnológico e pela gestão de equipas', 'joana.silva@alfatech.pt', 218456780, 912345678, 'Eng.', 'Joana Silva', 1),
(1002, 'Supervisiona as operações logísticas e os transportes internacionais', 'ricardo.ferreira@atlanticlog.pt', 258765430, 913567890, 'Dr.', 'Ricardo Ferreira', 2),
(1003, 'Gerente do hostel e responsável por reservas e equipa de bar', 'sofia.martins@praiahostel.pt', 282987650, 914678901, 'Sra.', 'Sofia Martins', 3),
(1004, 'Chefe de manutenção e formador técnico', 'carlos.santos@barreirotech.pt', 212345670, 915789012, 'Sr.', 'Carlos Santos', 4),
(1005, 'Gerente e responsável pelo serviço de mesa e fornecedores', 'maria.rocha@cafedasamoreiras.pt', 213876540, 916890123, 'Sra.', 'Maria Rocha', 5),
(1006, 'Diretor de armazém e distribuição alimentar', 'paulo.costa@lisfood.pt', 217654320, 917901234, 'Dr.', 'Paulo Costa', 6),
(1007, 'Responsável técnico e comercial de energia solar', 'andre.pires@algarvesolar.pt', 289654980, 918012345, 'Eng.', 'André Pires', 7),
(1008, 'Gestor de obras e contacto com fornecedores', 'ana.lopes@liscon.pt', 213000110, 919123456, 'Arq.', 'Ana Lopes', 8);

-- Responsável-Cargo (Depende de Responsáveis e Cargos)
INSERT INTO responsavelcargo (Responsavel_Estabelecimento_Estabelecimento_ID_, Responsavel_ResponsavelID_, Cargos_CargoID_) VALUES
(1001, 1, 1),
(1002, 2, 2),
(1003, 3, 1),
(1004, 4, 5),
(1005, 5, 1),
(1006, 6, 7),
(1007, 7, 8),
(1008, 8, 2);

-- Formadores (Depende de Utilizadores)
INSERT INTO formador (Utilizador_Utilizador_ID, num) VALUES
(2, 1527);

-- FormadorDisciplina (Depende de Formadores e Disciplinas)
INSERT INTO formadordisciplina (Formador_num_, Disciplina_DisciplinaID_) VALUES
(1527, 6);

-- Administrativos (Depende de Utilizadores)
INSERT INTO administrativo (Utilizador_Utilizador_ID) VALUES
(5);

-- Alunos (Depende de Utilizadores, Cursos e Turmas)
INSERT INTO aluno (Utilizador_Utilizador_ID, Curso_Codigo, Turma_Curso_Codigo, Turma_sigla, Numero, Observacoes) VALUES
(2, 2, 2, 'LEE1', 129132, NULL),
(1, 1, 1, 'LEI1', 129421, NULL),
(3, 3, 3, 'LG1', 130412, NULL);

-- Estágios (Depende de Alunos, Formadores, Responsáveis e Estabelecimentos)
INSERT INTO estagio (Aluno_Numero, Formador_num, Responsavel_Estabelecimento_Estabelecimento_ID, Responsavel_ResponsavelID, Estabelecimento_Estabelecimento_ID, Estagio_ID, notaFinal, classificacaoAluno, notaRelatorio, notaProcura, notaEscola, notaEmpresa, DataInicio, DataFim) VALUES
(129421, 1527, 1001, 1, 1001, 1, 18, 1, 18, 17, 18, 19, '2025-02-01 00:00:00', '2025-06-01 00:00:00'),
(129132, 1527, 1002, 2, 1002, 2, 16, 1, 15, 17, 16, 16, '2025-02-15 00:00:00', '2025-06-15 00:00:00'),
(130412, 1527, 1003, 3, 1003, 3, 19, 1, 18, 19, 19, 20, '2025-03-01 00:00:00', '2025-07-01 00:00:00');

-- Disponibilidade de Estágios (Depende de AnoLetivo e Empresas)
INSERT INTO disponibilidadeestagio (AnoLetivo_Ano_, Empresa_Contribuinte_, disponibilidade, numEstagiarios) VALUES
(1, 506789123, b'1', 4),
(1, 507654321, b'0', 0),
(1, 509123456, b'1', 3),
(2, 504567890, b'1', 1),
(2, 507654321, b'1', 2),
(3, 503218765, b'0', 0),
(3, 509123456, b'1', 2);

-- Avaliação de Estabelecimentos (Depende de AnoLetivo e Estabelecimentos)
INSERT INTO avaliacaoestab (AnoLetivo_Ano_, Estabelecimento_Estabelecimento_ID_, Nota) VALUES
(1, 1001, 18.5),
(1, 1002, 16.5),
(1, 1004, 19),
(1, 1007, 13.5),
(2, 1002, 16),
(2, 1003, 14),
(2, 1005, 15.5),
(2, 1008, 18),
(3, 1001, 17.5),
(3, 1003, 14.5),
(3, 1004, 19.5),
(3, 1006, 17);

-- Horário dos Estabelecimentos (Depende de Estabelecimentos e HorarioFunc)
INSERT INTO horarioestab (Estabelecimento_Estabelecimento_ID_, HorarioFunc_HorarioFunc_ID_) VALUES
(1001, 1), (1001, 2), (1001, 3), (1001, 4), (1001, 5), (1001, 6),
(1002, 1), (1002, 2), (1002, 3), (1002, 4), (1002, 5), (1002, 6),
(1003, 1), (1003, 2), (1003, 3), (1003, 4), (1003, 5), (1003, 6), (1003, 7),
(1004, 1), (1004, 2), (1004, 3), (1004, 4), (1004, 5),
(1005, 1), (1005, 2), (1005, 3), (1005, 4), (1005, 5), (1005, 6), (1005, 7),
(1006, 1), (1006, 2), (1006, 3), (1006, 4), (1006, 5), (1006, 6),
(1007, 1), (1007, 2), (1007, 3), (1007, 4), (1007, 5), (1007, 6),
(1008, 1), (1008, 2), (1008, 3), (1008, 4), (1008, 5);

-- MeiosTransporteLinhas (Depende de MeiosTransporte e Linha)
INSERT INTO meiostransportelinhas (MeiosTransporte_MeiotransporteID_, Linha_LinhaId_) VALUES
(1, 1), (2, 6), (2, 7), (3, 8), (4, 3), (4, 4), (5, 5), (6, 9), (7, 11),
(8, 10), (9, 12), (12, 13), (13, 2), (15, 14), (15, 15);

-- Transportes (Depende de MeiosTransporte)
INSERT INTO transporte (MeiosTransporte_MeiotransporteID, Transporte_ID, Observacoes) VALUES
(1, 1, 'Autocarro 728 - Restelo / Portela'),
(1, 2, 'Autocarro 735 - Cais do Sodré / Hospital Santa Maria'),
(2, 3, 'Comboio Regional Lisboa - Entroncamento'),
(2, 4, 'Alfa Pendular Porto - Faro'),
(3, 5, 'Comboio Fertagus Setúbal - Roma-Areeiro'),
(4, 6, 'Metro Linha Amarela - Odivelas / Rato'),
(4, 7, 'Metro Linha Azul - Amadora Este / Santa Apolónia'),
(6, 8, 'Barco Cacilhas - Cais do Sodré'), -- Corrigido de (5, 8) para (6, 8) para Transtejo
(7, 9, 'Expresso 200 - Lisboa / Sintra'),
(8, 10, 'Rede Expressos Lisboa / Viana do Castelo');

-- Produtos nos Estabelecimentos (Depende de Estabelecimentos e Produtos)
INSERT INTO produtoestabelecimento (Estabelecimento_Estabelecimento_ID_, Produto_produtoId_) VALUES
(1001, 1), (1001, 2), (1001, 3), (1001, 4), (1002, 16), (1002, 17), (1002, 18),
(1003, 11), (1003, 12), (1003, 13), (1003, 14), (1003, 15), (1004, 2),
(1004, 3), (1004, 5), (1005, 8), (1005, 9), (1005, 10), (1005, 11), (1005, 15),
(1006, 6), (1006, 7), (1006, 8), (1006, 9), (1006, 10), (1007, 16),
(1007, 18), (1007, 19), (1007, 20), (1008, 16), (1008, 17), (1008, 18);

-- Zonas (Depende de Localidades)
INSERT INTO zona (Localidade_Localidade_ID, Zona_ID, Designacao, Mapa) VALUES
(1, 1, 'Venda do Pinheiro', NULL),
(2, 2, 'Moreira do Lima', NULL),
(3, 3, 'Portimao', NULL),
(4, 4, 'Barreiro', NULL),
(5, 5, 'Lumiar', NULL);

-- Zona-Transporte (Depende de Zonas e Transportes)
INSERT INTO zonatransporte (Zona_Zona_ID_, Transporte_Transporte_ID_) VALUES
(1, 3), (1, 9), (2, 10), (3, 4), (4, 5), (4, 8), (5, 1), (5, 2), (5, 6), (5, 7);