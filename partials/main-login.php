<section id="loginSec" class="w100 h100 dFlex flexColumn flexAlignCtr">
    <h1 class="txtAlignCtr txtDarkBlue">Hai già un account?</h1>

    <form id="loginForm" method="POST" action="/loginProcess" class="p2rem border radiusBox bgWhite w50">

        <!-- Error Message -->
        <div class="<?= isset($session['login_error']) && !empty($session['login_error']) ? 'dBlock alert' : 'dNone' ?>">
            <p class="txtAlignCtr">🚫 <?= $session['login_error'] ?></p>
        </div>

        <!-- Success Message -->
        <div class="<?= isset($session['success_resetpassword']) && !empty($session['success_resetpassword']) ? 'dBlock success' : 'dNone' ?>">
            <p class="txtAlignCtr">✅ <?= $session['success_resetpassword'] ?></p>
        </div>

        <!-- Form Inputs -->
        <label class="dBlock txtSmall txtDark" for="email"><strong>Inserisci l'email</strong></label>
        <input class="dBlock mInput w100 borderInput" type="email" name="email" id="email" placeholder="name@example.com" value="<?= $session['login_email'] ?? '' ?>" required>

        <label class="dBlock txtSmall txtDark" for="password"><strong>Inserisci la password</strong></label>
        <div class="dFlex flexAlignCtr w100 mInput borderInput">
            <input type="password" name="password" id="password" placeholder="Scrivila qui" required class="border0 flex1 pr2rem">
            <img id="passSecurity" src="../assets/img/EyeVector.png" alt="view-pass-icon" class="pointer">
        </div>

        <!-- Reset Password -->
        <p class="txtAlignR txtSmall">
            <a href="#" id="resetPass" class="txtDecNone txtRed txtSmall txtUnderHov">
                Password dimenticata? <strong>Clicca QUI</strong>
            </a>
        </p>
        
        <!-- Submit Button -->
        <button type="submit" class="radiusBtn w100 bgBlue txtWhite py08rem my2rem pointer btnBlueHov border"><strong>ACCEDI</strong></button>

        <!-- Redirect to Register Route -->
        <p class="txtAlignCtr txtSmall txtPurple">
            <a href="/register" class="txtDecNone changeColBlueHov">Non hai ancora un profilo? <strong class="txtUnderline">Registrati</strong></a>
        </p>

    </form>

</section>