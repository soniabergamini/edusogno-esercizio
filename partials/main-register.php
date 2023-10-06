<section id="registerSec" class="w100 h100 dFlex flexColumn flexAlignCtr">
    <h1 class="txtAlignCtr txtDarkBlue">Crea il tuo account</h1>

    <form id="registerForm" action="/registerProcess" method="POST" class="p2rem border radiusBox bgWhite w50">

        <!-- Error Message -->
        <div class="<?= isset($session['register_error']) && !empty($session['register_error']) ? 'dBlock alert' : 'dNone' ?>">
            <p class="txtAlignCtr pb03rem"><strong>🚫 Registrazione fallita:</strong></p>
            <ul>
                <?php foreach ($session['register_error'] as $error) : ?>
                    <li class="py03rem"> <?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Form Inputs & Submit -->
        <label class="dBlock txtSmall txtDark" for="name"><strong>Inserisci il nome</strong></label>
        <input class="dBlock mInput w100 borderInput" type="text" minlength="3" maxlength="55" pattern="/^[a-zA-ZÀ-ÿ\s'-]{3,55}$/u" name="name" id="name" placeholder="Mario" value="<?= $session['register_name'] ?? '' ?>" required>
        <label class="dBlock txtSmall txtDark" for="surname"><strong>Inserisci il cognome</strong></label>
        <input class="dBlock mInput w100 borderInput" type="text" minlength="3" maxlength="55" pattern="/^[a-zA-ZÀ-ÿ\s'-]{3,55}$/u" name="surname" id="surname" placeholder="Rossi" value="<?= $session['register_surname'] ?? '' ?>" required>
        <label class="dBlock txtSmall txtDark" for="email"><strong>Inserisci l'email</strong></label>
        <input class="dBlock mInput w100 borderInput" type="email" name="email" id="email" pattern="^[\w.-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$" placeholder="name@example.com" value="<?= $session['register_email'] ?? '' ?>" required>
        <label class="dBlock txtSmall txtDark" for="password"><strong>Inserisci la password</strong></label>
        <div class="dFlex flexAlignCtr w100 mInput borderInput">
            <input type="password" name="password" id="password" pattern="^(?=.*[a-z])(?=.*[A-Z])[\w@$!%*#?&]{8,}$" placeholder="Scrivila qui" required class="border0 flex1 pr2rem">
            <img id="passSecurity" src="../assets/img/EyeVector.png" alt="view-pass-icon" class="pointer">
        </div>
        <button type="submit" class="radiusBtn w100 bgBlue txtWhite py08rem border0 my2rem pointer"><strong>REGISTRATI</strong></button>

        <!-- Redirect to Login Route -->
        <p class="txtAlignCtr txtSmall txtPurple">
            <a href="/login">Ha già un account?<strong> Accedi</strong></a>
        </p>

    </form>

</section>