<section id="dashboardSec" class="w100 h100 dFlex flexColumn flexAlignCtr">

    <!-- User Data -->
    <h1 class="txtAlignCtr txtDarkBlue">
        <?php 
        if(isset($session['user_name']) && isset($session['user_surname'])) {
            echo 'Ciao ' . strtoupper($session['user_name']) .' '. strtoupper($session['user_surname']) . ' ecco i tuoi eventi';
        } else {
            echo 'Bentornato! Ecco i tuoi eventi';
        } 
        ?> 
    </h1>

    <!-- User Events -->
    <div class="w100 p2rem dFlex flexWrap flexSpaceEven flexAlignCtr">

        <?php if(isset($session['events']) && !empty($session['events'])) : ?>
            <?php foreach ($session['events'] as $event) : ?>
                <div class="bgWhite border radiusBox event">
                    <h2 class="txtDark"> <?= $event['nome_evento'] ?> </h2>
                    <p class="txtGray my1rem"> <?= date('d-m-Y H:i', strtotime($event['data_evento'])) ?></p>
                    <button class="radiusBtn w100 bgBlue txtWhite py08rem pointer btnBlueHov border"><strong>JOIN</strong></button>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="txtDarkBlue txtAlignCtr my2rem w50 txtLineH2rem"> <?= $session['error_message'] ?? 'Nessun evento da visualizzare' ?> </p>
        <?php endif; ?>

    </div>

</section>