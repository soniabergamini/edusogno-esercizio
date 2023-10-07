<section id="dashboardSec" class="w100 h100 posRelative">

    <div class="w100 h100 dFlex flexColumn flexAlignCtr">

        <!-- Error Message -->
        <div class="<?= isset($session['event_error']) && !empty($session['event_error']) ? 'dBlock alert' : 'dNone' ?>">
            <p class="txtAlignCtr">🚫 <?= $session['event_error'] ?></p>
        </div>

        <!-- Admin Data -->
        <h1 class="txtAlignCtr txtDarkBlue">
            <?php 
            if(isset($session['user_name']) && isset($session['user_surname'])) {
                echo 'Ciao ' . strtoupper($session['user_name']) .' '. strtoupper($session['user_surname']) . ' ecco tutti gli eventi';
            } else {
                echo 'Bentornato! Ecco tutti gli eventi';
            } 
            ?> 
        </h1>

        <!-- Admin Dashboard Description -->
        <p class="txtDarkBlue txtAlignCtr w80 txtLineH2rem mt1rem"> In questa sezione puoi vedere e gestire tutti gli eventi EduSogno. Essendo un amministratore puoi modificare, cancellare e aggiungere nuovi eventi.</p>
    
        <!-- Add New Event Button -->
        <button id="addEventBtn" class="pointer mt1rem radiusBtn border0 boxShadow txtDarkBlue"><strong>➕ NUOVO EVENTO</strong></button>

        <!-- All Events -->
        <div class="w100 p2rem dFlex flexSpaceEven flexWrap txtAlignCtr">
    
            <?php if(isset($session['events']) && !empty($session['events'])) : ?>
                <?php foreach ($session['events'] as $event) : ?>
                    <div class="bgWhite border radiusBox event">
    
                        <!-- Event Details -->
                        <h2 class="txtDark"> <?= $event['nome_evento'] ?> </h2>
                        <div class="mt1rem mb2rem">
                            <p id="description"><?= $event['descrizione'] ?></p>
                            <p class="txtGray py03rem"> <?= date('d-m-Y H:i', strtotime($event['data_evento'])) ?></p>
                            <p class="txtDarkBlue py03rem">
                                <strong>Partecipanti: </strong>
                                <span><?= count(explode(',', $event['attendees'])) ?></span>
                            </p>
                        </div>
    
                        <!-- Edit Event Button -->
                        <button class="radiusBtn w100 bgBlue txtWhite py08rem pointer btnBlueHov border editBtn"
                        data-event-id="<?= $event['id'] ?>" 
                        data-event-name="<?= $event['nome_evento'] ?>" 
                        data-event-date="<?= $event['data_evento'] ?>" 
                        data-event-attendees="<?= $event['attendees'] ?>" 
                        data-event-description="<?= $event['descrizione'] ?>">
                            <strong>MODIFICA</strong>
                        </button>

                        <!-- Delete Event Button -->
                        <button class="radiusBtn w100 bgRed mt1rem txtWhite py08rem borderRed pointer btnRedHov deleteBtn" 
                        data-event-id="<?= $event['id'] ?>" 
                        data-event-name="<?= $event['nome_evento'] ?>" 
                        data-event-date="<?= $event['data_evento'] ?>" 
                        data-event-attendees="<?= $event['attendees'] ?>" 
                        data-event-description="<?= $event['descrizione'] ?>">
                            <strong>ELIMINA</strong>
                        </button>
    
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p class="txtDarkBlue my2rem w50 txtLineH2rem"> <?= $session['error_message'] ?? 'Nessun evento da visualizzare' ?> </p>
            <?php endif; ?>
    
        </div>

    </div>

    <!-- Delete Event Confirmation Form -->
    <div class="dNone bgWhite border radiusBox p2rem posAbsolute zIndex15 xyCenter" id="deleteForm">
        <form action="/event-destroy" method="POST">
            <p>
                Confermi di voler <strong>eliminare</strong> l'evento <strong id="formEventName"></strong> ?
            </p>
            <input type="hidden" name="eventID">
            <input type="hidden" name="eventAttendees">
            <input type="hidden" name="eventName">
            <input type="hidden" name="eventDate">
            <input type="hidden" name="eventDescription">
            <div class="dFlex flexSpaceBtw mt1rem">
                <button id="closeBtn" class="radiusBtn w45 bgBlue txtWhite py03rem border pointer btnRedHov">ANNULLA</button>
                <button type="submit" class="radiusBtn w45 bgRed txtWhite py03rem borderRed pointer btnRedHov">ELIMINA</button>
            </div>
        </form>
    </div>

    <!-- Edit Event Form -->
    <div class="dNone bgWhite border radiusBox p2rem posAbsolute zIndex15 xyCenter w50" id="editForm">
        <form action="/event-edit" method="POST">
            <p class="txtAlignCtr txtDarkBlue txtLarge"><strong>Modifica Evento</strong></p>
            <input type="hidden" name="eventID">

            <label class="dBlock txtSmall txtDark" for="eventName"><strong>Nome</strong></label>
            <input class="dBlock mInput w100 borderInput" type="text" minlength="3" maxlength="55" name="eventName" id="eventName" required>

            <label class="dBlock txtSmall txtDark" for="eventDescription"><strong>Description</strong></label>
            <input class="dBlock mInput w100 borderInput" type="text" minlength="3" name="eventDescription" id="eventDescription" required>

            <label class="dBlock txtSmall txtDark" for="eventAttendees"><strong>Attendees</strong></label>
            <input class="dBlock mInput w100 borderInput" type="text" minlength="3" name="eventAttendees" id="eventAttendees" required>

            <label class="dBlock txtSmall txtDark" for="eventDate"><strong>Date</strong></label>
            <input class="dBlock mInput w100 borderInput" type="date" minlength="3" name="eventDate" id="eventDate" required>

            <label class="dBlock txtSmall txtDark" for="eventTime"><strong>Time</strong></label>
            <input class="dBlock mInput w100 borderInput" type="time" minlength="3" name="eventTime" id="eventTime" required>

            <div class="dFlex flexSpaceBtw mt1rem">
                <button id="btnClose" class="radiusBtn w45 bgBlue txtWhite py03rem border pointer btnRedHov">ANNULLA</button>
                <button type="submit" class="radiusBtn w45 bgRed txtWhite py03rem borderRed pointer btnRedHov">SALVA</button>
            </div>

        </form>
    </div>

    <!-- New Event Form -->
    <div class="dNone bgWhite border radiusBox p2rem posAbsolute zIndex15 xyCenter w50" id="createForm">
        <form action="/event-create" method="POST">
            <p class="txtAlignCtr txtDarkBlue txtLarge"><strong>Nuovo Evento</strong></p>

            <label class="dBlock txtSmall txtDark" for="eventName"><strong>Nome</strong></label>
            <input class="dBlock mInput w100 borderInput" type="text" minlength="3" maxlength="55" name="eventName" id="eventName" required>

            <label class="dBlock txtSmall txtDark" for="eventDescription"><strong>Description</strong></label>
            <input class="dBlock mInput w100 borderInput" type="text" minlength="3" name="eventDescription" id="eventDescription" required>

            <label class="dBlock txtSmall txtDark" for="eventAttendees"><strong>Attendees</strong></label>
            <input class="dBlock mInput w100 borderInput" type="text" minlength="3" name="eventAttendees" id="eventAttendees">

            <label class="dBlock txtSmall txtDark" for="eventDate"><strong>Date</strong></label>
            <input class="dBlock mInput w100 borderInput" type="date" minlength="3" name="eventDate" id="eventDate" required>

            <label class="dBlock txtSmall txtDark" for="eventTime"><strong>Time</strong></label>
            <input class="dBlock mInput w100 borderInput" type="time" minlength="3" name="eventTime" id="eventTime" required>

            <div class="dFlex flexSpaceBtw mt1rem">
                <button id="btnCancel" class="radiusBtn w45 bgBlue txtWhite py03rem border pointer btnRedHov">ANNULLA</button>
                <button type="submit" class="radiusBtn w45 bgRed txtWhite py03rem borderRed pointer btnRedHov">CREA</button>
            </div>

        </form>
    </div>

</section>