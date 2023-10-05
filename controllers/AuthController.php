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
        $_SESSION['register_error'] = null;
        $_SESSION['register_email'] = null;
        $_SESSION['register_name'] = null;
        $_SESSION['register_surname'] = null;
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

    private function insertNewUserData($email, $password, $name, $surname)
    {
        // Prepared Statements
        $conn = $this->getDBConnection();
        $stmt = $conn->prepare("INSERT into utenti (email, password, nome, cognome) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $password, $name, $surname);
        $stmt->execute();
        $errors = $stmt->error;
        $stmt->close();
        $conn->close();
        return $errors;
    }

    private function registrationError($message, $email, $name, $surname)
    {
        $_SESSION['register_error'] = $message;
        $_SESSION['register_email'] = $email;
        $_SESSION['register_name'] = $name;
        $_SESSION['register_surname'] = $surname;
        $this->redirect('/register');
    }

    private function loadContent($session, $contentPath)
    {
        if (!$session['login']) {
            ob_start();
            include_once $contentPath;
            return ob_get_clean();
        }
        $this->redirect('/dashboard');
    }

    // PUBLIC FUNCTIONS
    public function login($session)
    {
        return $this->loadContent($session, 'partials/main-login.php');
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

    public function register($session)
    {
        return $this->loadContent($session, 'partials/main-register.php');
    }

    public function registerProcess()
    {
        $this->cleanSession();
        $this->checkRequest($_SERVER['REQUEST_METHOD']);

        // HANDLES REGISTER REQUEST
        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['surname'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $_SESSION['register_error'] = [];

            // VALIDATION
            $validationError = [];
            $validationFilters = [
                [
                    // Invalid name/surname
                    'condition' => !preg_match("/^[a-zA-ZÀ-ÿ\s'-]{3,55}$/u", $name) || !preg_match("/^[a-zA-ZÀ-ÿ\s'-]{3,55}$/u", $surname),
                    'message' => 'Dati non validi. Inserisci un nome e un cognome di almeno 3 caratteri di lunghezza, evitando i caratteri speciali.'
                ],
                [
                    // Invalid email
                    'condition' => !filter_var($email, FILTER_VALIDATE_EMAIL),
                    'message' => 'L\'indirizzo email inserito, non è valido.'
                ],
                [
                    // Invalid password
                    'condition' => !preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password),
                    'message' => 'Password non valida. Inserisci una password di almeno 8 caratteri, composta da lettere minuscole, maiuscole e numeri.'
                ]
            ];
            foreach ($validationFilters as $filter) {
                $filter['condition'] && $validationError[] = $filter['message'];
            }
            $validationError && $this->registrationError($validationError, $email, $name, $surname);

            // CONNECT TO DATABASE
            $queryResult = $this->getUserByEmail($email);

            // VERIFY EMAIL UNIQUENESS
            if ($queryResult) {
                $row = $queryResult->fetch_assoc();
                // die("Row data: " . print_r($row, true));
                if ($row) {
                    // Email already taken
                    $this->registrationError('Email già registrata. Riprova con una mail diversa oppure esegui l\'accesso!', $email, $name, $surname);
                }
            }

            // USER REGISTRATION & REDIRECT
            $registrationErrors = $this->insertNewUserData($email, $password, $name, $surname);

            if (!$registrationErrors) {
                // Registration successful
                $_SESSION['login'] = true;
                $this->redirect('/dashboard');
            } else {
                // Registration failed
                $this->registrationError('Si è verificato un errore durante la registrazione. Riprova!', $email, $name, $surname);
            }
        }
    }
}
