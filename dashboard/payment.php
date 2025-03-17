<?php
error_reporting(0);
  include("../payments/conexao.php");

  $access_token = "APP_USR-1663936105125142-022115-3db87b7c74f4670a7e46acb5e91288dc-1280049306";

  if(isset($_POST)){

    if(isset($_POST['pix'])){

      if($_POST['pix']){




        $valor2 = $_POST["valor"];

        if($valor2 === "Mensal"){
          $valor = "45";
        }if($valor2 === "Semanal"){
            $valor = "30";
        }if($valor2 === "Diario"){
            $valor = "20";
        }
        
        

        $usuario = $_POST['usuario'];

        $sql = "SELECT count(*) as total from usuarios where usuario = '$usuario'";
        $result = mysqli_query($conexao, $sql);
        $row = mysqli_fetch_assoc($result);
      
        
        if($row['total'] == 1) {
          $json = array("success" => false, "message" => "Usuário já Cadastrado.");
          die(json_encode($json));
          exit();
        }

        include_once '../mercadopago/lib/mercadopago/vendor/autoload.php';

        MercadoPago\SDK::setAccessToken($access_token);


  			$payment = new MercadoPago\Payment();
  			$payment->description = 'Pagamento Nome';
  			$payment->transaction_amount = (double)$valor;
  			$payment->payment_method_id = "pix";

  			$payment->notification_url   = 'https://testes.infoccbr.shop/pagamentos/index.php';
  			$payment->external_reference = '1520';

        $payment->payer = array(
          "email" => "test@test.com",
          "first_name" => "Test",
          "last_name" => "User",
          "identification" => array(
              "type" => "CPF",
              "number" => "19119119100"
           ),
          "address"=>  array(
              "zip_code" => "06233200",
              "street_name" => "Av. das Nações Unidas",
              "street_number" => "3003",
              "neighborhood" => "Bonfim",
              "city" => "Osasco",
              "federal_unit" => "SP"
           )
        );


  				$payment->save();
          echo json_encode($payment->point_of_interaction);
 
 
 
      }else{
        echo json_encode(array(
          'status'  => 'error',
          'message' => 'pix required'
        ));
        exit;
      }

    }else{
      echo json_encode(array(
        'status'  => 'error',
        'message' => 'pix required'
      ));
      exit;
    }

  }else{
    echo json_encode(array(
      'status'  => 'error',
      'message' => 'post required'
    ));
    exit;
  }
