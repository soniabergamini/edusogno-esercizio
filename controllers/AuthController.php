<?php
class AuthController
{
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
            $dbResult = $this->getDBConnection();
            [$conn, $connError] = $dbResult;

            // CHECK CONNECTION
            if ($conn === null || $connError !== null) {

                $_SESSION['error_title'] = 'Errore di connessione';
                $_SESSION['error_message'] = 'Si è verificato un errore nell\'elaborazione della tua richiesta. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.';
                $this->redirect('/404', $conn);

            } else {

                // Prepared Statements
                $stmt = $conn->prepare("SELECT id, email, password FROM utenti WHERE email = (?)");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $queryResult = $stmt->get_result();

                // Check Login Credentials
                if ($queryResult) {
                    $row = $queryResult->fetch_assoc();
                    if ($row && $password === $row['password']) {
                        // Login successful
                        $_SESSION['login'] = true;
                        $this->redirect('/dashboard', $conn);
                    } else if ($row) {
                        // Incorrect password
                        $_SESSION['login_error'] = 'Password errata. Riprova!';
                    } else {
                        // Query returns 0 results
                        $_SESSION['login_error'] = 'La tua email non è registrata. Riprova!'; 
                    }
                    $_SESSION['login_email'] = $email;
                    $this->redirect('/login', $conn);
                } else {
                    // Query error
                    $_SESSION['login_error'] = 'Si è verificato un errore durante l\'accesso. Riprova!';
                    $_SESSION['login_email'] = $email;
                    $this->redirect('/login', $conn);
                }
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

    private function getDBConnection()
    {
        $envFile = file_get_contents('.env');
        parse_str(str_replace(PHP_EOL, '&', $envFile), $env);
        $conn = null;
        $connError = null;
        try {
            $conn = new mysqli($env['DB_SERVERNAME'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_NAME'], $env['DB_PORT']);
            $conn->connect_error && $connError = $conn->connect_error;
        } catch (mysqli_sql_exception $e) {
            $connError = $e->getMessage();
        }
        $result = [$conn, $connError];
        return $result;
    }

    private function checkRequest($requestMethod)
    {
        if ($requestMethod !== 'POST') {
            $_SESSION['error_title'] = '⚠️ Errore Inatteso';
            $_SESSION['error_message'] = 'Si è verificato un errore nell\'elaborazione della tua richiesta. Ci dispiace per l\'inconveniente, cercheremo di risolverlo il prima possibile. Per favore riprova più tardi.';
            header('Location: /404');
            exit();
        }
    }

    private function cleanSession() {
        $_SESSION['login'] = false;
        $_SESSION['login_error'] = null;
        $_SESSION['login_email'] = null;
        $_SESSION['error_title'] = null;
        $_SESSION['error_message'] = null;
    }

    private function redirect($url, $conn = null) {
        if ($conn !== null) {
            $conn->close();
        }
        header('Location: ' . $url);
        exit();
    }
}
