<section id="loginSec" class="w100 h100 dFlex flexColumn flexAlignCtr">
    <h1 class="txtAlignCtr txtDarkBlue">Hai già un account?</h1>
    <form id="loginForm" action="controllers/login.php" method="POST" class="p2rem border radiusBox bgWhite w50">
        <label class="dBlock txtSmall txtDark" for="email"><strong>Inserisci l'email</strong></label>
        <input class="dBlock mInput w100 borderInput" type="email" name="email" id="email" pattern="^[\w.-]+@[a-zA-Z0-9-]+(?:.[a-zA-Z0-9-]+)*$" placeholder="name@example.com" required>
        <label class="dBlock txtSmall txtDark" for="password"><strong>Inserisci la password</strong></label>
        <div class="dFlex flexAlignCtr w100 mInput borderInput">
            <input type="password" name="password" id="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" placeholder="Scrivila qui" required class="border0 flex1 pr2rem">
            <img id="passSecurity" src="../assets/img/EyeVector.png" alt="view-pass-icon" class="pointer">
        </div>
        <button type="submit" class="radiusBtn w100 bgBlue txtWhite py08rem border0 my2rem pointer"><strong>ACCEDI</strong></button>
        <p class="txtAlignCtr txtSmall txtPurple">Non hai ancora un profilo? <strong class="pointer txtUnderline">Registrati</strong></p>
    </form>
</section>