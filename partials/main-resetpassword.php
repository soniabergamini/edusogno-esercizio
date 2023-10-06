<section id="resetPassSec" class="w100 h100 dFlex flexColumn flexAlignCtr">
    <h1 class="txtAlignCtr txtDarkBlue">Reimposta la password</h1>

    <form id="resetPassForm" action="/newPasswordProcess" method="POST" class="p2rem border radiusBox bgWhite w50">

        <!-- Error Message -->
        <div class="<?= isset($session['login_error']) && !empty($session['login_error']) ? 'dBlock alert' : 'dNone' ?>">
            <p class="txtAlignCtr">🚫 <?= $session['login_error'] ?></p>
        </div>

        <!-- Form Input -->
        <label class="dBlock txtSmall txtDark" for="password"><strong>Inserisci la nuova password</strong></label>
        <div class="dFlex flexAlignCtr w100 mInput borderInput">
            <input type="password" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])[\w@$!%*#?&]{8,}$" placeholder="Scrivila qui" required class="border0 flex1 pr2rem">
            <img id="passSecurity" src="../assets/img/EyeVector.png" alt="view-pass-icon" class="pointer">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="radiusBtn w100 bgBlue txtWhite py08rem border0 my2rem pointer"><strong>SALVA</strong></button>
        
    </form>

</section>