<?php

    function enviarEmailUser($emailUser, $assunto, $mensagem)
    {

        $servidor = "smtp.hostinger.com.br";
        $porta = 587;
        $usuarioServidor = "no-reply@trocoperfumes.com";
        $senhaServidor = "projetoTP369";

        $emailusuario = $emailUser;

        require_once("classes/phpMailer/class.phpmailer.php"); //Aqui vem o diretório da classe.
        
        $mail = new PHPMailer();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPDebug = 0; // enables SMTP debug information (for testing)

        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->Host = $servidor; // sets the SMTP server
        $mail->Port = $porta; // set the SMTP port for the GMAIL server

        $mail->Username = $usuarioServidor; // SMTP account username
        $mail->Password = $senhaServidor; // SMTP account password

        $mail->SetFrom($usuarioServidor, $assunto);

        $mail->Subject = $assunto; //assunto

        $mail->AltBody = "Para ler esta mensagem, por favor utilize um leitor que suporte HTML"; // optional, comment out and test

        $mail->MsgHTML($mensagem);

        $mail->AddAddress($emailusuario); //Primeiro parâmetro email do usuário e segundo nome.
        
        if ($mail->Send()) 
        {
            ?>
            
                <script>
                    alert("Enviamos para seu e-mail informações de como redefinir a senha !!!");
                    
                    window.location="https://trocoperfumes.com/index.php";
                </script>
                
            <?php
            
            // header('Location: loginAluno.php');

        } 
        else 
        {
            ?>
            
                <script>
                    alert("Não encontramos nenhum dado semelhante em nossos registros! Verifique se os dados informados estão corretos !!!");
                    
                    window.location="https://trocoperfumes.com/verificaUser.php";
                </script>
                
            <?php
            
        }
    }

    function enviarEmailNotificacao($emailUser, $assunto, $mensagem)
    { 

        $servidor = "smtp.hostinger.com.br";
        $porta = 587;
        $usuarioServidor = "notifier_tp@trocoperfumes.com";
        $senhaServidor = "projetoTP369";

        $emailusuario = $emailUser;

        require_once("classes/phpMailer/class.phpmailer.php"); //Aqui vem o diretório da classe.
        
        $mail = new PHPMailer();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPDebug = 0; // enables SMTP debug information (for testing)

        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->Host = $servidor; // sets the SMTP server
        $mail->Port = $porta; // set the SMTP port for the GMAIL server

        $mail->Username = $usuarioServidor; // SMTP account username
        $mail->Password = $senhaServidor; // SMTP account password

        $mail->SetFrom($usuarioServidor, $assunto);

        $mail->Subject = $assunto; //assunto

        $mail->AltBody = "Para ler esta mensagem, por favor utilize um leitor que suporte HTML"; // optional, comment out and test

        $mail->MsgHTML($mensagem);

        $mail->AddAddress($emailusuario); //Primeiro parâmetro email do usuário e segundo nome.
        
        if ($mail->Send()) 
        {
            ?>
            
                <script>
                    alert("PRPOSTA ENVIADA COM SUCESSO !!!");
                    
                    window.location="https://trocoperfumes.com/feed.php";
                </script>
                
            <?php
        } 
        else 
        {
            ?>
            
                <script>
                    alert("Não foi possível enviar solicitar a proposta. Houve um erro se o erro perssistir entre com contato !!!");
                    
                    window.location="https://trocoperfumes.com/feed.php";
                </script>
                
            <?php
            
        }
    }
    
?>