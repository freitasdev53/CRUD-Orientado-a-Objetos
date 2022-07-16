<?php
include"bd_oo.php";
class Crud extends DB{
    //METODO QUE INSERE OS DADOS
    public function inserirDatabase($nome,$email){
        return mysqli_query(self::conectarDatabase(),"INSERT INTO clientes (Nome,Email) VALUES('$nome','$email')");
    }
    //METODO QUE EDITA OS DADOS
    public function editarDatabase($nome,$email,$id){
        return mysqli_query(self::conectarDatabase(),"UPDATE clientes SET nome = '$nome', email = '$email' WHERE id = '$id' ");
    }
    //METODO QUE EXCLUIR OS DADOS
    public function excluirDatabase($id){
        return mysqli_query(self::conectarDatabase(),"DELETE FROM clientes WHERE id = '$id'");
    }
}
//INSTANCIA A CLASSE
$crud = new Crud();
//COLETANDO DADOS DO FORMULARIO
if(isset($_POST["salvar"])){
    //ARMAZENA OS VALORES "CADASTRAR" OU "EDITAR"
    $v_metodo = $_POST["salvar"];
    //CONFERE SE E CADASTRAR OU EDITAR
    if($v_metodo == "Cadastrar"){
    $crud->inserirDatabase($_POST["nome"],$_POST["email"]);
    }else{
        $id = $_GET["id"];
        if($crud->editarDatabase($_POST["nome"],$_POST["email"],$id)){
            header("location:index.php");
        }
    }
    //
}
//
if(isset($_GET["excluir"])){
    $id = $_GET["excluir"];
    if($crud->excluirDatabase($id)){
        header("location:index.php");
    }
}
?>
<!Doctype HTML>
<html lang="pt-br">
    <head>
        <title>Cadastro de clientes</title>
        <style>
            *{
                text-decoration:none;
            }
            body{
                margin:0;
            }
            form{
                width:100%;
                display:flex;
                justify-content:center;
                background:yellowgreen;
            }
            form input,label{
                margin:10px;
            }
            form input{
                padding:5px;
                border:solid white;
                width:500px;
            }
            .tabela{
                display:flex;
                justify-content:center;
            }
            .tabela table{
                width:50%;
                text-align:center;
                border:solid yellowgreen;
            }
            thead{
                background:yellowgreen;
            }
        </style>
    </head>
    <body>
        <form action="" method="POST">
            <?php
            if(isset($_GET["id"])){
                $id = $_GET["id"];
                $v_editar = mysqli_query($crud->conectarDatabase(),"SELECT * FROM clientes WHERE id = '$id' ");
                $v_edita = mysqli_fetch_assoc($v_editar);
                $v_nome = $v_edita['Nome'];
                $v_email = $v_edita['Email'];
                $v_campo = "Editar";
            }else{
                $v_nome = "";
                $v_email = "";
                $v_campo = "Cadastrar";
            }
            ?>
            <label for="nome">Nome:</label>
            <br>
            <input type="name" name="nome" id="nome" value="<?php echo $v_nome;?>">
            <label for="nome">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $v_email;?>">
            <input type="submit" name="salvar" value="<?php echo $v_campo;?>">

        </form>
    </body>
    <br>
    <div class="tabela">
    <table border>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Opções</th>
        </tr>
        </thead>
        <?php
            $v_SQL = mysqli_query($crud->conectarDatabase(),"SELECT * FROM Clientes");
            while($v_exibe = mysqli_fetch_assoc($v_SQL)){
            ?>
        <tbody>
        <tr>

            <td><?php echo $v_exibe["Nome"];?></td>
            <td><?php echo $v_exibe["Email"];?></td>
            <td>
                <a href="index.php?excluir=<?php echo $v_exibe['id'];?>">Excluir</a>
                <a href="index.php?id=<?php echo $v_exibe['id'];?>">Editar</a>
            </td>

        </tr>
        </tbody>
        <?php
            }
            ?>
    </table>
    </div>
</html>