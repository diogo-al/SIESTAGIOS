--T1 * Garante que a classificação de um estágio está entre 1 e 5
--   * Executada antes de cada INSERT na tabela estagio
--   * Bloqueia a inserção e dispara erro caso a classificação seja inválida

CREATE TRIGGER `T1` BEFORE INSERT ON `estagio`
 FOR EACH ROW BEGIN
	if new.classificacao < 1 OR new.classificacao > 5 then
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Classificação Errada';
    END IF;
END

--T1.1 * Garante que a classificação do estágio permanece entre 1 e 5 após atualização
--     * Executada antes de cada UPDATE na tabela estagio
--     * Bloqueia a atualização e dispara erro caso a classificação seja inválida

CREATE TRIGGER `T1.1` BEFORE UPDATE ON `estagio`
 FOR EACH ROW BEGIN
	if new.classificacao < 1 OR new.classificacao > 5 then
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Classificação Errada';
    END IF;    
END

--T2 * Garante que a data de início do estágio não é posterior à data de fim
--     * Executada antes de cada UPDATE na tabela estagio
--     * Bloqueia a atualização e dispara erro caso as datas sejam inválidas

CREATE TRIGGER `T2` BEFORE UPDATE ON `estagio`
 FOR EACH ROW BEGIN
	if new.data_inicio > new.data_fim THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Data Errada';
    end if;
END

-- T2.1 * Verifica que a data de início do estágio não é posterior à data de fim antes do insert
--      * Executada antes de cada INSERT na tabela estagio
--      * Bloqueia a inserção e dispara erro caso as datas sejam inválidas
CREATE TRIGGER `T2.1` BEFORE INSERT ON `estagio`
 FOR EACH ROW BEGIN
	if new.data_inicio > new.data_fim THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Data Errada';
    end if;

END

--P1 * Cria um novo estágio se o aluno, formador e estabelecimento existirem
--    * Verifica a existência de cada ID na base de dados antes de inserir
--    * Define valores default: data_inicio = hoje, notas = 0 (Apenas aquelas que não têm valor default definido na tabela)
--    * Se algum dos IDs não existir, dispara erro controlado com mensagem explicativa

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `P1`(IN `emprs_id` INT, IN `est_id` INT, IN `aln_id` INT, IN `form_id` INT)
BEGIN 
    DECLARE nAluno INT;
    DECLARE nEstabelecimento INT;
    DECLARE nFormador INT;

    SELECT COUNT(*) INTO nAluno FROM aluno WHERE utilizador_id = aln_id;
    SELECT COUNT(*) INTO nFormador FROM formador WHERE utilizador_id = form_id;
    SELECT COUNT(*) INTO nEstabelecimento FROM estabelecimento WHERE estabelecimento_id = est_id AND empresa_id = emprs_id;

    IF (nAluno > 0 AND nEstabelecimento > 0 AND nFormador > 0) THEN
        INSERT INTO estagio 
        (estabelecimento_empresa_id, estabelecimento_id, aluno_id, formador_id, data_inicio, nota_escola, nota_relatorio, nota_procura) 
        VALUES (emprs_id, est_id, aln_id, form_id, CURDATE(), 0, 0, 0);
    ELSE
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'estagio, aluno ou formador não encontrado na base de dados. Tente novamente!';
    END IF;
END$$
DELIMITER ;

--P2 * Lista todos os estágios que começam nos próximos 'numDias' dias a partir de hoje
--    * Verifica se o número de dias é válido (não negativo)
--    * Calcula a data final adicionando 'numDias' à data atual
--    * Retorna todos os estágios cujo início está entre hoje e a data final

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `P2`(
    IN `numDias` INT
)
BEGIN
    DECLARE dataFinal DATE;

    IF (numDias < 0) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Numero de dias invalido';
    END IF;

    SET dataFinal = DATE_ADD(CURDATE(), INTERVAL numDias DAY);
    SELECT * FROM estagio 
    WHERE data_inicio BETWEEN CURDATE() AND dataFinal;
END$$
DELIMITER ;

--F1 * Como falado com o professor, recebe uma string no formato anoInicial/anoFinal
--   * A partir desse intervalo são consideradas apenas as classificações do ano letivo
--   * É garantida a não divisão por zero

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `F1`(`empresaID` INT, `estabID` INT, `ano` VARCHAR(150)) RETURNS double
BEGIN
DECLARE v_ano_inicio integer;
DECLARE v_ano_fim integer;
DECLARE v_data_inicio date;
DECLARE v_data_fim date;
DECLARE soma double;
DECLARE numero integer;

SET v_ano_inicio = CAST(SUBSTRING_INDEX(ano, '/', 1) AS UNSIGNED);
SET v_ano_fim = CAST(SUBSTRING_INDEX(ano, '/', -1) AS UNSIGNED);
SET v_data_inicio = STR_TO_DATE(CONCAT(v_ano_inicio, '-09-01'), '%Y-%m-%d');
SET v_data_fim = STR_TO_DATE(CONCAT(v_ano_fim, '-08-31'), '%Y-%m-%d');


SELECT SUM(classificacao) INTO soma FROM estagio WHERE estabelecimento_id = estabID AND estabelecimento_empresa_id = empresaID AND 
data_inicio <= v_data_fim AND data_fim >= v_data_inicio;

SELECT COUNT(classificacao) INTO numero FROM estagio WHERE estabelecimento_id = estabID AND estabelecimento_empresa_id = empresaID AND data_inicio <= v_data_fim AND data_fim >= v_data_inicio;

if(numero = 0) THEN
	return 0;
END if;

return round(soma/numero,2);
END$$
DELIMITER ;

-- F2 * Calcula a nota final de um aluno através de uma média ponderada
--    * As ponderações são valores reais entre 0 e 1
--    * A soma das ponderações é usada para normalizar o cálculo
--    * Evita divisão por zero e ponderações inválidas

DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `F2`(`empresaID` INT, `estabID` INT, `alunoID` INT, `pondEmpresa` DOUBLE, `pondEscola` DOUBLE, `pondRelatorio` DOUBLE, `pondProcura` DOUBLE) RETURNS double
BEGIN
DECLARE notaEmpresa DOUBLE;
DECLARE notaEscola DOUBLE;
DECLARE notaRelatorio DOUBLE;
DECLARE notaProcura DOUBLE;
DECLARE v_notaFinal DOUBLE;
DECLARE v_total_pesos DOUBLE;

if(pondEmpresa < 0 OR pondEmpresa > 1 OR pondEscola < 0 OR pondEscola > 1 OR pondRelatorio < 0 OR pondRelatorio > 1 OR pondProcura < 0 OR pondProcura > 1) THEN
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Ponderação Invalida';
END IF;

SET v_total_pesos = (pondEmpresa + pondEscola + pondRelatorio + pondProcura);

IF v_total_pesos = 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Soma das ponderações não pode ser zero';
END IF;

SELECT nota_empresa into notaEmpresa from estagio where estabelecimento_empresa_id = empresaID AND estabelecimento_id = estabID AND aluno_id = alunoID;

SELECT nota_escola into notaEscola from estagio where estabelecimento_empresa_id = empresaID AND estabelecimento_id = estabID AND aluno_id = alunoID;

SELECT nota_relatorio into notaRelatorio from estagio where estabelecimento_empresa_id = empresaID AND estabelecimento_id = estabID AND aluno_id = alunoID;

SELECT nota_procura into notaProcura from estagio where estabelecimento_empresa_id = empresaID AND estabelecimento_id = estabID AND aluno_id = alunoID;

SET v_notaFinal = (
    (IFNULL(notaEmpresa, 0) * pondEmpresa) +
    (IFNULL(notaEscola, 0) * pondEscola) +
    (IFNULL(notaRelatorio, 0) * pondRelatorio) +
    (IFNULL(notaProcura, 0) * pondProcura)
) / v_total_pesos;

return round(v_notaFinal,2);
END$$
DELIMITER ;

--Q1 * Agrupamos por utilizadorID pois podemos ter formadores com o mesmo nome o que foge do esperado para esta query *
--   * decidimos criar uma view pois esta query faz sentido ser reutilizada e nao é apenas uma pesquisa momentanea *

CREATE VIEW Q1 AS
SELECT u.nome, COUNT(*) AS NumeroEstagios
FROM estagio e, utilizador u
WHERE e.formador_id = u.utilizador_id
GROUP BY u.utilizador_id ,u.nome
HAVING COUNT(*) > 1

--Q2 * Muito parecida com a Q1, apenas com alguns pormenores diferentes. *
--   * Optou-se por criar uma VIEW, pois esta query pode ser reutilizada e não é apenas uma pesquisa momentânea. *


CREATE VIEW Q2 AS
SELECT e.firma, AVG(s.nota_empresa) AS mediaAlunos
FROM empresa e, estagio s
WHERE e.empresa_id = s.estabelecimento_empresa_id
GROUP BY e.empresa_id, e.firma
HAVING AVG(s.nota_empresa) >= 14

-- Q3 * Apesar de tambem ter sentido ser uma View optamos por não o fazer pois achamos que não será uma query usada muitas vezes *
--    * mas perante qualquer mudança na idea da Base de Dados criar uma query é extremamente facil *

SELECT e.firma, COUNT(DISTINCT c.produto_id) AS Nprodutos
FROM empresa e, comercializa c
WHERE e.empresa_id = c.estabelecimento_empresa_id
GROUP BY e.empresa_id, e.firma
HAVING COUNT(DISTINCT c.produto_id) >= 1;

--Q4 * Aqui ao contrario da anterior achamso que sera uma query utilizada muito mais vezes dado que é interessante saber o numero de estagios das empresas * 
--   * por isso optamos por uma View *

CREATE VIEW Q4 AS 
SELECT e.firma, COUNT(*) AS Nestagios 
FROM empresa e, estagio s 
WHERE e.empresa_id = s.estabelecimento_empresa_id 
GROUP BY e.empresa_id, e.firma 
HAVING COUNT(*) >= 1

-- Q5 * Cursos com número de turmas acima da média geral *
--    * Optou-se por não criar VIEW, pois a query provavelmente não será reutilizada muitas vezes *

SELECT c.designacao
FROM curso c, turma t
WHERE c.curso_id = t.curso_id
GROUP BY c.curso_id, c.designacao
HAVING COUNT(*) > (
    SELECT AVG(num)
	FROM (
        SELECT COUNT(*) AS num
		FROM turma 
		GROUP BY curso_id
    ) 
    AS soma
)

-- Q6 * Criamos uma VIEW para o Q6 pois achamos importante para o utilizador ter essa informação dos formadores *
--    * Dado isso, certamente esta query poderá ser chamada muitas vezes, sendo importante então ser uma VIEW *

CREATE VIEW Q6 AS
SELECT u.nome, AVG(nota_final) AS mediaFinal, (SELECT AVG(nota_final) FROM estagio) AS notaGlobal
FROM utilizador u, estagio e
WHERE u.utilizador_id = e.formador_id
GROUP BY e.formador_id, u.nome
HAVING AVG(nota_final) > (
    SELECT AVG(nota_final)
	FROM estagio
)

--V1 * Detalhes dos estágios orientados pelos formadores: *
--   * nome do formador, número de estágios, média das notas finais e média global de todas as notas *

CREATE VIEW V1 AS
SELECT u.nome, COUNT(*) AS Nestagios, ROUND(AVG(nota_final), 2) AS mediaFormador, (SELECT AVG(nota_final) FROM estagio) AS notaGlobal
FROM utilizador u, estagio e
WHERE u.utilizador_id = e.formador_id
GROUP BY e.formador_id, u.nome

--V2 * Média das notas finais de estágio de cada empresa, agrupadas por empresa e curso *

CREATE VIEW V2 AS
SELECT e.firma, c.designacao AS curso, AVG(s.nota_final) AS notaFinal
FROM empresa e, estagio s, aluno a, turma t, curso c
WHERE e.empresa_id = s.estabelecimento_empresa_id AND s.aluno_id = a.utilizador_id AND a.turma_id = t.turma_id AND t.curso_id = c.curso_id
GROUP BY e.empresa_id, e.firma, t.curso_id, c.designacao;