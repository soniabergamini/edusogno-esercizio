<section id="notfoundSec" class="w100 h100 dFlex flexColumn flexAlignCtr">

    <!-- Not Found Message  -->
    <h1 class="txtAlignCtr txtDarkBlue"> <?= $session['error_title'] ?? 'Pagina non trovata' ?></h1>
    <p class="txtDarkBlue txtAlignCtr my2rem w50 txtLineH2rem"> <?= $session['error_message'] ?? '🔎 Ci dispiace, la pagina che hai cercato non esiste.'?> </p>

    <!-- Links -->
    <nav class="dFlex w50 gap1em flexJustyCtr">
        <a href="/login" class="radiusBtn bgBlue txtWhite pointer px1rem txtLarge txtAlignCtr w25 py03rem txtDecNone btnBlueHov border"><strong>ACCEDI</strong></a>
        <a href="/register" class="radiusBtn bgBlue txtWhite pointer px1rem txtLarge txtAlignCtr w25 py03rem txtDecNone btnBlueHov border"><strong>REGISTRATI</strong></a>
    </nav>

</section>