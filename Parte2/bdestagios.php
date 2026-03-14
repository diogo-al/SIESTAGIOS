<?php
class BDSIEstagios{
    var $conn;

    function ligarbd(){
        $this->conn = mysqli_connect("localhost","root","","bd2526");
        if(!$this->conn)
            return -1;
    }

    function executarSQL($sql_command) {
        $resultado = mysqli_query( $this->conn, $sql_command);
        return $resultado;
    }

    function numero_registos($tabela) { //numero de linhas
        $registos=0;
	    $rs=$this->executarSQL("SELECT * FROM $tabela");
        return mysqli_num_rows($rs);  
    }

    function fecharBD() {
        mysqli_close($this->conn);
    }
}

class Login{
    var $db_estagios;

    function Login(){
        $this->db_estagios = new BDSIEstagios();
        $this->db_estagios->ligarbd();
    }

    function verify($username,$password) {
        $rs = $this->db_estagios->executarSQL("SELECT * FROM utilizador WHERE login='$username' AND password='$password'");
        if(mysqli_num_rows($rs) == 0) {
            return false;
        }
        $user = mysqli_fetch_assoc($rs); 
        return ["user" => $user["login"], "tipo" => $user["tipo"], "nome" => $user["nome"]];
    }
    
    function fecharLogin(){
        $this->db_estagios->fecharBD();
    }
}

class pesquisaEmpresa{
    var $db_estagios;

    function pesquisaEmpresa(){
        $this->db_estagios = new BDSIEstagios();
        $this->db_estagios->ligarbd();
    }

    function search($ramo, $loc){
        if($ramo== "" && $loc == "") {
            $sql = "SELECT * FROM empresa e";
        }
        else if($ramo== "" && $loc != ""){
            $sql = "SELECT * FROM empresa e WHERE localidade COLLATE utf8mb4_unicode_ci LIKE '%$loc%'";
        }
        else if($ramo!="" && $loc == ""){
            $sql = "SELECT * FROM empresa e, trabalha t, ramo_atividade r 
            WHERE t.empresa_id = e.empresa_id AND r.ramo_atividade_id = t.ramo_atividade_id 
            AND r.descricao COLLATE utf8mb4_unicode_ci LIKE '%$ramo%'";
        }
        else if($ramo!="" && $loc != ""){
            $sql = "SELECT * FROM empresa e, trabalha t, ramo_atividade r
            WHERE t.empresa_id = e.empresa_id AND r.ramo_atividade_id = t.ramo_atividade_id AND 
            r.descricao COLLATE utf8mb4_unicode_ci LIKE '%$ramo%'  AND localidade COLLATE utf8mb4_unicode_ci LIKE '%$loc%'";
        }

        $rs = $this->db_estagios->executarSQL($sql);
        if(mysqli_num_rows($rs) == 0){
            if($ramo == "") $ramo = "Sem Filtro";
            if($loc == "") $loc = "Sem Filtro";
            printf("
            <div class = \"erroFiltro\">
            <h2>Não foram encontrados resultados para a sua pesquisa<br>Ramo de Atividade: %s<br>Localidade: %s</h2>
            </div>", $ramo, $loc);
        }
        else{
            echo "<table class = 'empresasTabelas'> \n";
            echo "<thead>";
            echo "<th>Nome</th><th>Tipo</th><th>Localidade</th><th>Telefone</th><th>Email</th>";
            echo "</thead>";
            echo "<tbody>";
            for($i=0; $i < mysqli_num_rows($rs); $i++){
                $row = mysqli_fetch_assoc( $rs );
                $sql2 = "SELECT * FROM disponibilidade WHERE empresa_id = " . $row["empresa_id"];
                $disp = mysqli_num_rows($this->db_estagios->executarSQL($sql2));

                if($disp > 0) printf("<tr onclick=\"window.location='detalhes.php?id=%d';\" style=\"cursor:pointer;\">",$row['empresa_id']);
                else printf("<tr style=\"cursor:not-allowed;\">");

                $this->escreveEmpresa($row["firma"],$row["tipo_organizacao"],$row["localidade"],$row["telefone"],$row["website"]);
                echo "</tr>\n";
            }
            echo "</tbody>";
            echo "</table>\n";
        }
    }

    function escreveEmpresa($nome, $tipo, $localidade, $telefone, $website){
        if($website== "") $website = "NA";
        printf("<td>$nome</td><td>$tipo</td><td>$localidade</td><td>$telefone</td><td>$website</td>");
    }

    function fecharPesquisa(){
        $this->db_estagios->fecharBD();
    }

    function consultaEstagios($id){
        $this->escreveEmpresaEstab($id);
        $estOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM estagio 
            WHERE estabelecimento_empresa_id = $id"
        );
        echo "<div class = 'tableContainer'>";
        echo "<table class = 'estagioTabela'>";
        echo "<thead>";
        printf("<th>Estabelecimento</th><th>Morada</th><th>Localidade</th><th>Nome<br>Resp.</th><th>Cargo<br>Resp.</th><th>Telemovel<br>Resp.</th><th>Email<br>Resp.</th><th>Meio<br>de<br>Transporte</th><th>Linha</th><th>Data Inicio</th><th>Data Fim</th>");
        echo "</thead>";
        echo "<tbody>";
        for($i=0; $i < mysqli_num_rows($estOutput); $i++){
            $row = mysqli_fetch_assoc( $estOutput);
            $estab = $this->estabInfo($row["estabelecimento_id"],$row["estabelecimento_empresa_id"]);
            $transp = $this->transpInfo($row["estabelecimento_id"],$row["estabelecimento_empresa_id"]);
            $resp = $this->respInfo($estab["responsavel_id"]);

            $meio = $transp["meio_transporte"] ?? "<i class='fa-solid fa-hourglass-start'></i>";
            $data_inicio = $row["data_inicio"] ?? "<i class='fa-solid fa-hourglass-start'></i>";
            $data_fim = $row["data_fim"] ?? "<i class='fa-solid fa-hourglass-start'></i>";
            $linha = $transp["linha"] ?? "<i class=\"fa-solid fa-hourglass-start\"></i>";

            echo "<tr>";
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
            $estab["nome_comercial"],
            $estab["morada"],
            $estab["localidade"],
            $resp["nome"],
            $resp["cargo"],
            $resp["telemovel"],
            $resp["email"],
            $meio,
            $linha,
            $data_inicio,
            $data_fim);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>"; 
        echo "</div>";
    }

    function estabInfo($id,$empresaID){
        $estabOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM estabelecimento 
            WHERE estabelecimento_id = $id AND empresa_id = $empresaID"
        );
        return mysqli_fetch_assoc($estabOutput);
    }

    function transpInfo($estID,$empresaID){
        $transOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM transporte t, servido s
            WHERE t.transporte_id = s.transporte_id AND s.estabelecimento_empresa_id = $empresaID AND s.estabelecimento_id = $estID"
        );
        return mysqli_fetch_assoc($transOutput);
    }

    function respInfo($id){
        $respOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM responsavel 
            WHERE responsavel_id = $id"
        );
        return mysqli_fetch_assoc($respOutput);
    }

    function escreveEmpresaEstab($id){
        $empOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM empresa e , trabalha t, ramo_atividade r 
            WHERE e.empresa_id = t.empresa_id AND t.ramo_atividade_id = r.ramo_atividade_id AND e.empresa_id = $id"
        );
        $empRes = mysqli_fetch_assoc($empOutput);
        printf("<center>
        <div class = \"Empresa\">
            <h2>Estagios da %s</h2>
            <p><i class=\"fa-solid fa-briefcase\"></i> Ramo de Atividade: %s</p>
            <p><i class=\"fa-solid fa-location-dot\"></i> Morada Sede: %s | Localidade: %s</p>
            <p><i class=\"fa-solid fa-phone\"></i> tel: %s</p>
        </div>
        </center>
        ", $empRes["firma"],$empRes["descricao"] , $empRes["morada_sede"], $empRes["localidade"], $empRes["telefone"]);
    }
}

class pesquisaEstagio{
    var $db_estagios;

    function pesquisaEstagio(){
        $this->db_estagios = new BDSIEstagios();
        $this->db_estagios->ligarbd();
    }

    function consultaEstagioAluno($login){
        $estagioInfo = $this->db_estagios->executarSQL("select * from estagio e, utilizador u, estabelecimento s, formador f 
        where e.aluno_id = u.utilizador_id AND s.estabelecimento_id = e.estabelecimento_id AND s.empresa_id = e.estabelecimento_empresa_id AND e.formador_id = f.utilizador_id 
        AND u.login = '$login'");
        echo "<table class = 'estagioTabela'>";
        echo "<thead>";
        printf("<th>Estabelecimento</th><th>Morada</th><th>Localidade</th><th>Nome Form.</th></th><th>Nome Resp.</th><th>Cargo Resp.</th><th>Telemovel Resp.</th><th>Email<br>Resp.</th><th>Meio de Transporte</th><th>Linha</th><th>Nota<br>Final</th>");
        echo "</thead>";
        echo "<tbody>";
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            $form = $this->consultaFormador($row["formador_id"]);
            $resp = $this->respInfo($row["responsavel_id"]);
            $transp = $this->transpInfo($row["estabelecimento_id"],$row["estabelecimento_empresa_id"]);

            $meio = $transp["meio_transporte"] ?? "<i class='fa-solid fa-hourglass-start'></i>";

            $linha = $transp["linha"] ?? "<i class=\"fa-solid fa-hourglass-start\"></i>";
            if($row["nota_final"] == null) $row["nota_final"] = "NA";
            echo "<tr>";
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",
            $row["nome_comercial"],
            $row["morada"],
            $row["localidade"],
            $form,
            $resp["nome"],
            $resp["cargo"],
            $resp["telemovel"],
            $resp["email"],
            $meio,
            $linha,
            $row["nota_final"],
            );
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    function respInfo($id){
        $respOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM responsavel 
            WHERE responsavel_id = $id"
        );
        return mysqli_fetch_assoc($respOutput);
    }

    function transpInfo($estID,$empresaID){
        $transOutput = $this->db_estagios->executarSQL(
            "SELECT * FROM transporte t, servido s
            WHERE t.transporte_id = s.transporte_id AND s.estabelecimento_empresa_id = $empresaID AND s.estabelecimento_id = $estID"
        );
        return mysqli_fetch_assoc($transOutput);
    }

    function consultaFormador($id){
        return mysqli_fetch_assoc($this->db_estagios->executarSQL("select nome from utilizador where utilizador_id = $id"))["nome"];
    }

    function fecharPesquisa(){
        $this->db_estagios->fecharBD();
    }

    function consultaEstagio(){
        $estagioInfo = $this->db_estagios->executarSQL("select * from estagio e, utilizador u, estabelecimento s, formador f 
        where e.aluno_id = u.utilizador_id AND s.estabelecimento_id = e.estabelecimento_id AND s.empresa_id = e.estabelecimento_empresa_id AND e.formador_id = f.utilizador_id
        ORDER BY e.aluno_id");
        echo "<div class = 'tableContainer'>";
        echo "<table class = 'estagioTabela'>";
        echo "<thead>";
        printf("<th>Numero</th><th>Nome</th><th>Estabelecimento</th><th>Formador</th><th>Inicio</th><th>Fim</th><th>Nota</th>");
        echo "</thead>";
        echo "<tbody>";
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            $form = $this->consultaFormador($row["formador_id"]);
            if($row["nota_final"] == null) $row["nota_final"] = "NA";
            echo "<tr>";
            printf("<td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td>",$row["aluno_id"],$row["nome"],$row["nome_comercial"],$form,$row["data_inicio"],$row["data_fim"], $row["nota_final"]);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }

    function inputEmpresa($selected){
        echo "<select name=\"empresa\" id=\"empresa\" onchange = \"window.location = 'registar.php?empresa=' + this.value;\">";
        if($selected == "NAN"){
            echo "<option value=\"0\">Selecione uma Empresa</option>";
        }
        else{
            $aux =mysqli_fetch_assoc($this->db_estagios->executarSQL("select * from empresa where empresa_id = $selected"))["firma"];
            echo "<option value=\"$selected\">$aux</option>";
            echo "<option value=\"0\">Selecione uma Empresa</option>";
        }

        $estagioInfo = $this->db_estagios->executarSQL("select * from empresa");
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            printf("<option value=%d>%s</option>", $row["empresa_id"],$row["firma"]);
        }
        echo "</select>";
        echo "<br>";
        echo "<span class = \"linha\"></span>";
    }

    function inputEstabelecimento($empresa){
        echo "<select name=\"estabelecimento\" id=\"estabelecimento\">";
        echo "<option value=\"\">Selecione um Estabelecimento</option>";
        if($empresa==" "){
            echo "</select>";
            echo "<br>";
            echo "<span class = \"linha\"></span>";
            return;
        }
        else     
            $sql = "select * from estabelecimento e, empresa s where e.empresa_id = s.empresa_id AND e.empresa_id = $empresa";
        
        $estagioInfo = $this->db_estagios->executarSQL($sql);
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            printf("<option value=%d>%s</option>", $row["estabelecimento_id"],$row["nome_comercial"]);
        }
        echo "</select>";
        echo "<br>";
        echo "<span class = \"linha\"></span>";
    }


    function inputAluno(){
        echo "<select name=\"aluno\" id=\"aluno\">";
        echo "<option value=\"\">Selecione um Aluno</option>";
        $estagioInfo = $this->db_estagios->executarSQL("select * from utilizador u, aluno a WHERE u.utilizador_id = a.utilizador_id");
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            printf("<option value=%d>%s</option>", $row["utilizador_id"],$row["nome"]);
        }
        echo "</select>";
        echo "<br>";
        echo "<span class = \"linha\"></span>";
    }

    function inputFormador(){
        echo "<select name=\"formador\" id=\"formador\">";
        echo "<option value=\"\">Selecione um Formador</option>";
        $estagioInfo = $this->db_estagios->executarSQL("select * from utilizador u, formador f WHERE u.utilizador_id = f.utilizador_id");
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            printf("<option value=%d>%s</option>", $row["utilizador_id"],$row["nome"]);
        }
        echo "</select>";
        echo "<span class = \"linha\"></span>";
    }

    function registarEstagio($empresaID, $estabelecimentoID, $alunoID, $formadorID, $data){
        try{
            $output = $this->db_estagios->executarSQL("INSERT INTO estagio (estabelecimento_empresa_id, estabelecimento_id, aluno_id, formador_id, data_inicio)
                VALUES ($empresaID, $estabelecimentoID, $alunoID, $formadorID, '$data')");
            printf("<p><i class=\"fa-solid fa-circle-check\"></i> Estágio criado com sucesso!<br>Empresa ID: %d | Estabelecimento ID: %d | Aluno ID: %s | Formador ID: %d | Data de Início: %s</p>",
                $empresaID,
                $estabelecimentoID,
                $alunoID,
                $formadorID,
                $data);
        }
        catch (mysqli_sql_exception $e) {
           printf("<i class=\"fa-solid fa-circle-exclamation\"></i> Erro ao criar o estágio! | Empresa ID: %d | Estabelecimento ID: %d | Aluno ID: %s | Formador ID: %d | Data de Início: %s<br>Mensagem de Erro: %s",
            $empresaID,
            $estabelecimentoID,
            !empty($alunoID) ? $alunoID : "N/A",
            $formadorID,
            $data,
            mysqli_error($this->db_estagios->conn));
        }
    }

    function consultaEstagiosEditaveis(){
        $estagioInfo = $this->db_estagios->executarSQL("select * from estagio e, utilizador u, estabelecimento s, formador f 
        where e.aluno_id = u.utilizador_id AND s.estabelecimento_id = e.estabelecimento_id AND s.empresa_id = e.estabelecimento_empresa_id AND e.formador_id = f.utilizador_id
        AND (curdate()<e.data_fim OR e.data_fim IS NULL) ORDER BY e.aluno_id");
        echo "<table class = 'estagioTabela'>";
        echo "<thead>";
        printf("<th>Numero</th><th>Nome</th><th>Estabelecimento</th><th>Formador</th><th>Inicio</th><th>Fim</th><th>Nota</th>");
        echo "</thead>";
        echo "<tbody>";
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            $form = $this->consultaFormador($row["formador_id"]);
            printf("<tr onclick = \"window.location = 'efetuarEdicao.php?estabelecimento_empresa_id=%d&estabelecimento_id=%d&aluno_id=%d&formador_id=%d&data_inicio=%s'\">", $row["estabelecimento_empresa_id"],$row["estabelecimento_id"],$row["aluno_id"],$row["formador_id"],$row["data_inicio"]);
            printf("<td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td>",$row["aluno_id"],$row["nome"],$row["nome_comercial"],$form,$row["data_inicio"],$row["data_fim"], $row["nota_final"]);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    function consultaEstagiosApagaveis(){
        $estagioInfo = $this->db_estagios->executarSQL("select * from estagio e, utilizador u, estabelecimento s, formador f 
        where e.aluno_id = u.utilizador_id AND s.estabelecimento_id = e.estabelecimento_id AND s.empresa_id = e.estabelecimento_empresa_id AND e.formador_id = f.utilizador_id
        AND (curdate()<e.data_fim OR e.data_fim IS NULL) ORDER BY e.aluno_id");
        echo "<table class = 'estagioTabela'>";
        echo "<thead>";
        printf("<th>Numero</th><th>Nome</th><th>Estabelecimento</th><th>Formador</th><th>Inicio</th><th>Fim</th><th>Nota</th>");
        echo "</thead>";
        echo "<tbody>";
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            $form = $this->consultaFormador($row["formador_id"]);
            printf("<tr onclick = \"window.location = 'efetuarEliminacao.php?estabelecimento_empresa_id=%d&estabelecimento_id=%d&aluno_id=%d'\">", $row["estabelecimento_empresa_id"],$row["estabelecimento_id"],$row["aluno_id"]);
            printf("<td>%d</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%d</td>",$row["aluno_id"],$row["nome"],$row["nome_comercial"],$form,$row["data_inicio"],$row["data_fim"], $row["nota_final"]);
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }
}

class editaEstagio{
    var $db_estagios;

    function editaEstagio(){
        $this->db_estagios = new BDSIEstagios();
        $this->db_estagios->ligarbd();
    }
    function fecharPesquisa(){
        $this->db_estagios->fecharBD();
    }

    function inputEmpresa($selected){
        echo "<select name=\"empresa\" id=\"empresa\" onchange = \"window.location = 'registar.php?empresa=' + this.value;\">";
        if($selected == "NAN"){
            echo "<option value=\"0\">Selecione uma Empresa</option>";
        }
        else{
            $aux =mysqli_fetch_assoc($this->db_estagios->executarSQL("select * from empresa where empresa_id = $selected"))["firma"];
            echo "<option value=\"$selected\">$aux</option>";
            echo "<option value=\"0\">Selecione uma Empresa</option>";
        }

        $estagioInfo = $this->db_estagios->executarSQL("select * from empresa");
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            printf("<option value=%d>%s</option>", $row["empresa_id"],$row["firma"]);
        }
        echo "</select>";
        echo "<br>";
        echo "<span class = \"linha\"></span>";
    }

    function inputEstabelecimento($empresa,$estabelecimentoID){
        echo "<select name=\"estabelecimento\" id=\"estabelecimento\">";
        $aux =mysqli_fetch_assoc($this->db_estagios->executarSQL("select * from estabelecimento 
        where estabelecimento_id = $estabelecimentoID AND empresa_id = $empresa"))["nome_comercial"];
        echo "<option value=\"$estabelecimentoID\">$aux</option>";
        echo "<option value=\"0\">Selecione uma Estabelecimento</option>";
        if($empresa==" "){
            echo "</select>";
            echo "<br>";
            echo "<span class = \"linha\"></span>";
            return;
        }
        else     
            $sql = "select * from estabelecimento e, empresa s where e.empresa_id = s.empresa_id AND e.empresa_id = $empresa";
        
        $estagioInfo = $this->db_estagios->executarSQL($sql);
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            if($row["estabelecimento_id"] != $estabelecimentoID)
                printf("<option value=%d>%s</option>", $row["estabelecimento_id"],$row["nome_comercial"]);
        }
        echo "</select>";
        echo "<br>";
        echo "<span class = \"linha\"></span>";
    }


    function inputAluno($alunoID){
        echo "<select name=\"aluno\" id=\"aluno\">";
        $aux =mysqli_fetch_assoc($this->db_estagios->executarSQL("select * from aluno a, utilizador u 
        where u.utilizador_id = a.utilizador_id AND a.utilizador_id = $alunoID"))["nome"];
        echo "<option value=\"$alunoID\">$aux</option>";
        echo "<option value=\"0\">Selecione um Aluno</option>";
        $estagioInfo = $this->db_estagios->executarSQL("select * from utilizador u, aluno a WHERE u.utilizador_id = a.utilizador_id");
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            if($row["utilizador_id"] != $alunoID)
                printf("<option value=%d>%s</option>", $row["utilizador_id"],$row["nome"]);
        }
        echo "</select>";
        echo "<br>";
        echo "<span class = \"linha\"></span>";
    }

    function inputFormador($formadorID){
        echo "<select name=\"formador\" id=\"formador\">";
        $aux =mysqli_fetch_assoc($this->db_estagios->executarSQL("select * from formador a, utilizador u 
        where u.utilizador_id = a.utilizador_id AND a.utilizador_id = $formadorID"))["nome"];
        echo "<option value=\"$formadorID\">$aux</option>";
        echo "<option value=\"0\">Selecione um Formador</option>";
        $estagioInfo = $this->db_estagios->executarSQL("select * from utilizador u, formador f WHERE u.utilizador_id = f.utilizador_id");
        for($i = 0; $i<mysqli_num_rows($estagioInfo); $i++){
            $row = mysqli_fetch_assoc($estagioInfo);
            if($row["utilizador_id"] != $formadorID)
                printf("<option value=%d>%s</option>", $row["utilizador_id"],$row["nome"]);
        }
        echo "</select>";
        echo "<span class = \"linha\"></span>";
    }    

    function editarEstagio($OempresaID, $OestabelecimentoID, $OalunoID,$empresaID, $estabelecimentoID, $alunoID, $formadorID, $data){
        try{
            $output = $this->db_estagios->executarSQL("UPDATE estagio SET 
            	estabelecimento_empresa_id = $empresaID,
                estabelecimento_id  = $estabelecimentoID,
                aluno_id = $alunoID,
                formador_id = $formadorID,
                data_inicio = '$data'
                WHERE
                estabelecimento_empresa_id = $OempresaID AND estabelecimento_id  = $OestabelecimentoID AND aluno_id = $OalunoID
            ");
            printf("<p><i class=\"fa-solid fa-circle-check\"></i> Estágio Editado com sucesso!<br>Empresa ID: %d | Estabelecimento ID: %d | Aluno ID: %s | Formador ID: %d | Data de Início: %s</p>",
                $empresaID,
                $estabelecimentoID,
                $alunoID,
                $formadorID,
                $data);
        }
        catch (mysqli_sql_exception $e) {
           printf("<i class=\"fa-solid fa-circle-exclamation\"></i> Erro ao Editar o estágio! | Empresa ID: %d | Estabelecimento ID: %d | Aluno ID: %s | Formador ID: %d | Data de Início: %s<br>Mensagem de Erro: %s",
            $empresaID,
            $estabelecimentoID,
            !empty($alunoID) ? $alunoID : "N/A",
            $formadorID,
            $data,
            mysqli_error($this->db_estagios->conn));
        }
    }

    function apagarEstagio($empresaID, $estabelecimentoID, $alunoID){
        try{
            $output = $this->db_estagios->executarSQL("DELETE FROM estagio
                WHERE
                estabelecimento_empresa_id = $empresaID AND estabelecimento_id  = $estabelecimentoID AND aluno_id = $alunoID
            ");
            printf("<p><i class=\"fa-solid fa-circle-check\"></i> Estágio Apagado com sucesso!<br>Empresa ID: %d | Estabelecimento ID: %d | Aluno ID: %s</p>",
                $empresaID,
                $estabelecimentoID,
                $alunoID);
        }
        catch (mysqli_sql_exception $e) {
           printf("<i class=\"fa-solid fa-circle-exclamation\"></i> Erro ao Apagar o estágio! | Empresa ID: %d | Estabelecimento ID: %d | Aluno ID: %s",
            $empresaID,
            $estabelecimentoID,
            !empty($alunoID) ? $alunoID : "N/A",
            mysqli_error($this->db_estagios->conn));
        }
    }
}

class modificarAluno{
    var $db_estagios;

    function modificarAluno(){
        $this->db_estagios = new BDSIEstagios();
        $this->db_estagios->ligarbd();
    }
    function fecharPesquisa(){
        $this->db_estagios->fecharBD();
    }

    function adicionarAluno($nome,$login,$password,$turma){
        $max = mysqli_fetch_assoc($this->db_estagios->executarSQL("SELECT MAX(utilizador_id) AS max FROM utilizador"))["max"];
        $max++;
        $maxNumAluno = mysqli_fetch_assoc($this->db_estagios->executarSQL("SELECT MAX(numero) AS max FROM aluno"))["max"];
        $maxNumAluno++;
        $siglaTurma = mysqli_fetch_assoc($this->db_estagios->executarSQL("SELECT sigla FROM turma WHERE turma_id = $turma"))["sigla"];
        try{
            $output1 = $this->db_estagios->executarSQL("INSERT INTO utilizador VALUES ($max,'$login','$password','$nome','aluno')");
            $output2 = $this->db_estagios->executarSQL("INSERT INTO aluno VALUES ($turma,$max,$maxNumAluno,NULL)");
            printf("<p><i class=\"fa-solid fa-circle-check\"></i> Aluno inserido com sucesso!<br>Nome: %s | Login: %s | utilizadorID: %d | numero: %d | turma: %s</p>",
                $nome,
                $login,
                $max,
                $maxNumAluno,
                $siglaTurma);
        }
        catch (mysqli_sql_exception $e) {
           printf("<p><i class=\"fa-solid fa-circle-exclamation\"></i> Erro ao Inserir aluno!<br>Nome: %s | Login: %s | utilizadorID: %d | numero: %d | turma: %s <br> Codigo de erro: %s</p>",
                $nome,
                $login,
                $max,
                $maxNumAluno,
                $siglaTurma,
            mysqli_error($this->db_estagios->conn));
        }
    }

    function inputTurma(){
        echo "<select name=\"turma\" id=\"turma\">";
        echo "<option value=\"\">selecione a turma</option>";
        $turmaInfo = $this->db_estagios->executarSQL("select * from turma");
        for($i = 0; $i<mysqli_num_rows($turmaInfo); $i++){
            $row = mysqli_fetch_assoc($turmaInfo);
            printf("<option value=%d>%s</option>", $row["turma_id"],$row["sigla"]);
        }
        echo "</select>";
        echo "<span class = \"linha\"></span>";
    }

    function mostraAlunos($user){
        $alunosInfo = $this->db_estagios->executarSQL("SELECT * FROM estagio e, empresa s, estabelecimento z, utilizador u 
        WHERE e.estabelecimento_empresa_id = s.empresa_id AND e.estabelecimento_id = z.estabelecimento_id AND s.empresa_id = z.empresa_id 
        AND u.utilizador_id = e.formador_id AND u.login = '$user' AND e.data_fim IS NOT NULL AND e.data_fim < curdate()");

        echo "<table class = \"formadorTabela\">";
        echo "<thead>";
        echo "<th>Empresa</th><th>Estabelecimento</th><th>Nome Aluno</th><th>Nome Formador</th>";
        echo "</thead>";
        echo "<tbody>";
        for($i = 0; $i<mysqli_num_rows($alunosInfo); $i++){
            $row = mysqli_fetch_assoc($alunosInfo);
            printf("<tr onclick='window.location = \"modificaNota.php?emp=%d&est=%d&aln=%d\"'>",$row["empresa_id"],$row["estabelecimento_id"],$row["aluno_id"]);
            printf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td>",$row["firma"],$row["nome_comercial"],$this->alunoNome($row["aluno_id"]),$this->formadorNome($row["formador_id"]));
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    function formadorNome($formadorID){
        return mysqli_fetch_assoc($this->db_estagios->executarSQL("SELECT * FROM utilizador WHERE utilizador_id = $formadorID"))["nome"];
    }

    function alunoNome($alunoID){
        return mysqli_fetch_assoc($this->db_estagios->executarSQL("SELECT * FROM utilizador WHERE utilizador_id = $alunoID"))["nome"];
    }

    function mostrarNotas($empresa, $estabelecimento, $aluno){
        $notasInfo = $this->db_estagios->executarSQL("SELECT * FROM estagio e, empresa s, estabelecimento z 
        WHERE e.estabelecimento_empresa_id = s.empresa_id AND e.estabelecimento_id = z.estabelecimento_id AND s.empresa_id = z.empresa_id
        AND e.estabelecimento_empresa_id = $empresa AND e.estabelecimento_id= $estabelecimento AND e.aluno_id=$aluno");

        $row = mysqli_fetch_assoc($notasInfo);
        echo "<p>Nota da Empresa</p>";
        printf("<input type=\"number\" min=\"0\" max=\"20\" oninput=\"if (this.value > 20) this.value = 20; if (this.value < 0) this.value = 0;\" name=\"empresa\" id=\"empresa\", value=%d>", $row["nota_empresa"]);
        echo "<br>";
        echo "<p>Nota da Escola</p>";
        printf("<input type=\"number\" min=\"0\" max=\"20\" oninput=\"if (this.value > 20) this.value = 20; if (this.value < 0) this.value = 0;\" name=\"escola\" id=\"escola\", value=%d>", $row["nota_escola"]);
        echo "<br>";
        echo "<p>Nota da Procura</p>";
        printf("<input type=\"number\" min=\"0\" max=\"20\" oninput=\"if (this.value > 20) this.value = 20; if (this.value < 0) this.value = 0;\" name=\"procura\" id=\"procura\", value=%d>", $row["nota_procura"]);
        echo "<br>";
        echo "<p>Nota do Relatorio</p>";
        printf("<input type=\"number\" min=\"0\" max=\"20\" oninput=\"if (this.value > 20) this.value = 20; if (this.value < 0) this.value = 0;\" name=\"relatorio\" id=\"relatorio\", value=%d>", $row["nota_relatorio"]);
    }

    function aplicaNotas($empresa, $estabelecimento, $aluno, $emp, $escola, $procura, $relatorio){
        try{
            $notaMedia = (double)($emp + $escola + $procura + $relatorio)/4;
            $this->db_estagios->executarSQL("UPDATE estagio SET 
            nota_empresa = $emp,
            nota_escola = $escola,
            nota_procura = $procura,
            nota_relatorio = $relatorio,
            nota_final = round($notaMedia, 2)
            WHERE estabelecimento_empresa_id = $empresa AND estabelecimento_id= $estabelecimento AND aluno_id=$aluno");
            printf("<p>Notas do aluno %s Foram alteradas com sucesso para: <br><br> Nota Empresa: %d | Nota Escola: %d | Nota Procura: %d | Nota Relatorio: %d <br><br> Nota Final: %.2f</p>",
            $this->alunoNome($aluno),$emp, $escola, $procura, $relatorio, round($notaMedia, 2));
        }
        catch (mysqli_sql_exception $e) {
           printf("<p>Notas do aluno %s Foram alteradas sem sucesso tentativa: <br> Nota Empresa: %d | Nota Escola: %d | Nota Procura: %d | Nota Relatorio: %d <br> Erro: %s</p>",
            $this->alunoNome($aluno),$emp, $escola, $procura, $relatorio,
            mysqli_error($this->db_estagios->conn));
        }
    }

}

class alterarConta{
    var $db_estagios;

    function alterarConta(){
        $this->db_estagios = new BDSIEstagios();
        $this->db_estagios->ligarbd();
    }
    function fecharPesquisa(){
        $this->db_estagios->fecharBD();
    }

    function alterarUsername($user, $username){
        try{
            $this->db_estagios->executarSQL("UPDATE utilizador SET login = '$username' WHERE login = '$user'");
            printf("<h2 class = \"userText\"><i class=\"fa-solid fa-circle-check\"></i> Username Alterado com Sucesso para %s</h2>", $username);
            return 0;
        }
        catch (mysqli_sql_exception $e) {
           printf("<h2 class = \"userText\"><i class=\"fa-solid fa-triangle-exclamation\"></i> Erro a alterar o username para %s <br> Erro: %s</h2>",$username,
            mysqli_error($this->db_estagios->conn));
            return 1;
        }
    }

    function alterarName($user, $name){
        try{
            $this->db_estagios->executarSQL("UPDATE utilizador SET nome = '$name' WHERE login = '$user'");
            printf("<h2 class = \"userText\"><i class=\"fa-solid fa-circle-check\"></i> Nome Alterado com Sucesso para: <br> %s</h2>", $name);
            return 0;
        }
        catch (mysqli_sql_exception $e) {
           printf("<h2 class = \"userText\"><i class=\"fa-solid fa-triangle-exclamation\"></i> Erro a alterar o Nome para: <br> %s <br> Erro: %s</h2>",$name,
            mysqli_error($this->db_estagios->conn));
            return 1;
        }
    }

    function alterarPassword($user, $old, $new){
        try{
            $rs = $this->db_estagios->executarSQL("SELECT * FROM utilizador WHERE login='$user' AND password='$old'");
            if(mysqli_num_rows($rs) == 0) {
                return 3;
            }
            $this->db_estagios->executarSQL("UPDATE utilizador SET password = '$new' WHERE login = '$user'");
            printf("<h2 class = \"userText\"><i class=\"fa-solid fa-circle-check\"></i> Password Alterada com Sucesso</h2>");
            return 0;
        }
        catch (mysqli_sql_exception $e) {
           printf("<h2 class = \"userText\"><i class=\"fa-solid fa-triangle-exclamation\"></i> Erro a alterar a Password <br> Erro: %s</h2>",
            mysqli_error($this->db_estagios->conn));
            return 1;
        }
    }
}
?>