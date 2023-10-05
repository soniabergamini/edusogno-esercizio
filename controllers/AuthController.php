<?php
class AuthController
{
    // PRIVATE FUNCTIONS
    private function getDBConnection()
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

    private function setErrorRedirect($errorTitle, $errorMessage, $url)
    {
        $_SESSION['error_title'] = $errorTitle;
        $_SESSION['error_message'] = $errorMessage;
        $this->redirect($url);
    }

    private function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    private function cleanSession()
    {
        $_SESSION['login'] = false;
        $_SESSION['login_error'] = null;
        $_SESSION['login_email'] = null;
        $_SESSION['error_title'] = null;
        $_SESSION['error_message'] = null;
    }

    private function checkRequest($requestMethod)
    {
        if ($requestMethod !== 'POST') {
            $this->setErrorRedirect(
                '⚠️ Errore Inatteso',
                'Si è verificato un errore nell\'elaborazione della tua richiesta. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.',
                '/404'
            );
        }
    }

    private function getUserByEmail($email)
    {
        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("SELECT id, email, password FROM utenti WHERE email = (?)");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $conn->close();
        return $result;
    }

    // PUBLIC FUNCTIONS
    public function login($session)
    {
        if (!$session['login']) {
            ob_start();
            include 'partials/main-login.php';
            $content = ob_get_clean();
            return $content;
        }
        $this->redirect('/dashboard');
    }

    public function loginProcess()
    {
        $this->cleanSession();
        $this->checkRequest($_SERVER['REQUEST_METHOD']);

        // HANDLES LOGIN REQUEST
        if (isset($_POST['email']) && isset($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            // CONNECT TO DATABASE
            $queryResult = $this->getUserByEmail($email);

            // CHECK LOGIN CREDENTIALS
            if ($queryResult) {
                $row = $queryResult->fetch_assoc();
                if ($row && $password === $row['password']) {
                    // Login successful
                    $_SESSION['login'] = true;
                    $this->redirect('/dashboard');
                } else {
                    // Login failed
                    $_SESSION['login_error'] = $row ? 'Password errata. Riprova!' : 'La tua email non è registrata. Riprova!';
                    $_SESSION['login_email'] = $email;
                    $this->redirect('/login');
                }
            } else {
                // Query error
                $_SESSION['login_error'] = 'Si è verificato un errore durante l\'accesso. Riprova!';
                $_SESSION['login_email'] = $email;
                $this->redirect('/login');
            }
        }
    }

    public function register()
    {
        return file_get_contents('partials/main-register.php');
    }

    public function registerProcess()
    {
    }
}
