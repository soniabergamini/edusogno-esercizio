<?php 
require_once __DIR__ . '/../models/Event.php';
require_once 'controllers/Controller.php';

class EventController extends Controller {

    public function createEvent() {

    }

    public function editEvent() {
        if (isset($_POST['eventID']) && isset($_POST['eventAttendees']) && isset($_POST['eventName']) && isset($_POST['eventDate']) && isset($_POST['eventTime']) && isset($_POST['eventDescription'])) {

            // Set event data and update
            $eventDate = $_POST['eventDate'] . ' ' . $_POST['eventTime'];
            $event = new Event($_POST['eventName'], $eventDate, $_POST['eventAttendees'], $_POST['eventDescription']);
            $event->setEventName($_POST['eventName']);
            $event->setEventDate($eventDate);
            $event->setEventAttendees($_POST['eventAttendees']);
            $event->setEventDescription($_POST['eventDescription']);
            $errors = $event->updateEvent($_POST['eventID']);

            if(!$errors) {
                $_SESSION['refresh'] = false;
                $this->redirect('/dashboard');
            }else {
                $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato possibile aggiornare l\'evento. Riprova più tardi.';
                $this->redirect('/dashboard');
            }

        }
        $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato aggiornare l\'evento. Riprova più tardi.';
        $this->redirect('/dashboard');
    }

    public function destroyEvent() {
        if (isset($_POST['eventID']) && isset($_POST['eventAttendees']) && isset($_POST['eventName']) && isset($_POST['eventDate']) && isset($_POST['eventDescription'])) {

            $event = new Event($_POST['eventName'], $_POST['eventDate'], $_POST['eventAttendees'], $_POST['eventDescription']);
            $errors = $event->deleteEvent($_POST['eventID']);

            if(!$errors) {
                $_SESSION['refresh'] = false;
                $this->redirect('/dashboard');
            }else {
                $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato possibile cancellare l\'evento. Riprova più tardi.';
                $this->redirect('/dashboard');
            }
        }
        $_SESSION['event_error'] = '🫤 Errore Inatteso. Non è stato possibile cancellare l\'evento. Riprova più tardi.';
        $this->redirect('/dashboard');
    }    
}

?>