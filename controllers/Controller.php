<?php 
require_once __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
abstract class Controller {

    protected function getDBConnection()
    {
        $envFile = file_get_contents('.env');
        parse_str(str_replace(PHP_EOL, '&', $envFile), $env);
        $conn = null;
        $connError = null;
        try {
            $conn = new mysqli($env['DB_SERVERNAME'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_NAME'], $env['DB_PORT']);
        } catch (mysqli_sql_exception $e) {
            $connError = $e->getMessage();
        }
        if ($conn->connect_error || $connError !== null) {
            $this->setErrorRedirect(
                '🫤 Errore di connessione',
                'Si è verificato un errore nell\'elaborazione della tua richiesta. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.',
                '/404'
            );
            return;
        }
        return $conn;
    }

    protected function setErrorRedirect($errorTitle, $errorMessage, $url)
    {
        $_SESSION['error_title'] = $errorTitle;
        $_SESSION['error_message'] = $errorMessage;
        $this->redirect($url);
    }

    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    protected function getUserDataByEmail($email)
    {
        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("SELECT * FROM utenti WHERE email = (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        return $result;
    }

    protected function getAllEvents() 
    {
        $conn = $this->getDBConnection();
        $result = $conn->query("SELECT * FROM eventi");
        $conn->close();
        return $result;
    }

    protected function insertNewUserData($email, $password, $name, $surname)
    {
        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("INSERT into utenti (email, password, nome, cognome, ruolo) VALUES (?, ?, ?, ?, ?)");
        $ruolo = 'utente';
        $stmt->bind_param("sssss", $email, $password, $name, $surname, $ruolo);
        $stmt->execute();
        $errors = $stmt->error;
        $stmt->close();
        $conn->close();
        return $errors;
    }

    protected function insertResetPassToken($token, $email) {

        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("UPDATE utenti SET token = (?) WHERE email = (?)");
        $stmt->bind_param("ss", $token, $email);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    protected function updatePassword($token, $password, $email) {

        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("UPDATE utenti SET password = (?) WHERE token = (?) AND email = (?)");
        $stmt->bind_param("sss", $password, $token, $email);
        $result = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $result;
    }

    protected function cleanSession()
    {
        session_unset();
        $_SESSION['login'] = false;
    }

    protected function checkRequest($requestMethod)
    {
        if ($requestMethod !== 'POST') {
            $this->setErrorRedirect(
                '⚠️ Errore Inatteso',
                'Si è verificato un errore nell\'elaborazione della tua richiesta. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.',
                '/404'
            );
        }
    }

    protected function sendEmail($addressee, $link) {

        // Env Variabiles
        $envFile = file_get_contents('.env');
        parse_str(str_replace(PHP_EOL, '&', $envFile), $env);

        $newMail = new PHPMailer(true);
        try {

            // Server
            $newMail->isSMTP();
            $newMail->Host = $env['MAIL_HOST'];
            $newMail->SMTPAuth = true;
            $newMail->SMTPSecure = $env['MAIL_ENCRYPTION'];
            $newMail->Port = $env['MAIL_PORT'];
            $newMail->Username = $env['MAIL_USERNAME'];
            $newMail->Password = $env['MAIL_PASSWORD'];
            
            // Mail
            $newMail->setFrom('sounia96@outlook.it', $env['MAIL_FROM_NAME']);
            $newMail->addAddress($addressee);
            $newMail->isHTML(true);
            $newMail->Subject = 'Reimposta la tua password';
            $newMail->Body = 'Usa questo link per reimpostare la tua password: <a href="' . $link . '">Reset Password</a>';

            // Send
            $newMail->send();
            return true;

        } catch (Exception $e) {
            echo 'Errore durante l\'invio dell\'email: ', $newMail->ErrorInfo;
            return false;
        }

    }
}
?>