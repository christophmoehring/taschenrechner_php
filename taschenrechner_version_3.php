
<?php
session_start();

if (isset($_POST["op1"])) {
    $operand1 = $_POST["op1"];
}
else {
    $operand1 = 0;
}
if (isset($_POST["op2"])) {
    $operand2 = $_POST["op2"];
}
else {
    $operand2 = 0;
}

$ergebnis = 0;
if (isset($_POST["submit"]))
  switch ($_POST["submit"]) {
    case "berechnen":
      $ergebnis = $operand1 + $operand2;
      if (isset($_SESSION["resultHistory"])) {
        $_SESSION["resultHistory"][] = $ergebnis;
      }
      else {
        $_SESSION["resultHistory"] = array($ergebnis);
      }
      break;
    case "memory_set":
      $_SESSION["memory"] = $_POST["ergebnis"];
      $ergebnis = $_POST["ergebnis"];
      break;
    case "memory_read":
      $operand1 = $_SESSION["memory"];
      break;
    case "clear_results":
      unset($_SESSION["resultHistory"]);
      // intentional fallthrough
    case "reset":
      $operand1 = "";
      $operand2 = "";
      $ergebnis = "";
      break;
  }

?>

<html>
<body>
  <title>Gustavs toller Taschenrechner</title>

  <!-- "style" zeug ist CSS und muss uns jetzt noch nicht interessieren -->
  <h1 style="text-align: center;">
    Taschenrechner
  </h1>

  <form id="taschenrechner"
  name="taschenrechner" method="POST">
  <table>
    <tr>
      <td colspan="4">
        <select name="resultHistory" multiple>
          <!-- here goes php -->
          <!-- wenn wir berechnen, speichern wir das neue Ergebnis in einer Liste -->
          <!-- hier geben wir die Liste aus -->
          <?php
            if (isset($_SESSION["resultHistory"]))
              foreach ($_SESSION["resultHistory"] as $result) {
                echo "<option>".$result."</option>";
              }
          ?>
        </select>
      </td>
    </tr>

    <tr>
      <td>Operand 1</td>
      <td>Operator</td>
      <td>Operand 2</td>
      <td>Ergebnis</td>
    </tr>

    <tr>
      <td>
        <input type="number" name="op1" value="<?php echo $operand1 ?>">
      </td>
      <td> + </td>
      <td>
        <input type="number" name="op2" value="<?php echo $operand2 ?>">
      </td>
      <td>
        =
        <input type="number" name="ergebnis" value= "<?php echo $ergebnis ?>">
      </td>
    </tr>
  </table>

    <button form="taschenrechner"
            type="submit" value="berechnen" name="submit">
      Berechnen
    </button>
    <br>
    <!-- eigentlich sollte man das so machen -->
    <!-- <input type="reset" value="C" name="reset"> -->
    <button form="taschenrechner"
            type="reset" value="reset" name="submit">
      C
    </button>
    <br>
    <button form="taschenrechner"
            type="submit" value="clear_results" name="submit">
      RC
    </button>
    <br>
    <button form="taschenrechner"
            type="submit" value="memory_set" name="submit">
      M+
    </button>
    <br>
    <button form="taschenrechner"
            type="submit" value="memory_read" name="submit">
      MR
    </button>
  </form>
</body>
</html>