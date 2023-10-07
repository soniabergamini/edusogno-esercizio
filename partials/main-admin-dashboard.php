<section id="dashboardSec" class="w100 h100 dFlex flexColumn flexAlignCtr">

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
    <div class="w100 p2rem dFlex flexSpaceEven flexAlignCtr flexWrap txtAlignCtr">

        <?php if(isset($session['events']) && !empty($session['events'])) : ?>
            <?php foreach ($session['events'] as $event) : ?>
                <div class="bgWhite border radiusBox event">
                    <h2 class="txtDark"> <?= $event['nome_evento'] ?> </h2>
                    <div class="mt1rem mb2rem">
                        <p class="txtGray py03rem"> <?= date('d-m-Y H:i', strtotime($event['data_evento'])) ?></p>
                        <p class="txtDarkBlue py03rem">
                            <strong>Partecipanti: </strong>
                            <span><?= count(explode(',', $event['attendees'])) ?></span>
                        </p>
                    </div>
                    <button class="radiusBtn w100 bgBlue txtWhite py08rem pointer btnBlueHov border"><strong>MODIFICA</strong></button>
                    <button class="radiusBtn w100 bgRed mt1rem txtWhite py08rem borderRed pointer btnRedHov"><strong>ELIMINA</strong></button>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="txtDarkBlue my2rem w50 txtLineH2rem"> <?= $session['error_message'] ?? 'Nessun evento da visualizzare' ?> </p>
        <?php endif; ?>

    </div>

</section>