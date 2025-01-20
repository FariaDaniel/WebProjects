<?php

	require "./bibliotecas/PHPMailer/Exception.php";
	require "./bibliotecas/PHPMailer/OAuth.php";
	require "./bibliotecas/PHPMailer/PHPMailer.php";
	require "./bibliotecas/PHPMailer/POP3.php";
	require "./bibliotecas/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	//print_r($_POST);

	class Mensagem {
		private $para = null;
		private $assunto = null;
		private $mensagem = null;
        public $status = array('codigo_status' => null, 'descricao_status' => '');

		public function __get($atributo) {
			return $this->$atributo;
		}

		public function __set($atributo, $valor) {
			$this->$atributo = $valor;
		}

		public function mensagemValida() {
			if(empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
				return false;
			}

			return true;
		}
	}

	$mensagem = new Mensagem();

	$mensagem->__set('para', $_POST['para']);
	$mensagem->__set('assunto', $_POST['assunto']);
	$mensagem->__set('mensagem', $_POST['mensagem']);

	//print_r($mensagem);

	if(!$mensagem->mensagemValida()) {
		echo 'Mensagem não é válida';
        header('Location: index.php');
	}

	$mail = new PHPMailer(true);
	try {
			//Server settings
			$mail->SMTPDebug = 0;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'SeuEmail@gmail.com';              //SMTP username /seu email
			$mail->Password   = 'SuaSenha';                               //SMTP password /Secnha criada no Gmail,para aplicativos menos seguros
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged PHPMailer::ENCRYPTION_STARTTLS
			$mail->Port       = 587;                                    //TCP port to connect to, use 465 for above/ 587 usada pelo Gmail

			//Recipients
			$mail->setFrom('SeuEmail@gmail.com', 'Seu Nome'); //Remetente
			$mail->addAddress($mensagem->__get('para'), $mensagem->__get('assunto') );     //Add a recipient
			//$mail->addReplyTo('info@example.com', 'Information'); //Podemos adicionar quantos destinatario forem necessario fazer sempre o uso do metodo addAddress
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');

			//Attachments
			//$mail->addAttachment('/var/tmp/file.tar.gz');         //Add Anexos 
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name Assinatura
 
			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject =  $mensagem->__get('assunto');        // 'Oi. Eu sou o assunto'
			$mail->Body    =  $mensagem->__get('mensagem');       //'Oi. Eu sou o conteúdo do e-mail'
			$mail->AltBody = 'É necessario que use um navegador que suporte HTML para ter acesso total ao conteudo dessa mensagem';

            $mail->send();

            $mensagem->status['codigo_status'] = 1;
            $mensagem->status['descricao_status'] = 'E-mail enviado com sucesso!';

	} catch (Exception $e) {
            $mensagem->status['codigo_status'] = 2;
            $mensagem->status['descricao_status'] = 'Não foi possivel enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro: ' . $mail->ErrorInfo;
        }
?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>App Mail Send</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">  
            <div class="py-3 text-center">
                <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
                <h2>Send Mail</h2>
                <p class="lead">Seu app de envio de e-mails particular!</p>
            </div>
            <div class="row">
                <div class ="col-md-12">
                    <?php if($mensagem->status['codigo_status'] == 1) { ?>
                        <div class="container">
                            <h1 class="display-4 text-success">Sucesso</h1>
                            <p><?= $mensagem->status['descricao_status'] ?></p>
                            <a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
                        </div>
                    <?php } ?>

                    <?php if($mensagem->status['codigo_status'] == 2) { ?>
                        <div class="container">
                            <h1 class="display-4 text-danger">Ops!</h1>
                            <p><?= $mensagem->status['descricao_status'] ?></p>
                            <a href="index.php" class="btn btn-danger btn-lg mt-5 text-white">Voltar</a>
                        </div>
                    <?php } ?>

                </div>

            </div>
        </div>    
    </body>
</html>
