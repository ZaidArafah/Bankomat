<?php

declare(strict_types= 1);

session_start();

// ladda in databasekoplingen, och alla våra klasser.
$pdo = require __DIR__. '/../src/db.php';
require_once __DIR__. '/../src/helpers.php';
require_once __DIR__. '/../src/UserRepository.php';
require_once __DIR__. '/../src/AccountRepository.php';
require_once __DIR__. '/../src/TransactionRepository.php';

// skapa instanser av våra repositories.
$userRepo = new UserRepository($pdo);
$accountRepo = new AccountRepository($pdo);
$transactionRepo = new TransactionRepository($pdo);

// säkerhetsfunktion för csrf token, och skapa en token om den inte finns.
csrf_token();

// hämtar ut vilken sida vill användaren besöka.
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


// Inloggningssida.
switch ($path) {
    case '/':
        case '/login':
            if($method === 'POST') {
                $card = trim($_POST['card_number'] ?? '');
                $pin = $_POST['pin'] ?? '';
                $user = $userRepo->findbycardnumber($card);
                if ($user && password_verify($pin, $user['pin_hash'])) {
                    session_regenerate_id(true);    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['role'] = $user['role'];
                    
                    header('Location: /dashboard');
                    exit;
                }
                $error = "Invalid card number or PIN.";
            }
            require __DIR__. '/../templates/login.php';
            break;


//------------------------huvudmeny.------------------
            case '/dashboard':
                require_login();
                $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);
                require __DIR__. '/../templates/dashboard.php';
                break;

                
//---------------------- insättning----------------------.
                case '/deposit':
                    require_login();
                    $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);
                    if ($method === 'POST') {
                        
                        $accid = (int)$_POST['account_id'] ?? 0;
        
                        $amount = (float)$_POST['amount'] ?? 0;
                        $account = $accountRepo->findByIdanduserId($accid, (int)$_SESSION['user_id']);
                        if ($account) {
                            try {
                                $transactionRepo->deposit($accid, $amount);
                                $success = "Deposit successful.";
                            } catch (Exception $e) {
                                $error = $e->getMessage();
                            }
                        }else {
                            $error = "Invalid account selection.";
                        }
                        $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);
                    }
                    require __DIR__. '/../templates/deposit.php';
                    break;


// ---------------------uttag-----------------------             
case '/withdraw':
    require_login();
    $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);
    if ($method === 'POST') {
        $accid = (int)$_POST['account_id'] ?? 0;
        $amount = (float)$_POST['amount'] ?? 0;
        $account = $accountRepo->findByIdanduserId($accid, (int)$_SESSION['user_id']);
        if ($account) {
            try {
                $transactionRepo->withdraw($accid, $amount);
                $success = "Withdrawal successful.";
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }else {
            $error = "Invalid account selection.";
        }
        $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);
    }
    require __DIR__. '/../templates/withdraw.php';
    break;



//---------------- överföring mellan egna konton.-----------------------  
    case '/transfer':
    require_login();
    
        $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);
        if ($method === 'POST') {
            $from_accid = (int)$_POST['from_account_id'] ?? 0;
            $to_accid = (int)$_POST['to_account_id'] ?? 0;   
         $amount = (float)$_POST['amount'] ?? 0;
       
            $fromaccount = $accountRepo->findByIdanduserId($from_accid, (int)$_SESSION['user_id']);
            $toaccount = $accountRepo->findByIdanduserId($to_accid, (int)$_SESSION['user_id']);
            if ($fromaccount && $toaccount) {
                try {   
                    $transactionRepo->transfer($from_accid, $to_accid, $amount);
                    $success = "Transfer for $amount successful.";
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }else {
                $error = "you can only transfer between your own accounts.";
            }
            $accounts = $accountRepo->findByUserId((int)$_SESSION['user_id']);   
        }
        require __DIR__. '/../templates/transfer.php';
        break;   
    }
?>
