<section id="loginSec" class="w100 h100 dFlex flexColumn flexAlignCtr">
    <h1 class="txtAlignCtr txtDarkBlue">Hai già un account?</h1>

    <form id="loginForm" method="POST" action="/loginProcess" class="p2rem border radiusBox bgWhite w50">

        <!-- Error Message -->
        <div class="<?= isset($session['login_error']) && !empty($session['login_error']) ? 'dBlock alert' : 'dNone' ?>">
            <p class="txtAlignCtr">🚫 <?= $session['login_error'] ?></p>
        </div>

        <!-- Form Inputs & Submit -->
        <label class="dBlock txtSmall txtDark" for="email"><strong>Inserisci l'email</strong></label>
        <input class="dBlock mInput w100 borderInput" type="email" name="email" id="email" placeholder="name@example.com" value="<?= $session['login_email'] ?? '' ?>" required>
        <label class="dBlock txtSmall txtDark" for="password"><strong>Inserisci la password</strong></label>
        <div class="dFlex flexAlignCtr w100 mInput borderInput">
            <input type="password" name="password" id="password" placeholder="Scrivila qui" required class="border0 flex1 pr2rem">
            <img id="passSecurity" src="../assets/img/EyeVector.png" alt="view-pass-icon" class="pointer">
        </div>
        <button type="submit" class="radiusBtn w100 bgBlue txtWhite py08rem border0 my2rem pointer"><strong>ACCEDI</strong></button>

        <!-- Redirect to Register Route -->
        <p class="txtAlignCtr txtSmall txtPurple">
            <a href="/register" class="txtDecNone">Non hai ancora un profilo? <strong class="txtUnderline">Registrati</strong></a>
        </p>

    </form>

</section>