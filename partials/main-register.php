<section id="registerSec" class="w100 h100 dFlex flexColumn flexAlignCtr">
    <h1 class="txtAlignCtr txtDarkBlue">Crea il tuo account</h1>
    <form id="registerForm" action="controllers/register.php" method="POST" class="p2rem border radiusBox bgWhite w50">
        <label class="dBlock txtSmall txtDark" for="name"><strong>Inserisci il nome</strong></label>
        <input class="dBlock mInput w100 borderInput" type="text" minlength="3" maxlength="55" name="name" id="name" placeholder="Mario" required>
        <label class="dBlock txtSmall txtDark" for="surname"><strong>Inserisci il cognome</strong></label>
        <input class="dBlock mInput w100 borderInput" type="text" minlength="3" maxlength="55" name="surname" id="surname" placeholder="Rossi" required>
        <label class="dBlock txtSmall txtDark" for="email"><strong>Inserisci l'email</strong></label>
        <input class="dBlock mInput w100 borderInput" type="email" name="email" id="email" pattern="^[\w.-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$" placeholder="name@example.com" required>
        <label class="dBlock txtSmall txtDark" for="password"><strong>Inserisci la password</strong></label>
        <div class="dFlex flexAlignCtr w100 mInput borderInput">
            <input type="password" name="password" id="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" placeholder="Scrivila qui" required class="border0 flex1 pr2rem">
            <img id="passSecurity" src="../assets/img/EyeVector.png" alt="view-pass-icon" class="pointer">
        </div>
        <button type="submit" class="radiusBtn w100 bgBlue txtWhite py08rem border0 my2rem pointer"><strong>REGISTRATI</strong></button>
        <p class="txtAlignCtr txtSmall txtPurple txtUnderline">Ha già un account <strong class="pointer">? Accedi</strong></p> <!-- remember hover -->
    </form>
</section>